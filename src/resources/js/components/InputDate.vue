<script setup>
import { onMounted, ref } from 'vue'
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

const props = defineProps({
  oldBirthday: String,
})

//編集またはバリデーションエラー時様に初期値をセット
const date = props.oldBirthday === null ? ref(new Date()) : ref(new Date(props.oldBirthday))

const format = (date) => {
  const year = date.getFullYear()
  const month = date.getMonth() + 1
  const day = date.getDate()

  return `${year}/${month}/${day}`
}
</script>

<template>
  <Datepicker v-model="date" :format="format" locale="jp" :enable-time-picker="false" auto-apply></Datepicker>
</template>
