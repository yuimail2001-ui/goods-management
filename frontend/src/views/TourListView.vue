<script setup>
import { ref, onMounted } from 'vue'
import apiClient from '../services/api'

//　ツアー一覧格納
const tours = ref([])

//　初期処理
onMounted(async () => {
  const response = await apiClient.get('/tours')
  tours.value = response.data
})
</script>

<template>
  <main class="tour-list">
    <header class="tour-list__header">
      <p class="tour-list__eyebrow">TOUR SCHEDULE</p>
      <h1 class="tour-list__title">ツアー一覧</h1>
    </header>

    <ul class="tour-list__items">
      <li v-for="(tour, index) in tours" :key="tour.id" class="tour-card">
        <span class="tour-card__index">{{ String(index + 1).padStart(2, '0') }}</span>
        <div class="tour-card__body">
          <p class="tour-card__name" translate="no">{{ tour.name }}</p>
          <p class="tour-card__period">
            {{ tour.start_date }} <span class="tour-card__wave">〜</span> {{ tour.end_date }}
          </p>
        </div>
      </li>
    </ul>
  </main>
</template>

<style scoped>
.tour-list {
  max-width: 640px;
  margin: 0 auto;
  padding: 48px 24px 80px;
  background-color: #fdfdfb;
  color: #1a1a1a;
  font-family: 'Noto Sans JP', 'Hiragino Sans', sans-serif;
}

.tour-list__header {
  text-align: center;
  margin-bottom: 40px;
  padding-bottom: 24px;
  border-bottom: 2px solid #1a1a1a;
}

.tour-list__eyebrow {
  margin: 0 0 8px;
  font-size: 12px;
  letter-spacing: 0.4em;
  color: #6b6b6b;
  font-family: Georgia, serif;
}

.tour-list__title {
  margin: 0;
  font-size: 28px;
  letter-spacing: 0.15em;
}

.tour-list__items {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: column;
}

.tour-card {
  display: flex;
  align-items: baseline;
  gap: 20px;
  padding: 20px 4px;
  border-bottom: 1px solid #d8d8d4;
  transition: background-color 0.2s ease, padding-left 0.2s ease;
}

.tour-card:hover {
  background-color: #f2f1ec;
  padding-left: 12px;
}

.tour-card__index {
  font-size: 13px;
  letter-spacing: 0.1em;
  color: #a8a8a2;
  min-width: 24px;
  font-family: Georgia, serif;
}

.tour-card__body {
  flex: 1;
}

.tour-card__name {
  margin: 0 0 6px;
  font-size: 18px;
  letter-spacing: 0.04em;
}

.tour-card__period {
  margin: 0;
  font-size: 13px;
  color: #6b6b6b;
  letter-spacing: 0.05em;
}

.tour-card__wave {
  color: #a8a8a2;
}
</style>
