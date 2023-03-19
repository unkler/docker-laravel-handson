<template>
  <div class="w-full mt-2 rounded-lg bg-gray-50 dark:bg-gray-800 text-center">
    <ul v-for="link, index in extractLinks" :key="index" class="inline-flex -space-x-px">
      <li @click="setCliCkedPage(link.url)" v-scroll-to="'#header'" :class="link.active ? 'bg-blue-800 dark:bg-gray-600 cursor-auto' : 'bg-gray-400 cursor-pointer'" class="text-sm text-white m-2 px-3 py-1 rounded-md">
        {{ link.label }}
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    links: {
      type: Array,
      required: true
    },
  },
  methods: {
    setCliCkedPage(url) {
      const extractedUrl = url.substring(url.indexOf('page='));
      const clickedPage = extractedUrl.replace('page=', '')

      this.$emit('receiveCurrentPage', clickedPage)
    }
  },
  computed: {
    extractLinks() {
      return this.links.filter(link => {
        return isFinite(link.label)
      })
    }
  }
}
</script>