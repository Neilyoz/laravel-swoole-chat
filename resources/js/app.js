require("./bootstrap");

window.Vue = require("vue");

Vue.component("main-page", require("./component/MainPage").default);
Vue.component("edit-user-info", require("./component/EditUserInfo").default);
Vue.component("add-friend", require("./component/AddFriend").default);
Vue.component("common-modal", require("./component/CommonModal").default);
Vue.component("common-toast", require("./component/CommonToast").default);

Vue.prototype.$http = axios;

const store = require("./store").default;

const app = new Vue({
  el: "#app",
  store
});
