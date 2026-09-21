<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import apiClient from '../services/api'

const router = useRouter()
const route = useRoute()

// 編集画面かどうか(URLに :id があるかどうかで判定)
const goodsId = route.params.id
const isEditMode = computed(() => !!goodsId)

const tours = ref([])
const imagePreview = ref(null)
const imageFile = ref(null)

const onImageChange = (event) => {
  const file = event.target.files[0]
  if (!file) return

  imageFile.value = file
  imagePreview.value = URL.createObjectURL(file)
}

// コンボボックスで「+ 新しいツアーを追加」を選んだときだけ入力欄を出す
const selectedTour = ref('')
const newTourName = ref('')
const newTourStartDate = ref('')
const newTourEndDate = ref('')
const name = ref('')
const category = ref('')
const price = ref('')
const description = ref('')
const isNewTour = computed(() => selectedTour.value === '__new__')

onMounted(async () => {
  const toursResponse = await apiClient.get('/tours')
  tours.value = toursResponse.data

  if (isEditMode.value) {
    const goodsResponse = await apiClient.get(`/goods/${goodsId}`)
    const goods = goodsResponse.data

    selectedTour.value = goods.tour_id
    name.value = goods.name
    category.value = goods.category
    price.value = goods.price
    description.value = goods.description ?? ''
    if (goods.image_path) {
      imagePreview.value = `http://localhost/storage/${goods.image_path}`
    }
  }
})

const onSubmit = async () => {
  const formData = new FormData()
  formData.append('name', name.value)
  formData.append('category', category.value)
  formData.append('price', price.value)
  formData.append('description', description.value)
  formData.append('purchase_status', 'unpurchased')
  if (selectedTour.value === '__new__') {
    formData.append('new_tour_name', newTourName.value)
    formData.append('new_tour_start_date', newTourStartDate.value)
    formData.append('new_tour_end_date', newTourEndDate.value)
  } else {
    formData.append('tour_id', selectedTour.value)
  }

  if (imageFile.value) {
    formData.append('image', imageFile.value)
  }

  if (isEditMode.value) {
    // FormDataで画像を送りつつ更新するため、PUTではなくPOST+_methodで送る(Laravelのお作法)
    formData.append('_method', 'PUT')
    await apiClient.post(`/goods/${goodsId}`, formData)
  } else {
    await apiClient.post('/goods', formData)
  }

  router.push('/tours')
}
</script>

<template>
  <main class="goods-form">
    <header class="goods-form__header">
      <p class="goods-form__eyebrow">{{ isEditMode ? 'GOODS EDIT' : 'GOODS REGISTER' }}</p>
      <h1 class="goods-form__title">{{ isEditMode ? 'グッズ編集' : 'グッズ登録' }}</h1>
    </header>

    <form class="goods-form__body" @submit.prevent="onSubmit">
      <div class="form-row">
        <label class="form-row__label" for="image">画像</label>
        <label class="image-upload" for="image">
          <img v-if="imagePreview" :src="imagePreview" class="image-upload__preview" />
          <span v-else class="image-upload__placeholder">
            <span class="image-upload__icon">+</span>
            <span>画像を選択</span>
          </span>
        </label>
        <input id="image" type="file" accept="image/*" class="image-upload__input" @change="onImageChange" />
      </div>

      <div class="form-row">
        <label class="form-row__label" for="tour">ツアー</label>
        <select id="tour" class="form-row__input" v-model="selectedTour">
          <option disabled value="">選択してください</option>
          <option v-for="tour in tours" :key="tour.id" :value="tour.id">{{ tour.name }}</option>
          <option value="__new__">+ 新しいツアーを追加</option>
        </select>

        <template v-if="isNewTour">
          <input
            type="text"
            class="form-row__input"
            v-model="newTourName"
            placeholder="新しいツアー名を入力"
          />
          <div class="tour-date-range">
            <input type="date" class="form-row__input" v-model="newTourStartDate" />
            <span class="tour-date-range__wave">〜</span>
            <input type="date" class="form-row__input" v-model="newTourEndDate" />
          </div>
        </template>
      </div>

      <div class="form-row">
        <label class="form-row__label" for="name">グッズ名</label>
        <input id="name" type="text" class="form-row__input" v-model="name" placeholder="例) アクリルスタンド" />
      </div>

      <div class="form-row">
        <label class="form-row__label" for="category">カテゴリ</label>
        <input id="category" type="text" class="form-row__input" v-model="category" placeholder="例) グッズ / アパレル" />
      </div>

      <div class="form-row">
        <label class="form-row__label" for="price">金額</label>
        <input id="price" type="number" class="form-row__input" v-model="price" placeholder="例) 1800" />
      </div>

      <div class="form-row">
        <label class="form-row__label" for="description">メモ</label>
        <textarea id="description" class="form-row__input form-row__input--textarea" v-model="description" rows="4"></textarea>
      </div>

      <div class="goods-form__actions">
        <button type="submit" class="goods-form__submit">{{ isEditMode ? '更新する' : '登録する' }}</button>
      </div>
    </form>
  </main>
</template>

<style scoped>
.goods-form {
  width: 100%;
  max-width: 560px;
  margin: 0 auto;
  padding: 48px 24px 80px;
  background-color: #fdfdfb;
  color: #1a1a1a;
  font-family: 'Noto Sans JP', 'Hiragino Sans', sans-serif;
  box-sizing: border-box;
}

.goods-form__header {
  text-align: center;
  margin-bottom: 40px;
  padding-bottom: 24px;
  border-bottom: 2px solid #1a1a1a;
}

.goods-form__eyebrow {
  margin: 0 0 8px;
  font-size: 12px;
  letter-spacing: 0.4em;
  color: #6b6b6b;
  font-family: Georgia, serif;
}

.goods-form__title {
  margin: 0;
  font-size: 24px;
  letter-spacing: 0.1em;
}

.goods-form__body {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.form-row {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-row__label {
  font-size: 12px;
  letter-spacing: 0.2em;
  color: #6b6b6b;
  font-family: Georgia, serif;
}

.form-row__input {
  padding: 12px 14px;
  border: 1px solid #d8d8d4;
  background-color: #fff;
  font-family: inherit;
  font-size: 15px;
  color: #1a1a1a;
}

.form-row__input:focus {
  outline: none;
  border-color: #1a1a1a;
}

.form-row__input--textarea {
  resize: vertical;
}

.tour-date-range {
  display: flex;
  align-items: center;
  gap: 10px;
}

.tour-date-range .form-row__input {
  flex: 1;
}

.tour-date-range__wave {
  color: #a8a8a2;
}


.image-upload {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  aspect-ratio: 4 / 3;
  max-width: 280px;
  border: 1px dashed #a8a8a2;
  background-color: #f2f1ec;
  cursor: pointer;
  overflow: hidden;
}

.image-upload__placeholder {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  color: #6b6b6b;
  font-size: 13px;
  letter-spacing: 0.05em;
}

.image-upload__icon {
  font-size: 28px;
  line-height: 1;
  color: #a8a8a2;
  font-family: Georgia, serif;
}

.image-upload__preview {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.image-upload__input {
  display: none;
}

.goods-form__actions {
  margin-top: 16px;
}

.goods-form__submit {
  width: 100%;
  padding: 14px;
  background-color: #1a1a1a;
  color: #fdfdfb;
  border: 1px solid #1a1a1a;
  font-family: inherit;
  font-size: 15px;
  letter-spacing: 0.1em;
  cursor: pointer;
  transition: opacity 0.2s ease;
}

.goods-form__submit:hover {
  opacity: 0.8;
}
</style>
