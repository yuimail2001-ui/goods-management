<script setup>
</script>

<template>
  <main class="home">
    <header class="home__header">
      <p class="home__eyebrow">OSHI GOODS MANAGEMENT</p>
      <h1 class="home__title">推し活グッズ管理</h1>
    </header>

    <div class="home__menu">
      <router-link to="/tours" class="menu-card">
        <p class="menu-card__label">一覧を見る</p>
        <p class="menu-card__desc">登録済みのツアー・グッズを確認する</p>
      </router-link>

      <router-link to="/tours/manage" class="menu-card">
        <p class="menu-card__label">登録・編集</p>
        <p class="menu-card__desc">ツアーやグッズを登録・更新・削除する</p>
      </router-link>
    </div>
  </main>
</template>

<style scoped>
.home {
  width: 100%;
  max-width: 900px;
  margin: 0 auto;
  padding: 64px 24px 80px;
  background-color: #fdfdfb;
  color: #1a1a1a;
  font-family: 'Noto Sans JP', 'Hiragino Sans', sans-serif;
  box-sizing: border-box;
}

.home__header {
  text-align: center;
  margin-bottom: 56px;
  padding-bottom: 24px;
  border-bottom: 2px solid #1a1a1a;
}

.home__eyebrow {
  margin: 0 0 8px;
  font-size: 12px;
  letter-spacing: 0.4em;
  color: #6b6b6b;
  font-family: Georgia, serif;
}

.home__title {
  margin: 0;
  font-size: 28px;
  letter-spacing: 0.15em;
}

.home__menu {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 24px;
}

.menu-card {
  display: block;
  padding: 40px 28px;
  border: 0.75px solid #1a1a1a;
  text-decoration: none;
  color: inherit;
  transition: background-color 0.2s ease, transform 0.2s ease;
}

.menu-card:hover {
  background-color: #f2f1ec;
  transform: translateY(-2px);
}

.menu-card__label {
  margin: 0 0 8px;
  font-size: 20px;
  letter-spacing: 0.06em;
}

.menu-card__desc {
  margin: 0;
  font-size: 13px;
  color: #6b6b6b;
  letter-spacing: 0.02em;
  line-height: 1.6;
}
</style>
