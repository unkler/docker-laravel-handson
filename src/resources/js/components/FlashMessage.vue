<template>
  <div v-show="isShow" class="flex justify-between justify-items-center bg-blue-100 dark:bg-gray-800 border-t border-b border-blue-500 dark:border-gray-400 text-blue-700 dark:text-gray-400 px-4 py-3 mt-3">
    <div class="font-bold">登録しました</div>
    <div @click="isShow = !isShow"><i class="fa-solid fa-circle-xmark cursor-pointer"></i></div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isShow: true
    }
  },
}
</script>