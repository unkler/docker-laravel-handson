<template>
  <div v-if="workplace && workplace.clients && workplace.prefectures" class="w-full md:w-4/5 mx-auto p-2">
    <div class="flex flex-col items-center mx-auto bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl dark:border-gray-700 dark:bg-gray-800">
      <template v-if="Object.keys(workplace.workplace_images).length !== 0">
        <img class="object-cover w-full rounded-t-lg h-auto md:w-64 md:rounded-none md:rounded-l-lg" :src="workplace.workplace_images[0].path" />
      </template>
      <template v-else>
        <img class="object-cover w-full rounded-t-lg md:h-auto md:w-64 md:rounded-none md:rounded-l-lg" src="/storage/images/no_image.jpg" />
      </template>
      <div class="flex flex-col justify-between p-4 leading-normal">
        <div class="mb-2 font-bold tracking-tight text-gray-900 dark:text-white">
          {{ workplace.clients.name }}
        </div>
        <div class="mb-3 font-normal text-gray-700 dark:text-gray-400">
          <i class="fa-solid fa-location-dot mr-2"></i>{{ workplace.prefectures.name }}{{ workplace.address }}
        </div>
        <div class="mb-3 font-normal text-gray-700 dark:text-gray-400">
          <i class="fa-solid fa-phone mr-2"></i>{{ workplace.phone_number }}
        </div>
      </div>
    </div>
  </div>

</template>

<script>
export default {
  props: {
    workplace: {
      type: Object,
      required: true
    } 
  }
}
</script>