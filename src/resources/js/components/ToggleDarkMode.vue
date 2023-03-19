<template>
  <label>
    <input
      v-model="isDarkMode"
      type="checkbox"
      class="peer sr-only"
    />
    <span
      class="block w-[2em] cursor-pointer bg-gray-500 rounded-full 
      p-[1px] after:block after:h-[1em] after:w-[1em] after:rounded-full 
      after:bg-white after:transition peer-checked:bg-gray-700 
      peer-checked:after:translate-x-[calc(100%-2px)]"
    >
    </span>
    <span class="text-xs">ダークモード</span>
  </label>
</template>

<script>
export default {
  data() {
    return {
      isDarkMode: false
    }
  },
  watch: {
    isDarkMode(value) {
      const body = document.querySelector('html')
      if (value) {
        body.classList.add('dark')
      } else {
        body.classList.remove('dark')
      }
    },
  },
}
</script>