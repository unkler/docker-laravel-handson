<template>
  <div class="w-full bg-gray-100">
    <div class="flex items-center h-full p-16 dark:bg-gray-900 dark:text-gray-100">
      <div class="container flex flex-col items-center justify-center px-5 mx-auto my-8">
        <div class="max-w-md text-center">
          <h2 class="mb-8 font-extrabold text-9xl dark:text-gray-600">
            404<span class="text-3xl"></span>
          </h2>
          <p class="text-base font-semibold">お探しのページはありません</p>
          <div class="mt-5">
            <router-link :to="{ name: 'taskAssign' }" class="bg-blue-800 text-white mt-5 px-8 py-3 font-semibold rounded dark:bg-violet-400 dark:text-gray-900">トップに戻る</router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

