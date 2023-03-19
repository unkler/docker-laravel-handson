<template>
  <div>
    <TheHeader id="header" />
    <div class="flex">
      <TheAside />
      <RouterView />
    </div>
    <TheFooter />
  </div>
</template>

<script>
import TheHeader from './components/TheHeader.vue'
import TheAside from './components/TheAside.vue'
import TheFooter from './components/TheFooter.vue'

export default {
  components: {
    TheHeader,
    TheAside,
    TheFooter, 
  },
}
</script>