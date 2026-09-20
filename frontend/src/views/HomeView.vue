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
    <main>
    <h1>ツアー一覧</h1>
      <ul>
        <li v-for="tour in tours" :key="tour.id">
          {{ tour.name}}
        </li>
      </ul>
  </main>
</template>
