<template>
  <div>
    <input type="hidden" name="employee_ids" :value="registrationIds">
    <select @change="addEmployeeToRegistrationList"
      class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
      <option value=""></option>
      <option
        v-for="employee in employees"
        :value="employee.id"
        :key="employee.id"
      >
        {{ employee.last_name + employee.first_name }}
      </option>
    </select>
    <ul class="mt-2 flex flex-wrap">
      <li v-for="registrationList in registrationLists" :key="registrationList.id"
        class="w-1/3 p-2 border border-gray-200 rounded-lg shadow-md flex justify-between"
      >
        <span class="pl-1">{{ registrationList.name}}</span>
        <span>
          <i @click="removeEmployeeToRegistrationList(registrationList.id)"
            class="text-lg cursor-pointer pr-1 fa-solid fa-circle-xmark"></i>
        </span>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    employees: Array,
    oldEmployees: Array,
  },
  data() {
    return {
      registrationLists: [],
      registrationIds: [],
    };
  },
  methods: {
    addEmployeeToRegistrationList(e) {

      //配列重複チェック(空文字は除外する)
      const isDuplication = this.registrationIds.some(registrationId => {
        if(registrationId === e.target.value || e.target.value === '') return true
      })

      if (!isDuplication) {
        this.registrationLists.push({
          id: e.target.value,
          name: e.target.selectedOptions[0].text,
        });
  
        //バリデーションエラー時に配列の先頭に空文字が挿入される場合は初期化
        if (this.registrationIds[0] === '') this.registrationIds = []

        this.registrationIds.push(e.target.value)

        this.$emit('receiveEmployeeIds', this.registrationIds)
      }
      
    },
    removeEmployeeToRegistrationList(id) {
      this.registrationLists = this.registrationLists.filter((registrationList) => {
        return (registrationList.id !== id)
      })

      this.registrationIds = this.registrationIds.filter((registrationId) => {
        return (registrationId !== id)
      })

      this.$emit('receiveEmployeeIds', this.registrationIds)
    },
  },
  created() {
    if(this.oldEmployees !== undefined) {
      this.oldEmployees.forEach(oldEmployee => {
        this.registrationLists.push({
          id: oldEmployee.id,
          name: oldEmployee.last_name + oldEmployee.first_name
        })

        this.registrationIds.push(String(oldEmployee.id))
      })
    }
  }
}
</script>