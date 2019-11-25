require("./bootstrap");

window.Vue = require("vue");

Vue.component("main-page", require("./component/MainPage").default);
Vue.component("edit-user-info", require("./component/EditUserInfo").default);

Vue.prototype.$http = axios;

const app = new Vue({
  el: "#app"
});
