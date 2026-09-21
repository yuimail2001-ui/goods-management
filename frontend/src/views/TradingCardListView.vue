<script setup>
</script>

<template>
  <main class="trading-card-list">
    <header class="trading-card-list__header">
      <p class="trading-card-list__eyebrow">TRADING CARDS</p>
      <h1 class="trading-card-list__title">トレカ</h1>
    </header>

    <p class="trading-card-list__notice">準備中です</p>
  </main>
</template>

<style scoped>
.trading-card-list {
  width: 100%;
  max-width: 640px;
  margin: 0 auto;
  padding: 48px 24px 80px;
  background-color: #fdfdfb;
  color: #1a1a1a;
  font-family: 'Noto Sans JP', 'Hiragino Sans', sans-serif;
  box-sizing: border-box;
  text-align: center;
}

.trading-card-list__header {
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

.trading-card-list__notice {
  color: #6b6b6b;
  font-size: 14px;
  letter-spacing: 0.05em;
}
</style>
