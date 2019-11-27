<template>
  <div>
    <div class="container">
      <div class="full-screen">
        <div class="mt-2 mb-2">
          <ul class="nav justify-content-end">
            <li class="nav-item">
              <a
                class="nav-link"
                href="javascript:void(0);"
                data-toggle="modal"
                data-target="#edit-user-info"
                >个人信息编辑</a
              >
            </li>
            <li class="nav-item">
              <a
                class="nav-link"
                href="javascript:void(0);"
                data-toggle="modal"
                data-target="#add-friend"
                >添加好友</a
              >
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="javascript:void(0);">创建群组</a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link" href="/logout">退出</a>
            </li>
          </ul>
        </div>
        <div class="d-flex">
          <div class="user-list border-left border-top border-bottom">
            <div
              :key="index"
              class="user-item border-bottom"
              v-for="(item, index) in friendList"
              @click="selectToUser(item)"
            >
              <img :src="item.head_pic" alt="" />
              <div class="username">{{ item.name }}</div>
            </div>
          </div>

          <div class="chat-container flex-grow-1 border">
            <div class="chat-content-list">
              <div :key="item + index" v-for="(item, index) in chatList">
                <div class="chat-self-item" v-if="isMySelf(item.id)">
                  <div class="chat-content-item mr-3">{{ item.message }}</div>
                  <div class="img-head-pic">
                    <img :src="item.head_pic" alt="" />
                  </div>
                </div>

                <div class="chat-item" v-else>
                  <div class="img-head-pic mr-3">
                    <img :src="item.head_pic" alt="" />
                  </div>
                  <div class="chat-content-item">{{ item.message }}</div>
                </div>
              </div>
            </div>

            <div class="chat-control p-3 border-top" v-if="to_id">
              <form v-on:submit.prevent="sendMessage">
                <div class="form-group">
                  <label for="chat-content">发送消息：</label>
                  <input type="text" class="form-control" v-model="message" />
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">
                    发送
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <edit-user-info></edit-user-info>
    <add-friend></add-friend>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user_id: "",
      to_id: "",
      chatList: [],
      message: "",
      websocket: null,
      user: null
    };
  },

  computed: {
    friendList() {
      return this.$store.getters.friendList;
    }
  },

  async created() {
    const user = await this.fetchUserInfo();
    this.init(user.id);
    await this.fetchFriends();
  },

  methods: {
    async init(id) {
      let that = this;
      const ws = new WebSocket("ws://localhost:9501");

      ws.onopen = function(event) {
        if (id) {
          ws.send(JSON.stringify({ type: "init", uid: id }));
        }
      };

      ws.onmessage = function(event) {
        console.log(event.data);
        const message = JSON.parse(event.data);
        switch (message.type) {
          case "message":
            that.handleMessage(message);
            break;
        }
      };

      this.websocket = ws;
    },

    sendMessage() {
      if (!this.to_id) {
        alert("请选择聊天用户");
        return;
      }

      if (!this.message) {
        return;
      }

      const data = { type: "message", to: this.to_id, content: this.message };
      this.websocket.send(JSON.stringify(data));
      this.chatList.push({
        ...this.user,
        message: this.message
      });
      this.message = "";
    },

    async fetchUserInfo() {
      const res = await this.$http.get("/userinfo");
      this.user = res.data;
      return res.data;
    },

    async fetchFriends() {
      const res = await this.$http.get("/friend-list");
      // this.friendList = res.data;
      this.$store.dispatch("setFriendList", res.data);
    },

    selectToUser(item) {
      this.to_id = item.id;
    },

    // 处理接收信息
    handleMessage(data) {
      console.log(data);
      const friend = _.find(this.friendList, item => {
        return +item.id === +data.from;
      });
      friend.message = data.content;

      this.chatList.push(friend);
    },

    isMySelf(id) {
      return +this.user.id === +id;
    }
  }
};
</script>
