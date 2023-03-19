<template>
  <div class="w-full bg-gray-100 dark:bg-gray-700">
    <div class="flex mt-10 mx-4"> 
      <h2 class="font-medium text-gray-800 mr-5 dark:text-gray-400">取引先登録</h2>
    </div>
    <div v-if="isLoading.prefectures">
      <img src="/storage/images/loading.gif" class="mx-auto mt-20" />
    </div>
    <div v-else>
      <div class="mx-4 my-5">
        <div class="w-full mb-2 rounded-lg shadow-xs dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
          <div class="flex flex-wrap">
            <ValidationObserver tag="form" @submit.prevent="registerClient"  v-slot="{ invalid }" class="w-full">
              <div class="md:w-4/5 mx-auto p-2">
                <label for="name" class="leading-7 text-sm text-gray-600 dark:text-gray-400">取引名</label>
                <ValidationProvider name="取引名" rules="required|max:255" v-slot="{ errors }">
                  <input type="text" v-model="client.name" id="name" name="name" maxlength="255" placeholder="株式会社〇〇"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8">
                  <div v-if="errors" class="text-red-500 text-sm">{{ errors[0] }}</div>
                  <div v-if="errors.length === 0 && serverValidationMessage.errors?.name !== undefined" class="text-red-500 text-sm">
                    {{ serverValidationMessage.errors.name[0] }}
                  </div>
                </ValidationProvider>
              </div>
              <div class="md:w-4/5 mx-auto p-2">
                <label for="post_code" class="leading-7 text-sm text-gray-600 dark:text-gray-400">郵便番号</label>
                <ValidationProvider name="郵便番号" rules="required|max:8" v-slot="{ errors }">
                  <input type="text" v-model="client.post_code" @focusout="searchAddress" id="post_code"
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
                  <select v-model="client.prefecture_id" id="prefecture" name="prefecture_id"
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
                  <input type="text" v-model="client.address" id="address" name="address" maxlength="255" placeholder="〇〇市〇〇町1-2-3"
                    class="p-region p-locality p-street-address p-extended-address w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8">
                  <div v-if="errors" class="text-red-500 text-sm">{{ errors[0] }}</div>
                  <div v-if="errors.length === 0 && serverValidationMessage.errors?.address !== undefined" class="text-red-500 text-sm">
                    {{ serverValidationMessage.errors.address[0] }}
                  </div>
                </ValidationProvider>
              </div>
              <div class="md:w-4/5 mx-auto p-2">
                <label for="phone_number" class="leading-7 text-sm text-gray-600 dark:text-gray-400">電話番号</label>
                <ValidationProvider name="電話番号" rules="required|max:21" v-slot="{ errors }">
                  <input type="text" v-model="client.phone_number" id="phone_number" name="phone_number" maxlength="21" placeholder="00-0000-0000"
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
                  <input type="text" v-model="client.email"  id="email" name="email" maxlength="254" placeholder="xxx@xxx.xxx"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8">
                  <div v-if="errors" class="text-red-500 text-sm">{{ errors[0] }}</div>
                  <div v-if="errors.length === 0 && serverValidationMessage.errors?.email !== undefined" class="text-red-500 text-sm">
                    {{ serverValidationMessage.errors.email[0] }}
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
import { required, email, max } from 'vee-validate/dist/rules'
import jaVeeValidate from 'vee-validate/dist/locale/ja'
import jsonpAdapter from 'axios-jsonp'
import { replaceToHalfWidth } from '../../common'
import { errorMessage } from '../../constants/message'

localize('ja', jaVeeValidate)

extend('required', required);
extend('email', email);
extend('max', max);

export default {
  components: {
    ValidationProvider,
    ValidationObserver,
  },
  data() {
    return {
      client: {
        name: null,
        post_code: null,
        prefecture_id: null,
        address: null,
        phone_number: null,
        email: null,
      },
      prefectures: {},
      serverValidationMessage: {},
      isLoading: {
        prefectures: true,
      }
    }
  },
  methods: {
    getPrefectures() {
      axios.get('/api/client/fetch_prefectures')
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
    registerClient() {
      axios.post('/api/client/', {
        name: this.client.name,
        post_code: this.client.post_code,
        prefecture_id: this.client.prefecture_id,
        address: this.client.address,
        phone_number: this.client.phone_number,
        email: this.client.email,
      })
        .then(res => {
          if(res.data === 201 && res.status === 200) {
            this.$router.push({
              name: 'client',
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
      const replacedAddress = replaceToHalfWidth(this.client.post_code)
  
      axios.get(`https://api.zipaddress.net/?zipcode=${replacedAddress}`, {adapter: jsonpAdapter})
        .then(res => {
          for (let prefectureId in this.prefectures) {
            if (res.data.pref === this.prefectures[prefectureId]) {
              this.client.prefecture_id = prefectureId
            }
          }
          this.client.address = res.data.address
        })
    },
  },
  created() {
    this.getPrefectures()
  }
}
</script>