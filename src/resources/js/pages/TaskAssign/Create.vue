<template>
  <div class="w-full bg-gray-100 dark:bg-gray-700">
    <div class="flex mt-10 mx-4"> 
      <h2 class="font-medium text-gray-800 mr-5 dark:text-gray-400">作業登録</h2>
    </div>
    <div v-if="isLoading.clientsWithWorkplaces || isLoading.employees">
      <img src="/storage/images/loading.gif" class="mx-auto mt-20" />
    </div>
    <div v-else>
      <div class="mx-4 mt-5">
        <div class="w-full mb-2 rounded-lg shadow-xs dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
          <div class="flex flex-wrap">
            <ValidationObserver tag="form" @submit.prevent="registerTaskAssign"  v-slot="{ invalid }" class="w-full">
              <div class="md:w-4/5 mx-auto p-2">
                <label for="workplace" class="leading-7 text-sm text-gray-600 dark:text-gray-400">作業場所</label>
                <ValidationProvider name="作業場所" rules="required" v-slot="{ errors }">
                  <select v-model="taskAssign.workplace_id" @change="getWorkplace(taskAssign.workplace_id)" id="workplace" name="workplace_id"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8">
                    <option value=""></option>
                    <optgroup v-for="client in clientsWithWorkplaces" :key="client.id" :label="client.name">
                      <option v-for="workplace in client.workplaces" :key="workplace.id" :value="workplace.id">{{ workplace.name }}</option>
                    </optgroup> 
                  </select>
                  <div v-if="errors" class="text-red-500 text-sm">{{ errors[0] }}</div>
                  <div v-if="errors.length === 0 && serverValidationMessage.errors?.workplace_id !== undefined" class="text-red-500 text-sm">
                    {{ serverValidationMessage.errors.workplace_id[0] }}
                  </div>
                </ValidationProvider>
              </div>
              <WorkplaceInTaskAssign :workplace="workplace" />
              <div class="md:w-4/5 mx-auto p-2">
                <label for="employeeIds" class="leading-7 text-sm text-gray-600 dark:text-gray-400">担当者</label>
                <ValidationProvider name="担当者" rules="required" v-slot="{ errors }">
                  <Employee :employees="employees" @receiveEmployeeIds="setEmployeeIds" />
                  <div v-if="errors" class="text-red-500 text-sm">{{ errors[0] }}</div>
                  <!-- <div v-if="serverValidationMessage.errors?.employee_ids !== undefined" class="text-red-500 text-sm">
                    {{ serverValidationMessage.errors.employee_ids[0] }}
                  </div> -->
                </ValidationProvider>
              </div>
              <div class="md:w-4/5 mx-auto p-2">
                <label for="implementation_date" class="leading-7 text-sm text-gray-600 dark:text-gray-400">実施日</label>
                <ValidationProvider name="実施日" rules="required" v-slot="{ errors }">
                  <Datepicker :language="jaDatepicker" format="yyyy-MM-dd" v-model="taskAssign.implementation_date" id="implementation_date" name="implementation_date" placeholder="0000-00-00"
                    input-class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8"></Datepicker>
                  <div v-if="errors" class="text-red-500 text-sm">{{ errors[0] }}</div>
                  <div v-if="errors.length === 0 && serverValidationMessage.errors?.implementation_date !== undefined" class="text-red-500 text-sm">
                    {{ serverValidationMessage.errors.implementation_date[0] }}
                  </div>
                </ValidationProvider>
              </div>
              <div class="md:w-4/5 mx-auto p-2">
                <button :disabled="invalid"
                  class="flex text-xs mx-auto text-white bg-blue-800 border-0 py-2 px-6 disabled:bg-gray-400  focus:outline-none hover:bg-blue-600 dark:text-gray-400 dark:bg-gray-700">登録</button>
              </div>
            </ValidationObserver>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { extend, ValidationProvider, ValidationObserver, localize } from 'vee-validate'
import { required, max } from 'vee-validate/dist/rules'
import jaVeeValidate from 'vee-validate/dist/locale/ja'
import Datepicker from 'vuejs-datepicker'
import { ja } from 'vuejs-datepicker/dist/locale'
import dayjs from 'dayjs'
import { errorMessage } from '../../constants/message'
import Employee from '../../components/Employee.vue'
import WorkplaceInTaskAssign from '../../components/WorkplaceInTaskAssign.vue'

localize('ja', jaVeeValidate)

extend('required', required)
extend('max', max)

export default {
  components: {
    ValidationProvider,
    ValidationObserver,
    Datepicker,
    Employee,
    WorkplaceInTaskAssign,
  },
  data() {
    return {
      taskAssign: {
        workplace_id: null,
        employee_ids: [],
        implementation_date: null,
      },
      clientsWithWorkplaces: {},
      employees: [],
      workplace: {},
      serverValidationMessage: {},
      jaDatepicker: ja,
      isLoading: {
        clientsWithWorkplaces: true,
        employees: true,
      },
    }
  },
  methods: {
    getClientsWithWorkplaces() {
      axios.get('/api/task_assign/fetch_clients_with_workplaces')
        .then(res => {
          this.clientsWithWorkplaces = res.data
        })
        .catch(error => {
          this.$toasted.error(errorMessage.systemError)
          console.error(error)
        })
        .finally(() => {
          this.isLoading.clientsWithWorkplaces = false
        })
    },
    getEmployees() {
      axios.get('/api/task_assign/fetch_employees')
        .then(res => {
          this.employees = res.data
        })
        .catch(error => {
          this.$toasted.error(errorMessage.systemError)
          console.error(error)
        })
        .finally(() => {
          this.isLoading.employees = false
        })
    },
    getWorkplace(workplaceId) {
      axios.get('/api/task_assign/fetch_workplace', {
          params: {
            workplace_id: workplaceId
          }
        })
        .then(res => {
          this.workplace = res.data
        })
        .catch(error => {
          this.$toasted.error(errorMessage.systemError)
          console.error(error)
        })
    },
    registerTaskAssign() {
      axios.post('/api/task_assign/', {
        workplace_id: this.taskAssign.workplace_id,
        employee_ids: this.taskAssign.employee_ids,
        implementation_date: dayjs(this.taskAssign.implementation_date).format('YYYY-MM-DD'),
      })
        .then(res => {
          if(res.data === 201 && res.status === 200) {
            this.$router.push({
              name: 'taskAssign',
              params: { registeredResult: 'success'}
            })
          } else {
            this.$toasted.error(errorMessage.systemError)
          }
        })
        .catch(error => {
          this.serverValidationMessage = error.response.data
        })
    },
    setEmployeeIds(employeeIds) {
      this.taskAssign.employee_ids = employeeIds
    }
  },
  created() {
    this.getClientsWithWorkplaces()
    this.getEmployees()
  }
}
</script>