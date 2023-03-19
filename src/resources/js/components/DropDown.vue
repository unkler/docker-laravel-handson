<template>
  <div v-if="subject.is_open_drop_down" class="absolute">
    <div :class="[top, left]" class="relative z-10 shadow-md bg-white dark:bg-gray-700 cursor-pointer text-gray-700 dark:text-gray-400 text-sm">
      <div class="w-20 h-12 leading-[48px] text-center border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
        <router-link :to="{ name: linkName, params: { id: subject.id }}">
          <i class="fa-solid fa-pen-to-square mr-2 "></i>編集
        </router-link>
      </div>
      <div @click="openModal(subject.id)" class="w-20 h-12 leading-[48px] text-center hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
        <i class="fa-solid fa-trash-can mr-2"></i>削除
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    subject: {
      type: [Object, Array],
      required: true
    },
    linkName: {
      type: String,
      required: true,
    },
    top: {
      type: String,
      required: true,
    },
    left: {
      type: String,
      required: true,
    },
  },
  methods: {
    openModal(id) {
			const payload = {
				isOpen: true,
				message: '削除します。よろしいですか？',
			}
			this.$store.dispatch('actionModalOpen', payload)
        .then(() => {
            this.$emit('receiveId', id)
        })
        .catch(() => {
        })
		},
  },
}
</script>

