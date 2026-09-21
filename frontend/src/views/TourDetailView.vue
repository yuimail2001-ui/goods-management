<script setup>
import { ref,onMounted } from 'vue'
import { useRoute } from 'vue-router'
import apiClient from '../services/api'
const tour = ref({})

const route = useRoute()
const tourId = route.params.id
const goods = ref([])

onMounted(async () => {
  const response = await apiClient.get(`/tours/${tourId}`)
  tour.value = response.data

  const goodsResponse = await apiClient.get(`/goods`,{
    params:{
        tour_id:tourId
    },
  })
  goods.value = goodsResponse.data
})

</script>

<template>
  <main class="tour-detail">
    <header class="tour-detail__header">
      <p class="tour-detail__eyebrow">TOUR DETAIL</p>
      <h1 class="tour-detail__title" translate="no">{{ tour.name }}</h1>
      <p class="tour-detail__period">
        {{ tour.start_date }} <span class="tour-detail__wave">〜</span> {{ tour.end_date }}
      </p>
    </header>

    <section class="goods-section">
      <p class="goods-section__label">GOODS</p>
      <ul class="goods-grid">
        <li v-for="item in goods" :key="item.id" class="goods-card">
          <div class="goods-card__image"></div>
          <p class="goods-card__name" translate="no">{{ item.name }}</p>
          <p class="goods-card__price">¥{{ item.price.toLocaleString() }}</p>
        </li>
      </ul>
    </section>
  </main>
</template>

<style scoped>
.tour-detail {
  width: 100%;
  max-width: 1400px;
  margin: 0 auto;
  padding: 48px 40px 80px;
  background-color: #fdfdfb;
  color: #1a1a1a;
  font-family: 'Noto Sans JP', 'Hiragino Sans', sans-serif;
  box-sizing: border-box;
}

.tour-detail__header {
  text-align: center;
  margin-bottom: 40px;
  padding-bottom: 24px;
  border-bottom: 2px solid #1a1a1a;
}

.tour-detail__eyebrow {
  margin: 0 0 8px;
  font-size: 12px;
  letter-spacing: 0.4em;
  color: #6b6b6b;
  font-family: Georgia, serif;
}

.tour-detail__title {
  margin: 0 0 12px;
  font-size: 24px;
  letter-spacing: 0.08em;
}

.tour-detail__period {
  margin: 0;
  font-size: 13px;
  color: #6b6b6b;
  letter-spacing: 0.05em;
}

.tour-detail__wave {
  color: #a8a8a2;
}

.goods-section__label {
  margin: 0 0 16px;
  font-size: 12px;
  letter-spacing: 0.3em;
  color: #6b6b6b;
  font-family: Georgia, serif;
}

.goods-grid {
  list-style: none;
  margin: 0;
  padding: 0;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
  gap: 24px;
}

.goods-card {
  display: flex;
  flex-direction: column;
}

.goods-card__image {
  width: 100%;
  aspect-ratio: 4 / 3;
  background-color: #e8e7e2;
  border: 1px solid #d8d8d4;
  margin-bottom: 10px;
}

.goods-card__name {
  margin: 0 0 4px;
  font-size: 14px;
  letter-spacing: 0.02em;
  line-height: 1.4;
}

.goods-card__price {
  margin: 0;
  font-size: 13px;
  color: #6b6b6b;
  font-family: Georgia, serif;
  letter-spacing: 0.05em;
}
</style>
