<template>
  <div class="w-full bg-gray-100 dark:bg-gray-700">
    <div class="flex mt-10 mx-4"> 
      <h2 class="font-medium text-gray-800 mr-5 dark:text-gray-400">社員登録</h2>
    </div>
    <div v-if="isLoading.contractTypes || isLoading.prefectures">
      <img src="/storage/images/loading.gif" class="mx-auto mt-20" />
    </div>
    <div v-else>
      <div class="mx-4 my-5">
        <div class="w-full mb-2 rounded-lg shadow-xs dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
          <div class="flex flex-wrap">
            <ValidationObserver tag="form" @submit.prevent="registerEmployee"  v-slot="{ invalid }" class="w-full">
              <div class="md:w-4/5 mx-auto mt-3 p-2">
                <label for="last_name" class="leading-7 text-sm text-gray-600 dark:text-gray-400">氏名</label>
                <div class="flex justify-between">
                  <ValidationProvider name="姓" rules="required|max:30" v-slot="{ errors }" class="w-full mr-2">
                    <input type="text" v-model="employee.last_name" id="last_name" name="last_name" maxlength="30" placeholder="姓"
                      class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 ">
                    <div v-if="errors" class="text-red-500 text-sm">{{ errors[0] }}</div>
                    <div v-if="errors.length === 0 && serverValidationMessage.errors?.last_name !== undefined" class="text-red-500 text-sm">
                      {{ serverValidationMessage.errors.last_name[0] }}
                    </div>
                  </ValidationProvider>
                  <ValidationProvider name="名" rules="required|max:30" v-slot="{ errors }" class="w-full">
                    <input type="text" v-model="employee.first_name" id="first_name" name="first_name" maxlength="30" placeholder="名"
                      class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8">
                    <div v-if="errors" class="text-red-500 text-sm">{{ errors[0] }}</div>
                    <div v-if="errors.length === 0 && serverValidationMessage.errors?.first_name !== undefined" class="text-red-500 text-sm">
                      {{ serverValidationMessage.errors.first_name[0] }}
                    </div>
                  </ValidationProvider>
                </div>
              </div>
              <div class="md:w-4/5 mx-auto p-2">
                <label for="last_name_kana" class="leading-7 text-sm text-gray-600 dark:text-gray-400">氏名(カタカナ)</label>
                <div class="flex justify-between">
                  <ValidationProvider name="セイ" rules="required|max:30" v-slot="{ errors }" class="w-full mr-2">
                    <input type="text" v-model="employee.last_name_kana" id="last_name_kana" name="last_name_kana" maxlength="30" placeholder="セイ"
                      class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8">
                    <div v-if="errors" class="text-red-500 text-sm">{{ errors[0] }}</div>
                    <div v-if="errors.length === 0 && serverValidationMessage.errors?.first_name_kana !== undefined" class="text-red-500 text-sm">
                      {{ serverValidationMessage.errors.first_name_kana[0] }}
                    </div>
                  </ValidationProvider>
                  <ValidationProvider name="メイ" rules="required|max:30" v-slot="{ errors }" class="w-full mr-2">
                    <input type="text" v-model="employee.first_name_kana"  id="first_name_kana" name="first_name_kana" maxlength="30" placeholder="メイ"
                      class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8">
                    <div v-if="errors" class="text-red-500 text-sm">{{ errors[0] }}</div>
                    <div v-if="errors.length === 0 && serverValidationMessage.errors?.last_name_kana !== undefined" class="text-red-500 text-sm">
                      {{ serverValidationMessage.errors.last_name_kana[0] }}
                    </div>
                  </ValidationProvider>
                </div>
              </div>
              <div class="md:w-4/5 mx-auto p-2">
                <label for="contract_type" class="leading-7 text-sm text-gray-600 dark:text-gray-400">雇用区分</label>
                <ValidationProvider name="雇用区分" rules="required" v-slot="{ errors }">
                  <select v-model="employee.contract_type_id" id="contract_type" name="contract_type_id"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8">
                    <option value=""></option>
                    <option v-for="contractType, index in contractTypes" :key="index" :value="index">{{ contractType  }}</option>                  
                  </select>
                  <div v-if="errors" class="text-red-500 text-sm">{{ errors[0] }}</div>
                  <div v-if="errors.length === 0 && serverValidationMessage.errors?.contract_type_id !== undefined" class="text-red-500 text-sm">
                    {{ serverValidationMessage.errors.contract_type_id[0] }}
                  </div>
                </ValidationProvider>
              </div>
              <div class="md:w-4/5 mx-auto p-2">
                <label for="post_code" class="leading-7 text-sm text-gray-600 dark:text-gray-400">郵便番号</label>
                <ValidationProvider name="郵便番号" rules="required|max:8" v-slot="{ errors }">
                  <input type="text" v-model="employee.post_code" @focusout="searchAddress" id="post_code"
                    name="post_code" maxlength="8" placeholder="000-00000"
                    class="p-postal-code w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8">
                  <div v-if="errors" class="text-red-500 text-sm">{{ errors[0] }}</div>
                  <div v-if="errors.length === 0 && serverValidationMessage.errors?.post_code !== undefined" class="text-red-500 text-sm">
                    {{ serverValidationMessage.errors.post_code[0] }}
                  </div>
                </ValidationProvider>
              </div>
              <div class="md:w-4/5 mx-auto p-2">
                <label for="prefecture" class="leading-7 text-sm text-gray-600 dark:text-gray-400">都道府県</label>
                <ValidationProvider name="都道府県" rules="required" v-slot="{ errors }">
                  <select v-model="employee.prefecture_id" id="prefecture" name="prefecture_id"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8">
                    <option value=""></option>
                    <option v-for="prefecture, index in prefectures" :key="index" :value="index">{{ prefecture }}</option>                  
                  </select>
                  <div v-if="errors" class="text-red-500 text-sm">{{ errors[0] }}</div>
                  <div v-if="errors.length === 0 && serverValidationMessage.errors?.prefecture_id !== undefined" class="text-red-500 text-sm">
                    {{ serverValidationMessage.errors.prefecture_id[0] }}
                  </div>
                </ValidationProvider>
              </div>
              <div class="md:w-4/5 mx-auto p-2">
                <label for="address" class="leading-7 text-sm text-gray-600 dark:text-gray-400">住所</label>
                <ValidationProvider name="住所" rules="required|max:255" v-slot="{ errors }">
                  <input type="text" v-model="employee.address" id="address" name="address" maxlength="255" placeholder="〇〇市〇〇町1-2-3"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8">
                  <div v-if="errors" class="text-red-500 text-sm">{{ errors[0] }}</div>
                  <div v-if="errors.length === 0 && serverValidationMessage.errors?.address !== undefined" class="text-red-500 text-sm">
                    {{ serverValidationMessage.errors.address[0] }}
                  </div>
                </ValidationProvider>
              </div>
              <div class="md:w-4/5 mx-auto p-2">
                <label for="phone_number" class="leading-7 text-sm text-gray-600 dark:text-gray-400">電話番号</label>
                <ValidationProvider name="電話番号" rules="required|max:21" v-slot="{ errors }">
                  <input type="text" v-model="employee.phone_number" id="phone_number" name="phone_number" maxlength="21" placeholder="00-0000-0000"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8">
                  <div v-if="errors" class="text-red-500 text-sm">{{ errors[0] }}</div>
                  <div v-if="errors.length === 0 && serverValidationMessage.errors?.phone_number !== undefined" class="text-red-500 text-sm">
                    {{ serverValidationMessage.errors.phone_number[0] }}
                  </div>
                </ValidationProvider>
              </div>
              <div class="md:w-4/5 mx-auto p-2">
                <label for="email" class="leading-7 text-sm text-gray-600 dark:text-gray-400">メールアドレス</label>
                <ValidationProvider name="メールアドレス" rules="required|email|max:254" v-slot="{ errors }">
                  <input type="text" v-model="employee.email"  id="email" name="email" maxlength="254" placeholder="xxx@xxx.xxx"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8">
                  <div v-if="errors" class="text-red-500 text-sm">{{ errors[0] }}</div>
                  <div v-if="errors.length === 0 && serverValidationMessage.errors?.email !== undefined" class="text-red-500 text-sm">
                    {{ serverValidationMessage.errors.email[0] }}
                  </div>
                </ValidationProvider>
              </div>
              <div class="md:w-4/5 mx-auto p-2">
                <label for="birthday" class="leading-7 text-sm text-gray-600 dark:text-gray-400">生年月日</label>
                <ValidationProvider name="生年月日" rules="required" v-slot="{ errors }">
                  <datepicker :language="jaDatepicker" format="yyyy-MM-dd" v-model="employee.birthday" id="birthday" name="birthday" placeholder="0000-00-00"
                    input-class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8"></datepicker>
                  <div v-if="errors" class="text-red-500 text-sm">{{ errors[0] }}</div>
                  <div v-if="errors.length === 0 && serverValidationMessage.errors?.birthday !== undefined" class="text-red-500 text-sm">
                    {{ serverValidationMessage.errors.birthday[0] }}
                  </div>
                </ValidationProvider>
              </div>
              <div class="md:w-4/5 mx-auto p-2">
                <label for="email" class="leading-7 text-sm text-gray-600 dark:text-gray-400">プロフィール画像</label>
                <div class="py-2 mb-2">
                  <label class="border border-gray-400 text-gray-600 text-sm p-2 pr-32 cursor-pointer dark:text-gray-400">
                    <input type="file" @change="uploadProfileImage" class="hidden" accept="image/*">
                    <i class="fa-solid fa-plus mr-2"></i>追加
                  </label>
                </div>
                <div v-show="profileImagePreview" class="relative w-72 h-[216px] bg-gray-800 rounded-lg">
                  <div @click="deletePreview" class="absolute right-0 w-7 h-7  bg-gray-500 text-white rounded-tr-md text-center cursor-pointer">
                    <i class="fa-solid fa-xmark leading-7"></i>
                  </div>
                  <div class="text-center w-72 h-[216px] flex justify-center">
                    <img :src="profileImagePreview" class="w-auto h-auto max-w-full max-h-full rounded-md"/>
                  </div>
                </div>
                <div v-show="profileImageError" class="text-red-500 text-sm">{{ profileImageError }}</div>
                <div v-if="profileImageError === null && serverValidationMessage.errors?.profile_image !== undefined" class="text-red-500 text-sm">
                  {{ serverValidationMessage.errors.profile_image[0] }}
                </div>
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
import { required, email, max } from 'vee-validate/dist/rules'
import jaVeeValidate from 'vee-validate/dist/locale/ja'
import jsonpAdapter from 'axios-jsonp'
import Datepicker from 'vuejs-datepicker'
import { ja } from 'vuejs-datepicker/dist/locale'
import dayjs from 'dayjs'
import { replaceToHalfWidth } from '../../common'
import { errorMessage } from '../../constants/message'
import ImageUtil from '../../ImageUtil'

