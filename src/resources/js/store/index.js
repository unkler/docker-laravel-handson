import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
	state: {
		modal: {
			isOpen: false,
			message: '',
      resolve: (bool) => bool,
      reject: (bool) => bool,
		},
	},
	mutations: {
		commitModalOpen(state, payload) {
			state.modal = payload
		},
		commitResetModalState(state) {
			state.modal = {
				type: '',
				text: '',
				resolve: (bool) => bool,
				reject: (bool) => bool,
			}
		},
	},
	actions: {
		actionModalOpen({ commit }, payload) {
      // Promiseインスタンスを生成
      return new Promise((resolve, reject) => {
        const option = {
          resolve,
          reject,
          ...payload,
        }
        // payloadのデータと「resolve」「reject」をstateに保存
        commit('commitModalOpen', option)
      })
    },

    // モーダル内の「OK」ボタンがクリックされたら「resolve」を実行させる。
		actionModalResolve({ commit, state }) {
			state.modal.resolve(true) // 4.モーダルの呼び出し元に、実行結果を返す
			commit('commitResetModalState')
		},
    // キャンセル」ボタンなら「reject」を実行させる
		actionModalReject({ commit, state }) {
			state.modal.reject(false) // 4.モーダルの呼び出し元に、実行結果を返す
			commit('commitResetModalState')
		},
	},
	modules: {},
})