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
                data-target=".bd-example-modal-lg"
                >个人信息编辑</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="javascript:void(0);">添加好友</a>
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
              v-for="(item, index) in onlineList"
            >
              <img :src="item.head_pic" alt="" />
              <div class="username">@{{ item.username }}</div>
            </div>
          </div>
          <div class="chat-container flex-grow-1 border">
            <div class="chat-content-list border-bottom">
              <div :key="item + index" v-for="(item, index) in chatList">
                <div class="chat-self-item" v-if="isMySelf(item.user_id)">
                  <div class="chat-content-item mr-3">@{{ item.content }}</div>
                  <div class="img-head-pic">
                    <img :src="item.head_pic" alt="" />
                  </div>
                </div>

                <div class="chat-item" v-else>
                  <div class="img-head-pic mr-3">
                    <img :src="item.head_pic" alt="" />
                  </div>
                  <div class="chat-content-item">@{{ item.content }}</div>
                </div>
              </div>
            </div>
            <div class="chat-control p-3">
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
  </div>
</template>

<script>
export default {
  data() {
    return {
      onlineList: [],
      chatList: [],
      message: ""
    };
  },

  methods: {
    sendMessage() {}
  }
};
</script>
