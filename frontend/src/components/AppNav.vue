<script setup>
import { ref } from 'vue'

const isOpen = ref(false)

const close = () => {
  isOpen.value = false
}
</script>

<template>
  <div class="app-nav">
    <button type="button" class="app-nav__trigger" @click="isOpen = true" aria-label="メニューを開く">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <div v-if="isOpen" class="app-nav__backdrop" @click="close"></div>

    <nav class="app-nav__drawer" :class="{ 'app-nav__drawer--open': isOpen }">
      <button type="button" class="app-nav__close" @click="close" aria-label="メニューを閉じる">×</button>

      <ul class="app-nav__list">
        <li>
          <router-link to="/" class="app-nav__link" @click="close">ホーム</router-link>
        </li>
        <li>
          <router-link to="/tours" class="app-nav__link" @click="close">一覧</router-link>
        </li>
        <li>
          <router-link to="/tours/manage" class="app-nav__link" @click="close">登録画面</router-link>
        </li>
        <li>
          <router-link to="/trading-cards" class="app-nav__link" @click="close">トレカ画面</router-link>
        </li>
      </ul>
    </nav>
  </div>
</template>

<style scoped>
.app-nav__trigger {
  position: fixed;
  top: 24px;
  right: 24px;
  z-index: 30;
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 5px;
  width: 40px;
  height: 40px;
  background-color: #fdfdfb;
  border: 1px solid #1a1a1a;
  cursor: pointer;
}

.app-nav__trigger span {
  display: block;
  width: 20px;
  height: 1px;
  margin: 0 auto;
  background-color: #1a1a1a;
}

.app-nav__backdrop {
  position: fixed;
  inset: 0;
  background-color: rgba(26, 26, 26, 0.4);
  z-index: 40;
}

.app-nav__drawer {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  width: 260px;
  max-width: 80vw;
  background-color: #fdfdfb;
  border-left: 1px solid #1a1a1a;
  padding: 24px;
  box-sizing: border-box;
  transform: translateX(100%);
  transition: transform 0.25s ease;
  z-index: 50;
  font-family: 'Noto Sans JP', 'Hiragino Sans', sans-serif;
}

.app-nav__drawer--open {
  transform: translateX(0);
}

.app-nav__close {
  display: block;
  margin: 0 0 32px auto;
  background: none;
  border: none;
  font-size: 24px;
  line-height: 1;
  color: #1a1a1a;
  cursor: pointer;
}

.app-nav__list {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: column;
}

.app-nav__link {
  display: block;
  padding: 16px 4px;
  border-bottom: 1px solid #d8d8d4;
  color: #1a1a1a;
  text-decoration: none;
  font-size: 15px;
  letter-spacing: 0.05em;
}

.app-nav__link:hover {
  background-color: #f2f1ec;
}
</style>
