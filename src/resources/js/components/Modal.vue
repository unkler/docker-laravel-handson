<template>
	<div class="fixed top-0 left-0 w-full h-full bg-black/50 z-10">
		<div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex flex-col items-center justify-between w-[500px] h-[200px] p-8 bg-white rounded-md">
      <div class="text-6xl text-gray-400 -mt-4"><i class="fa-solid fa-circle-exclamation"></i></div>
			<div class="text-md text-gray-700 mt-5">{{ message }}</div>
			<div class="flex mt-">
				<div class="w-24 bg-gray-400 text-white px-4 py-2 rounded-md mr-2 text-center text-sm cursor-pointer" @click="modalReject">キャンセル</div>
				<div class="w-24 bg-blue-800 text-white px-4 py-2 rounded-md text-center cursor-pointer" @click="modalResolve">OK</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
  methods: {
    modalReject() {
      this.$store.dispatch('actionModalReject', false)
    },
    modalResolve() {
			this.$store.dispatch('actionModalResolve', true)
		},
  },
  computed: {
    message() {
      return this.$store.state.modal.message
    },
  }
}
</script>