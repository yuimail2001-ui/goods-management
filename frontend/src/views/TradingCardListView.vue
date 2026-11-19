<script setup>
import { ref, computed, onMounted } from 'vue'
import apiClient from '../services/api'

const cards = ref([])
const sortKey = ref('card_code')

onMounted(async () => {
  const response = await apiClient.get('/trading-cards')
  cards.value = response.data
})

const sortedCards = computed(() => {
  return [...cards.value].sort((a, b) => {
    return String(a[sortKey.value]).localeCompare(String(b[sortKey.value]), 'ja')
  })
})

const imageUrl = (card) => {
  return card.image_path ? `http://localhost/storage/${card.image_path}` : null
}

const changeOwnedCount = async (card, diff) => {
  const nextCount = Math.max(0, card.owned_count + diff)
  if (nextCount === card.owned_count) return

  const formData = new FormData()
  formData.append('card_code', card.card_code)
  formData.append('member_name', card.member_name)
  formData.append('tour_id', card.tour_id)
  formData.append('owned_count', nextCount)
  formData.append('_method', 'PUT')

  const response = await apiClient.post(`/trading-cards/${card.id}`, formData)
  card.owned_count = Number(response.data.owned_count)
  card.possession_status = response.data.possession_status
}

const onDelete = async (card) => {
  if (!window.confirm(`「${card.card_code}(${card.member_name})」を削除しますか？`)) return

  await apiClient.delete(`/trading-cards/${card.id}`)
  cards.value = cards.value.filter((c) => c.id !== card.id)
}
</script>

<template>
  <main class="trading-card-list">
    <header class="trading-card-list__header">
      <p class="trading-card-list__eyebrow">TRADING CARDS</p>
      <h1 class="trading-card-list__title">トレカ</h1>
    </header>

    <div class="trading-card-list__toolbar">
      <div class="trading-card-list__sort-group">
        <label class="trading-card-list__sort-label" for="sort">並び替え</label>
        <select id="sort" class="trading-card-list__sort" v-model="sortKey">
          <option value="card_code">ID順</option>
          <option value="member_name">アーティスト順</option>
        </select>
      </div>

      <router-link to="/trading-cards/manage" class="trading-card-list__add">+ 新規登録</router-link>
    </div>

    <ul class="card-grid">
      <li v-for="card in sortedCards" :key="card.id" class="card-item">
        <div class="card-item__image">
          <img v-if="imageUrl(card)" :src="imageUrl(card)" class="card-item__image-tag" />
        </div>
        <p class="card-item__id" translate="no">{{ card.card_code }}({{ card.member_name }})</p>

        <div class="card-item__owned">
          <button type="button" class="card-item__owned-btn" @click="changeOwnedCount(card, -1)">−</button>
          <span class="card-item__owned-count">{{ card.owned_count }}</span>
          <button type="button" class="card-item__owned-btn" @click="changeOwnedCount(card, 1)">+</button>
        </div>

        <div class="card-item__actions">
          <router-link :to="`/trading-cards/${card.id}/edit`" class="card-item__action">編集</router-link>
          <button type="button" class="card-item__action card-item__action--delete" @click="onDelete(card)">
            削除
          </button>
        </div>
      </li>
    </ul>
  </main>
</template>

<style scoped>
.trading-card-list {
  width: 100%;
  max-width: 1400px;
  margin: 0 auto;
  padding: 48px 40px 80px;
  background-color: #fdfdfb;
  color: #1a1a1a;
  font-family: 'Noto Sans JP', 'Hiragino Sans', sans-serif;
  box-sizing: border-box;
}

.trading-card-list__header {
  text-align: center;
  margin-bottom: 40px;
  padding-bottom: 24px;
  border-bottom: 2px solid #1a1a1a;
}

.trading-card-list__eyebrow {
  margin: 0 0 8px;
  font-size: 12px;
  letter-spacing: 0.4em;
  color: #6b6b6b;
  font-family: Georgia, serif;
}

.trading-card-list__title {
  margin: 0;
  font-size: 28px;
  letter-spacing: 0.15em;
}

.trading-card-list__toolbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 10px;
  margin-bottom: 24px;
}

.trading-card-list__sort-group {
  display: flex;
  align-items: center;
  gap: 10px;
}

.trading-card-list__add {
  font-size: 13px;
  letter-spacing: 0.05em;
  color: #1a1a1a;
  text-decoration: none;
  border: 1px solid #1a1a1a;
  padding: 8px 14px;
}

.trading-card-list__add:hover {
  background-color: #f2f1ec;
}

.trading-card-list__sort-label {
  font-size: 12px;
  letter-spacing: 0.2em;
  color: #6b6b6b;
  font-family: Georgia, serif;
}

.trading-card-list__sort {
  padding: 8px 12px;
  border: 1px solid #d8d8d4;
  background-color: #fff;
  font-family: inherit;
  font-size: 14px;
  color: #1a1a1a;
}

.card-grid {
  list-style: none;
  margin: 0;
  padding: 0;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
  gap: 24px;
}

.card-item {
  display: flex;
  flex-direction: column;
}

.card-item__image {
  width: 100%;
  aspect-ratio: 3 / 4;
  background-color: #e8e7e2;
  border: 1px solid #d8d8d4;
  margin-bottom: 10px;
  overflow: hidden;
}

.card-item__image-tag {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.card-item__id {
  margin: 0 0 10px;
  font-size: 14px;
  letter-spacing: 0.02em;
  line-height: 1.4;
}

.card-item__owned {
  display: flex;
  align-items: center;
  gap: 12px;
}

.card-item__owned-btn {
  width: 28px;
  height: 28px;
  border: 1px solid #1a1a1a;
  background-color: #fdfdfb;
  color: #1a1a1a;
  font-size: 15px;
  line-height: 1;
  cursor: pointer;
}

.card-item__owned-btn:hover {
  background-color: #f2f1ec;
}

.card-item__owned-count {
  font-family: Georgia, serif;
  font-size: 15px;
  min-width: 16px;
  text-align: center;
}

.card-item__actions {
  display: flex;
  gap: 12px;
  margin-top: 8px;
}

.card-item__action {
  font-size: 12px;
  letter-spacing: 0.05em;
  color: #6b6b6b;
  background: none;
  border: none;
  padding: 0;
  text-decoration: underline;
  cursor: pointer;
  font-family: inherit;
}

.card-item__action--delete {
  color: #a33;
}
</style>
