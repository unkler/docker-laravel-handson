<template>
  <div class="w-full bg-gray-100 dark:bg-gray-700">
    <div class="flex mt-10 mx-4"> 
      <h2 class="font-medium text-gray-800 mr-5 dark:text-gray-400">作業場所登録</h2>
    </div>
    <div v-if="isLoading.clients || isLoading.prefectures">
      <img src="/storage/images/loading.gif" class="mx-auto mt-20" />
    </div>
    <div v-else>
      <div class="mx-4 mt-5">
        <div class="w-full mb-2 rounded-lg shadow-xs dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
          <div class="flex flex-wrap">
            <ValidationObserver tag="form" @submit.prevent="registerWorkplace"  v-slot="{ invalid }" class="w-full">
              <div class="md:w-4/5 mx-auto p-2">
                <label for="client" class="leading-7 text-sm text-gray-600 dark:text-gray-400">取引先</label>
                <ValidationProvider name="取引先" rules="required" v-slot="{ errors }">
                  <select v-model="workplace.client_id" id="client" name="prefecture_id"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8">
                    <option value=""></option>
                    <option v-for="client, index in clients" :key="index" :value="index">{{ client }}</option>                  
                  </select>
                  <div v-if="errors" class="text-red-500 text-sm">{{ errors[0] }}</div>
                  <div v-if="errors.length === 0 && serverValidationMessage.errors?.prefecture_id !== undefined" class="text-red-500 text-sm">
                    {{ serverValidationMessage.errors.prefecture_id[0] }}
                  </div>
                </ValidationProvider>
              </div>
              <div class="md:w-4/5 mx-auto p-2">
                <label for="name" class="leading-7 text-sm text-gray-600 dark:text-gray-400">作業場所</label>
                <ValidationProvider name="作業場所" rules="required|max:255" v-slot="{ errors }">
                  <input type="text" v-model="workplace.name" id="name" name="name" maxlength="255" placeholder="〇〇店"
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
                  <input type="text" v-model="workplace.post_code" @focusout="searchAddress" id="post_code"
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
                  <select v-model="workplace.prefecture_id" id="prefecture" name="prefecture_id"
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
                  <input type="text" v-model="workplace.address" id="address" name="address" maxlength="255" placeholder="〇〇市〇〇町1-2-3"
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
                  <input type="text" v-model="workplace.phone_number" id="phone_number" name="phone_number" maxlength="21" placeholder="00-0000-0000"
                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8">
                  <div v-if="errors" class="text-red-500 text-sm">{{ errors[0] }}</div>
                  <div v-if="errors.length === 0 && serverValidationMessage.errors?.phone_number !== undefined" class="text-red-500 text-sm">
                    {{ serverValidationMessage.errors.phone_number[0] }}
                  </div>
                </ValidationProvider>
              </div>
              <div class="md:w-4/5 mx-auto p-2">
                <label for="email" class="leading-7 text-sm text-gray-600 dark:text-gray-400">イメージ画像</label>
                <div class="py-2 mb-2">
                  <label class="border border-gray-500 text-gray-600 text-sm p-2 pr-32 dark:text-gray-400 cursor-pointer">
                    <input type="file" @change="uploadWorkplaceImage" class="hidden" accept="image/*">
                    <i class="fa-solid fa-plus mr-2"></i>追加
                  </label>
                </div>
                <div v-show="workplaceImagePreview" class="relative w-72 h-[216px] bg-gray-800 rounded-lg">
                  <div @click="deletePreview" class="absolute right-0 w-7 h-7  bg-gray-500 text-white rounded-tr-md text-center cursor-pointer">
                    <i class="fa-solid fa-xmark leading-7"></i>
                  </div>
                  <div class="text-center w-72 h-[216px] flex justify-center">
                    <img :src="workplaceImagePreview" class="w-auto h-auto max-w-full max-h-full rounded-md"/>
                  </div>
                </div>
                <div v-show="workplaceImageError" class="text-red-500 text-sm">{{ workplaceImageError }}</div>
                <div v-if="workplaceImageError === null && serverValidationMessage.errors?.workplace_image !== undefined" class="text-red-500 text-sm">
                  {{ serverValidationMessage.errors.workplace_image[0] }}
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
import { required, max } from 'vee-validate/dist/rules'
import jaVeeValidate from 'vee-validate/dist/locale/ja'
import jsonpAdapter from 'axios-jsonp'
import { replaceToHalfWidth } from '../../common'
import { errorMessage } from '../../constants/message'
import ImageUtil from '../../ImageUtil'

localize('ja', jaVeeValidate)

extend('required', required);
extend('max', max);

export default {
  components: {
    ValidationProvider,
    ValidationObserver,
  },
  data() {
    return {
      workplace: {
        client_id: null,
        name: null,
        post_code: null,
        prefecture_id: null,
        address: null,
        phone_number: null,
      },
      clients: {},
      prefectures: {},
      selectedWorkplaceImage: null,
      workplaceImagePreview: null,
      workplaceImageError: null,
      serverValidationMessage: {},
      isLoading: {
        clients: true,
        prefectures: true,
      },
    }
  },
  methods: {
    getClients() {
      axios.get('/api/workplace/fetch_clients')
        .then(res => {
          this.clients = res.data
        })
        .catch(error => {
          this.$toasted.error(errorMessage.systemError)
          console.error(error)
        })
        .finally(() => {
          this.isLoading.clients = false
        })
    },
    getPrefectures() {
      axios.get('/api/workplace/fetch_prefectures')
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
    registerWorkplace() {
      const formData = new FormData()

      formData.append('client_id', this.workplace.client_id)
      formData.append('name', this.workplace.name)
      formData.append('post_code', this.workplace.post_code)
      formData.append('prefecture_id', this.workplace.prefecture_id)
      formData.append('address', this.workplace.address)
      formData.append('phone_number', this.workplace.phone_number)
      formData.append('workplace_image', this.selectedWorkplaceImage)

      const config = {
          headers: {
              'content-type': 'multipart/form-data'
          }
      }

      axios.post('/api/workplace/', formData, config)
        .then(res => {
          if(res.data === 201 && res.status === 200) {
            this.$router.push({
              name: 'workplace',
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
      const replacedAddress = replaceToHalfWidth(this.workplace.post_code)
  
      axios.get(`https://api.zipaddress.net/?zipcode=${replacedAddress}`, {adapter: jsonpAdapter})
        .then(res => {
          for (let prefectureId in this.prefectures) {
            if (res.data.pref === this.prefectures[prefectureId]) {
              this.workplace.prefecture_id = prefectureId
            }
          }
          this.workplace.address = res.data.address
        })
    },
    async uploadWorkplaceImage(e) {
      const uploadedFile = e.target.files[0]

      if (uploadedFile.size > 3145728) {
        this.workplaceImageError = errorMessage.overSizeWorkplaceImageError
        return
      }

      if (uploadedFile.type !== 'image/jpeg' &&
          uploadedFile.type !== 'image/gif' && uploadedFile.type !== 'image/png') {
        this.workplaceImageError = errorMessage.informalWorkplaceImageError
        return
      }

      const compFile = await ImageUtil.getCompressImageFileAsync(uploadedFile)

      this.selectedWorkplaceImage = compFile
      this.workplaceImagePreview = URL.createObjectURL(this.selectedWorkplaceImage)
      this.workplaceImageError = null
    },
    deletePreview() {
      this.selectedWorkplaceImage = null 
      this.workplaceImagePreview = null
    },
  },
  created() {
    this.getPrefectures()
    this.getClients()
  }
}
</script>