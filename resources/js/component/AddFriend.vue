<template>
  <div>
    <common-modal idValue="add-friend" title="添加好友" @save="storeFriendInfo">
      <div>
        <form v-on:submit.prevent="storeFriendInfo">
          <div class="form-group">
            <label for="chat-content">好友邮箱</label>
            <input type="text" class="form-control" v-model="email" />
          </div>
        </form>
      </div>
    </common-modal>

    <common-toast
      idValue="add-friend-info"
      title="提示"
      :content="toast.content"
    />
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: "",
      toast: {
        content: "添加成功"
      }
    };
  },
  methods: {
    async storeFriendInfo() {
      try {
        const res = await this.$http.post("/add-friend", {
          email: this.email
        });

        if (res.status === 200) {
          $("#add-friend").modal("hide");
          this.toast.content = "添加成功";
          $("#add-friend-info").toast("show");
        }
      } catch (e) {
        this.toast.content = e.response.data.message;
        $("#add-friend-info").toast("show");
      }
    }
  }
};
</script>
