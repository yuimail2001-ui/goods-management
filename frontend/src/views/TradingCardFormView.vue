<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import apiClient from '../services/api'

const router = useRouter()
const route = useRoute()

const cardId = route.params.id
const isEditMode = computed(() => !!cardId)

const tours = ref([])
const imagePreview = ref(null)
const imageFile = ref(null)

const selectedTour = ref('')
const memberName = ref('')
const description = ref('')
const ownedCount = ref(0)
const existingCardCode = ref('')

const onImageChange = (event) => {
  const file = event.target.files[0]
  if (!file) return

  imageFile.value = file
  imagePreview.value = URL.createObjectURL(file)
}

onMounted(async () => {
  const toursResponse = await apiClient.get('/tours')
  tours.value = toursResponse.data

  if (isEditMode.value) {
    const cardResponse = await apiClient.get(`/trading-cards/${cardId}`)
    const card = cardResponse.data

    existingCardCode.value = card.card_code
    selectedTour.value = card.tour_id
    memberName.value = card.member_name
    description.value = card.description ?? ''
    ownedCount.value = card.owned_count
    if (card.image_path) {
      imagePreview.value = `http://localhost/storage/${card.image_path}`
    }
  }
})

const onSubmit = async () => {
  const formData = new FormData()
  formData.append('tour_id', selectedTour.value)
  formData.append('member_name', memberName.value)
  formData.append('description', description.value)
  formData.append('owned_count', ownedCount.value)

  if (imageFile.value) {
    formData.append('image', imageFile.value)
  }

  if (isEditMode.value) {
    formData.append('_method', 'PUT')
    await apiClient.post(`/trading-cards/${cardId}`, formData)
  } else {
    await apiClient.post('/trading-cards', formData)
  }

  router.push('/trading-cards')
}
</script>

<template>
  <main class="card-form">
    <header class="card-form__header">
      <p class="card-form__eyebrow">{{ isEditMode ? 'CARD EDIT' : 'CARD REGISTER' }}</p>
      <h1 class="card-form__title">{{ isEditMode ? 'トレカ編集' : 'トレカ登録' }}</h1>
      <p v-if="isEditMode" class="card-form__id" translate="no">ID: {{ existingCardCode }}</p>
    </header>

    <form class="card-form__body" @submit.prevent="onSubmit">
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
        </select>
      </div>

      <div class="form-row">
        <label class="form-row__label" for="member">アーティスト名</label>
        <input id="member" type="text" class="form-row__input" v-model="memberName" placeholder="例) 花音" />
      </div>

      <div class="form-row">
        <label class="form-row__label" for="ownedCount">所持数</label>
        <input id="ownedCount" type="number" min="0" class="form-row__input" v-model="ownedCount" />
      </div>

      <div class="form-row">
        <label class="form-row__label" for="description">メモ</label>
        <textarea id="description" class="form-row__input form-row__input--textarea" v-model="description" rows="4"></textarea>
      </div>

      <div class="card-form__actions">
        <button type="submit" class="card-form__submit">{{ isEditMode ? '更新する' : '登録する' }}</button>
      </div>
    </form>
  </main>
</template>

<style scoped>
.card-form {
  width: 100%;
  max-width: 560px;
  margin: 0 auto;
  padding: 48px 24px 80px;
  background-color: #fdfdfb;
  color: #1a1a1a;
  font-family: 'Noto Sans JP', 'Hiragino Sans', sans-serif;
  box-sizing: border-box;
}

.card-form__header {
  text-align: center;
  margin-bottom: 40px;
  padding-bottom: 24px;
  border-bottom: 2px solid #1a1a1a;
}

.card-form__eyebrow {
  margin: 0 0 8px;
  font-size: 12px;
  letter-spacing: 0.4em;
  color: #6b6b6b;
  font-family: Georgia, serif;
}

.card-form__title {
  margin: 0 0 8px;
  font-size: 24px;
  letter-spacing: 0.1em;
}

.card-form__id {
  margin: 0;
  font-size: 13px;
  color: #6b6b6b;
  font-family: Georgia, serif;
}

.card-form__body {
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

.image-upload {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  aspect-ratio: 3 / 4;
  max-width: 220px;
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

.card-form__actions {
  margin-top: 16px;
}

.card-form__submit {
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

.card-form__submit:hover {
  opacity: 0.8;
}
</style>
