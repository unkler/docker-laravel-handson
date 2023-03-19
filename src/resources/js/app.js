import './bootstrap'
import Vue from 'vue'
import router from './router'
import store from './store'
import Toasted from 'vue-toasted'
import VueScrollTo from 'vue-scrollto'
import App from './App.vue'
// import { createApp } from 'vue/dist/vue.esm-bundler.js';

// import Employee from './components/Employee.vue';
// import InputDate from './components/InputDate.vue';
// import InputTime from './components/InputTime.vue';

// const app = createApp({
//   components: {
//     'employee': Employee,
//     'input-date': InputDate,
//     'input-time': InputTime,
//   },
// },);
// app.mount('#app');


Vue.use(Toasted, {
  position: 'bottom-center',
  duration: 2000,
})

 
Vue.use(VueScrollTo)

new Vue({
    el: '#app',
    router,
    store,
    render (h) {
      return h(App);
    },
})


