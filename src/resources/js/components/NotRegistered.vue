<template>
  <div class="m-5 px-64 py-5 rounded-lg bg-gray-50 dark:bg-gray-800 text-center">
    <div class="text-gray-400 text-6xl"><i class="fa-regular fa-circle-check"></i></div>
    <div class="m-2 text-gray-800 dark:text-gray-400">{{ pageName }}は登録されていません</div>
    <router-link :to="{ name: linkTo }" class="w-32 flex text-xs ml-auto text-white bg-blue-800 border-0 py-2 px-6 focus:outline-none hover:bg-blue-600 dark:text-gray-400 dark:bg-gray-700 dark:hover:bg-gray-600">
      <span><i class="fa-solid fa-plus dark:text-gray-400 mr-2 text-center"></i></span>
      <span>新規登録</span>
    </router-link>
  </div>
</template>

<script>
export default {
  props: {
    pageName: {
      type: String,
      required: true,
    },
    linkTo: {
      type: String,
      required: true,
    }
  }
}
</script>