localize('ja', jaVeeValidate)

extend('required', required);
extend('email', email);
extend('max', max);

export default {
  components: {
    ValidationProvider,
    ValidationObserver,
    Datepicker,
  },
  data() {
    return {
      employee: {
        last_name: null,
        first_name: null,
        last_name_kana: null,
        first_name_kana: null,
        contract_type_id: null,
        post_code: null,
        prefecture_id: null,
        address: null,
        phone_number: null,
        email: null,
        birthday: null,
      },
      contractTypes: {},
      prefectures: {},
      selectedProfileImage: null,
      profileImagePreview: null,
      profileImageError: null,
      serverValidationMessage: {},
      jaDatepicker: ja,
      isLoading: {
        contractTypes: true,
        prefectures: true,
      },
    }
  },
  methods: {
    getContractTypes() {
      axios.get('/api/employee/fetch_contract_types')
        .then(res => {
          this.contractTypes = res.data
        })
        .catch(error => {
          this.$toasted.error(errorMessage.systemError)
          console.error(error)
        })
        .finally(() => {
          this.isLoading.contractTypes = false
        })
    },
    getPrefectures() {
      axios.get('/api/employee/fetch_prefectures')
        .then(res => {
          this.prefectures = res.data
        })
        .catch(error => {
          this.$toasted.error(errorMessage.systemError)
          console.error(error)
        })
        .finally(() => {
          this.isLoading.prefectures = false
        })
    },
    registerEmployee() {
      const formData = new FormData()

      formData.append('last_name', this.employee.last_name)
      formData.append('first_name', this.employee.first_name)
      formData.append('last_name_kana', this.employee.last_name_kana)
      formData.append('first_name_kana', this.employee.first_name_kana)
      formData.append('contract_type_id', this.employee.contract_type_id)
      formData.append('post_code', this.employee.post_code)
      formData.append('prefecture_id', this.employee.prefecture_id)
      formData.append('address', this.employee.address)
      formData.append('phone_number', this.employee.phone_number)
      formData.append('email', this.employee.email)
      formData.append('birthday', dayjs(this.employee.birthday).format('YYYY-MM-DD'))
      formData.append('profile_image', this.selectedProfileImage)

      const config = {
          headers: {
              'content-type': 'multipart/form-data'
          }
      }
  
      axios.post('/api/employee/', formData, config)
        .then(res => {
          if(res.data === 201 && res.status === 200) {
            this.$router.push({
              name: 'employee',
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
    searchAddress() {
      const replacedAddress = replaceToHalfWidth(this.employee.post_code)
  
      axios.get(`https://api.zipaddress.net/?zipcode=${replacedAddress}`, {adapter: jsonpAdapter})
        .then(res => {
          for (let prefectureId in this.prefectures) {
            if (res.data.pref === this.prefectures[prefectureId]) {
              this.employee.prefecture_id = prefectureId
            }
          }
          this.employee.address = res.data.address
        })
    },
    async uploadProfileImage(e) {
      const uploadedFile = e.target.files[0]

      if (uploadedFile.size > 3145728) {
        this.profileImageError = errorMessage.overSizeProfileImageError
        return
      }

      if (uploadedFile.type !== 'image/jpeg' &&
          uploadedFile.type !== 'image/gif' && uploadedFile.type !== 'image/png') {
        this.profileImageError = errorMessage.informalProfileImageError
        return
      }

      const compFile = await ImageUtil.getCompressImageFileAsync(uploadedFile)

      this.selectedProfileImage = compFile
      this.profileImagePreview = URL.createObjectURL(this.selectedProfileImage)
      this.profileImageError = null
    },
    deletePreview() {
      this.selectedProfileImage = null 
      this.profileImagePreview = null
    }
  },
  created() {
    this.getContractTypes()
    this.getPrefectures()
  }
}
</script>