<template>
  <div class="w-full bg-gray-100 dark:bg-gray-700">
    <div class="flex mt-10 mx-4">
      <h2 class="font-medium text-gray-800 mr-5 dark:text-gray-400">作業場所一覧</h2>
      <div v-show="workplaces.length !== 0">
        <form @submit.prevent="getWorkplaces">
          <div class="flex justify-around items-center">
            <input type="search" v-model="searchKeyword" name="search_keyword" placeholder="作業場所検索" class="text-sm bg-gray-100 h-8 border border-gray-500 outline-none w-full p-1 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 dark:bg-gray-600">
            <button class="bg-blue-800 text-white p-1 dark:bg-gray-800 dark:hover:bg-gray-600">
              <i class="fa-solid fa-magnifying-glass dark:text-gray-400"></i>  
            </button>
          </div>
        </form>
      </div>
      <router-link :to="{ name: 'workplaceCreate' }" class="flex text-xs ml-auto text-white bg-blue-800 border-0 py-2 px-6 focus:outline-none hover:bg-blue-600 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-600">
        <span><i class="fa-solid fa-plus dark:text-gray-400 mr-2 text-center"></i></span>
        <span>新規登録</span>
      </router-link>
    </div>
    <FlashMessage v-show="registeredResult" />
    <div v-if="isLoading">
      <img src="/storage/images/loading.gif" class="mx-auto mt-20" />
    </div>
    <div v-else>
      <div v-if="workplaces.length === 0">
        <NotRegistered pageName="作業場所" linkTo="workplaceCreate" />
      </div>
      <div v-else>
        <div class="m-5">
          <div class="flex flex-wrap justify-between items-stretch gap-3 before::block before:content-[''] before:w-[340px] before:order-1 after::block after:content-[''] after:w-[340px]">
              <div v-for="workplace in workplaces" :key="workplace.id" class="relative w-[340px] max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                  <template v-if="workplace.workplace_images.length > 0">
                    <div class="bg-gray-800 rounded-t-lg flex justify-center">
                      <img class="rounded-t-lg h-[230px]" :src="workplace.workplace_images[0].path" />
                    </div>
                  </template>
                  <template v-else>
                    <img class="rounded-t-lg" src="storage/images/no_image.jpg" />
                  </template>
                  <div @click.stop="openDropDown(workplace.id)" v-click-outside="closeDropDown" class="absolute top-[234px] right-1 w-10 h-10 leading-10 text-center hover:bg-gray-200 rounded-full text-lg cursor-pointer">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                  </div>
                  <DropDown top="top-12" left="left-60" :subject="workplace" linkName="workplaceEdit" @receiveId="deleteWorkplace" class="absolute" />
                  <div class="p-5">
                    <div class="mb-2 text-lg font-bold text-gray-900 dark:text-white">
                      {{ workplace.clients.name }}
                    </div>
                    <div class="mb-2 text-base font-bold text-gray-900 dark:text-white">
                      {{ workplace.name }}
                    </div>
                    <div class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                      <i class="fa-solid fa-location-dot mr-2"></i>{{ workplace.post_code }} {{ workplace.prefectures.name }}{{ workplace.address }}
                    </div>
                    <div class="mb-2 text-base text-gray-900 dark:text-white">
                      <i class="fa-solid fa-phone mr-2"></i>{{ workplace.phone_number }}
                    </div>
                  </div>
              </div>
          </div>

          <Modal v-if="isOpenModal" />

          <Pagination :links="links" @receiveCurrentPage="setCurrentPage" />

        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ClickOutside from 'vue-click-outside'
import FlashMessage from '../../components/FlashMessage.vue'
import NotRegistered from '../../components/NotRegistered.vue'
import DropDown from '../../components/DropDown.vue'
import Modal from '../../components/Modal.vue'
import Pagination from '../../components/Pagination.vue'
import { infoMessage, errorMessage } from '../../constants/message'

export default {
  components: {
    FlashMessage,
    NotRegistered,
    DropDown,
    Modal,
    Pagination,
  },
  props: {
    registeredResult: {
      type: String,
      default: null,
    }
  },
  data() {
    return {
      workplaces: [],
      links: [],
      searchKeyword: null,
      currentPage: 1,
      isLoading: true,
    }
  },
  methods: {
    getWorkplaces() {
      axios.get(`/api/workplace/?page=${this.currentPage}`, {
          params: {
            search_keyword: this.searchKeyword
          }
        })
        .then(res => {
          this.workplaces = res.data.data
          this.links = res.data.links

        })
        .catch(error => {
          console.error(error)
          this.$toasted.error(errorMessage.systemError)
        })
        .finally(() => {
          this.isLoading = false
        })
    },
    deleteWorkplace(workplaceId) {
      axios.delete('/api/workplace/delete', {
          params: {
            id: workplaceId
          }
        })
        .then(res => {
          if (res.data === 200) {
            this.getWorkplaces()
            this.$toasted.show(infoMessage.succeededDelete)
          } else {
            this.$toasted.error(errorMessage.systemError)
          }
        })
    },
    openDropDown(workplaceId) {
      this.workplaces.forEach((workplace, index) => {
        if (workplace.id === workplaceId && !this.workplaces[index].is_open_drop_down) {
          this.$set(this.workplaces[index], 'is_open_drop_down', true)
        } else {
          this.$set(this.workplaces[index], 'is_open_drop_down', false)
        }
      })
    },
    closeDropDown() {
      this.workplaces.forEach((workplace, index) => {
        this.$set(this.workplaces[index], 'is_open_drop_down', false)
      })
    },
    setCurrentPage(clickedPage) {
      this.currentPage = clickedPage
      this.getWorkplaces()
    }
  },
  computed: {
		isOpenModal() {
			return this.$store.state.modal.isOpen
		},
	},
  created() {
    this.getWorkplaces()
  },
  directives: {
    ClickOutside
  }
}
</script>