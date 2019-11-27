import Vue from "vue";
import Vuex from "vuex";
import Axios from "axios";

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    friendList: []
  },

  getters: {
    friendList: state => {
      return state.friendList;
    }
  },

  actions: {
    setFriendList({ commit, getters }, friendList) {
      commit("setFriendList", friendList);
    },
    getFriendList({ commit, getters }) {
      commit("getFriendList");
    }
  },

  mutations: {
    getFriendList(state) {
      state.friendList;
    },
    setFriendList(state, friendList) {
      state.friendList = friendList;
    }
  }
});

export default store;
