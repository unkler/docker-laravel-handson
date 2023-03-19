<template>
  <div class="w-full bg-gray-100 dark:bg-gray-700">
    <div class="flex mt-10 mx-4"> 
      <h2 class="font-medium text-gray-800 mr-5 dark:text-gray-400">作業一覧</h2>
      <div @click="getTaskAssign(true)" :class="{'bg-gray-700 text-white dark:bg-white dark:text-gray-800': isAfterToday}" class="bg-white text-sm rounded-xl p-2 mr-2 cursor-pointer dark:bg-gray-800 dark:text-white">本日以降分</div>
      <div @click="getTaskAssign(false)" :class="{'bg-gray-700 text-white dark:bg-white dark:text-gray-800': !isAfterToday }" class="bg-white text-sm rounded-xl p-2 cursor-pointer dark:bg-gray-800 dark:text-white">過去分</div>
      <router-link :to="{ name: 'taskAssignCreate' }" class="flex text-xs ml-auto text-white bg-blue-800 border-0 py-2 px-6 focus:outline-none hover:bg-blue-600 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-600">
        <span><i class="fa-solid fa-plus dark:text-gray-400 mr-2 text-center"></i></span>
        <span>新規登録</span>
      </router-link>
    </div>
    <FlashMessage v-show="registeredResult" />
    <div v-if="isLoading">
      <img src="/storage/images/loading.gif" class="mx-auto mt-20" />
    </div>
    <div v-else>
      <div v-if="taskAssigns.length === 0">
        <NotRegistered pageName="作業" linkTo="taskAssignCreate" />
      </div>
      <div v-else>
        <div class="m-5">
          <div class="w-full overflow-hidden rounded-lg">
            <div class="w-full overflow-x-auto">
              <div class="table table-auto w-full">
                <div class="table-row text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                  <div class="table-cell px-4 py-3">取引先</div>
                  <div class="table-cell px-4 py-3">作業場所</div>
                  <div class="table-cell px-4 py-3">担当者</div>
                  <div class="table-cell px-4 py-3">実施日</div>
                  <div class="table-cell px-4 py-3"></div>
                </div>
                <div v-for="taskAssign in taskAssigns" :key="taskAssign.id"  class="table-row border-current divide-y bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-400">
                  <div class="table-cell px-4 py-3 text-xs border-t">{{ taskAssign.workplaces.clients.name }}</div>
                  <div class="table-cell px-4 py-3 text-xs">{{ taskAssign.workplaces.name }}</div>
                  <div class="table-cell px-4 py-3 text-xs">
                    <div v-for="employee in taskAssign.employees" :key="employee.id">
                      {{ employee.last_name }}{{ employee.first_name }}
                    </div>
                  </div>
                  <div class="table-cell px-4 py-3 text-xs">{{ taskAssign.implementation_date }}</div>
                  <div class="table-cell px-4 py-3 text-sm align-middle">
                    <div @click.stop="openDropDown(taskAssign.id)" v-click-outside="closeDropDown" class="rounded-full w-10 h-10 text-center leading-10 hover:bg-gray-200 dark:hover:bg-gray-600 cursor-pointer">
                      <i class="fa-solid fa-ellipsis-vertical"></i>
                    </div>
                  </div>
                  <DropDown top="top-14" left="-left-60" :subject="taskAssign" linkName="taskAssignEdit" @receiveId="deleteTaskAssign" class="absolute" />
                </div>
                <Modal v-if="isOpenModal" />
              </div>
            </div>
          </div>
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
      taskAssigns: [],
      links: [],
      currentPage: 1,
      isLoading: true,
      isAfterToday: true,
    }
  },
  methods: {
    getTaskAssign(isAfterToday = true) {
      this.isAfterToday = isAfterToday

      axios.get(`/api/task_assign/?page=${this.currentPage}`, {
          params: {
            is_after_today: isAfterToday
          }
        })
        .then(res => {
          this.taskAssigns = res.data.data
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
    deleteTaskAssign(taskAssignId) {
      axios.delete('/api/task_assign/delete', {
          params: {
            id: taskAssignId
          }
        })
        .then(res => {
          if (res.data === 200) {
            this.getTaskAssign()
            this.$toasted.show(infoMessage.succeededDelete)
          } else {
            this.$toasted.error(errorMessage.systemError)
          }
        })
    },
    openDropDown(taskAssignId) {
      this.taskAssigns.forEach((taskAssign, index) => {
        if (taskAssign.id === taskAssignId && !this.taskAssigns[index].is_open_drop_down) {
          this.$set(this.taskAssigns[index], 'is_open_drop_down', true)
        } else {
          this.$set(this.taskAssigns[index], 'is_open_drop_down', false)
        }
      })
    },
    closeDropDown() {
      this.taskAssigns.forEach((taskAssign, index) => {
        this.$set(this.taskAssigns[index], 'is_open_drop_down', false)
      })
    },
    setCurrentPage(clickedPage) {
      this.currentPage = clickedPage
      this.getTaskAssign()
    }
  },
  computed: {
		isOpenModal() {
			return this.$store.state.modal.isOpen
		},
	},
  created() {
    this.getTaskAssign()
  },
  directives: {
    ClickOutside
  }
}
</script>