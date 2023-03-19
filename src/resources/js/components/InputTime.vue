<script setup>
import { onMounted, ref } from 'vue'
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

const props = defineProps({
  oldBirthday: String,
})

//編集またはバリデーションエラー時様に初期値をセット
const time = props.oldBirthday === null ? ref({hours: new Date().getHours(), hours: new Date().getHours()}) : ref(new Date(props.oldBirthday))
const startTime = ref({ hours: 0, minutes: 0 });
</script>

<template>
  <Datepicker v-model="time" :start-time="startTime" time-picker locale="jp"  minutes-increment="10" auto-apply no-minutes-overlay></Datepicker>
</template>
