<template>
  <div class="w-full bg-gray-100 dark:bg-gray-700">
    <div class="flex mt-10 mx-4"> 
      <h2 class="font-medium text-gray-800 mr-5 dark:text-gray-400">社員一覧</h2>
      <div v-if="employees.length !== 0">
        <form @submit.prevent="getEmployees">
          <div class="flex justify-around items-center">
            <input type="search" v-model="searchKeyword" name="search_keyword" placeholder="氏名検索" class="text-sm bg-gray-100 h-8 border border-gray-500 outline-none w-full p-1 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 dark:bg-gray-600">
            <button class="bg-blue-800 text-white p-1 dark:bg-gray-800 dark:hover:bg-gray-600">
              <i class="fa-solid fa-magnifying-glass dark:text-gray-400"></i>  
            </button>
          </div>
        </form>
      </div>
      <router-link :to="{ name: 'employeeCreate' }" class="flex text-xs ml-auto text-white bg-blue-800 border-0 py-2 px-6 focus:outline-none hover:bg-blue-600 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-600">
        <span><i class="fa-solid fa-plus dark:text-gray-400 mr-2 text-center"></i></span>
        <span>新規登録</span>
      </router-link>
    </div>
    <FlashMessage v-show="registeredResult" />
    <div v-if="isLoading">
      <img src="/storage/images/loading.gif" class="mx-auto mt-20" />
    </div>
    <div v-else>
      <div v-if="employees.length === 0">
        <NotRegistered pageName="従業員" linkTo="employeeCreate" />
      </div>
      <div v-else>
        <div class="m-5">
          <div class="w-full overflow-hidden rounded-lg">
            <div class="w-full overflow-x-auto">
              <div class="table table-auto w-full">
                <div class="table-row text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                  <div class="table-cell px-4 py-3"></div>
                  <div class="table-cell px-4 py-3">氏名</div>
                  <div class="table-cell px-4 py-3">雇用区分</div>
                  <div class="table-cell px-4 py-3">郵便番号</div>
                  <div class="table-cell px-4 py-3">住所</div>
                  <div class="table-cell px-4 py-3">電話番号</div>
                  <div class="table-cell px-4 py-3">メールアドレス</div>
                  <div class="table-cell px-4 py-3"></div>
                </div>
                <div v-for="employee in employees" :key="employee.id"  class="table-row border-current divide-y bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-400">
                  <!-- <div class="table-cell px-4 py-3 text-3xl border-t"><i class="fa-solid fa-circle-user"></i></div> -->
                  <div class="table-cell px-4 py-3 text-3xl align-middle border-t">
                    <template v-if="employee.employee_images.length > 0">
                      <img class="w-14 h-14 rounded-full" :src="employee.employee_images[0].path" />
                    </template>
                    <template v-else>
                      <span class="text-5xl text-gray-500">
                        <i class="fa-solid fa-circle-user"></i>
                      </span>
                    </template>
                  </div>
                  <div class="table-cell px-4 py-3 text-sm align-middle">{{ employee.last_name }} {{ employee.first_name }}</div>
                  <div class="table-cell px-4 py-3 text-sm align-middle">{{ employee.contract_types.name }}</div>
                  <div class="table-cell px-4 py-3 text-xs align-middle">{{ employee.post_code }}</div>
                  <div class="table-cell px-4 py-3 text-sm align-middle">{{ employee.prefectures.name }}{{ employee.address }}</div>
                  <div class="table-cell px-4 py-3 text-sm align-middle">{{ employee.phone_number }}</div>
                  <div class="table-cell px-4 py-3 text-sm align-middle">{{ employee.email }}</div>
                  <div class="table-cell px-4 py-3 text-sm align-middle">
                    <div @click.stop="openDropDown(employee.id)" v-click-outside="closeDropDown" class="rounded-full w-10 h-10 text-center leading-10 hover:bg-gray-200 dark:hover:bg-gray-600 cursor-pointer">
                      <i class="fa-solid fa-ellipsis-vertical"></i>
                    </div>
                  </div>
                  <DropDown top="top-14" left="-left-28" :subject="employee" linkName="employeeEdit" @receiveId="deleteEmployee" class="absolute" />
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
      employees: [],
      links: [],
      searchKeyword: null,
      currentPage: 1,
      isLoading: true,
    }
  },
  methods: {
    getEmployees() {
      axios.get(`/api/employee/?page=${this.currentPage}`, {
          params: {
            search_keyword: this.searchKeyword
          }
        })
        .then(res => {
          this.employees = res.data.data
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
    deleteEmployee(employeeId) {
      axios.delete('/api/employee/delete', {
          params: {
            id: employeeId
          }
        })
        .then(res => {
          if (res.data === 200) {
            this.getEmployees()
            this.$toasted.show(infoMessage.succeededDelete)
          } else {
            this.$toasted.error(errorMessage.systemError)
          }
        })
    },
    openDropDown(employeeId) {
      this.employees.forEach((employee, index) => {
        if (employee.id === employeeId && !this.employees[index].is_open_drop_down) {
          this.$set(this.employees[index], 'is_open_drop_down', true)
        } else {
          this.$set(this.employees[index], 'is_open_drop_down', false)
        }
      })
    },
    closeDropDown() {
      this.employees.forEach((employee, index) => {
        this.$set(this.employees[index], 'is_open_drop_down', false)
      })
    },
    setCurrentPage(param) {
      this.currentPage = param
      this.getEmployees()
    }
  },
  computed: {
		isOpenModal() {
			return this.$store.state.modal.isOpen
		},
	},
  created() {
    this.getEmployees()
  },
  directives: {
    ClickOutside
  }
}
</script>