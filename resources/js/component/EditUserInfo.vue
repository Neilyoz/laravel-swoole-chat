<template>
  <div>
    <div
      class="modal fade bd-example-modal-lg"
      id="edit-user-info"
      tabindex="-1"
      role="dialog"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalScrollableTitle">
              个人信息编辑
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form v-on:submit.prevent="storeUserInfo">
              <div class="form-group">
                <label for="">头像</label>
                <div class="head-pic">
                  <label for="upload">
                    <img
                      class="img_head"
                      :src="formData.head_pic"
                      v-if="formData.head_pic"
                    />
                    <div class="img_head" v-if="!formData.head_pic">➕</div>
                  </label>
                  <input
                    type="file"
                    id="upload"
                    @change="uploadHeadPic"
                    style="display: none;"
                    ref="headpictrue"
                  />
                </div>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">邮箱</label>
                <input
                  type="email"
                  class="form-control"
                  v-model="formData.email"
                  readonly
                />
              </div>
              <div class="form-group">
                <label>名称</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="formData.name"
                />
              </div>
              <div class="form-group">
                <label>密码</label>
                <input
                  type="password"
                  class="form-control"
                  v-model="formData.password"
                />
              </div>
              <button type="submit" style="display:none;"></button>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              关闭
            </button>
            <button
              type="button"
              class="btn btn-primary"
              @click="storeUserInfo"
            >
              保存
            </button>
          </div>
        </div>
      </div>
    </div>

    <common-toast
      idValue="toast"
      title="提示"
      content="修改成功"
    ></common-toast>
  </div>
</template>

<script>
export default {
  data() {
    return {
      formData: {
        head_pic: "",
        name: "",
        email: "",
        password: ""
      }
    };
  },
  async created() {
    await this.fetchUserInfo();
  },
  methods: {
    async uploadHeadPic() {
      const formData = new FormData();
      formData.append("file", this.$refs.headpictrue.files[0]);
      const res = await this.$http.post("/upload", formData);
      this.formData.head_pic = res.data.path;
    },

    async fetchUserInfo() {
      const res = await this.$http.get("/userinfo");

      Object.assign(this.formData, res.data);
    },

    async storeUserInfo() {
      const res = await this.$http.put("/userinfo", this.formData);
      if (res.status === 200) {
        $(".bd-example-modal-lg").modal("hide");
        $("#toast").toast("show");
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.head-pic {
  .img_head {
    display: inline-flex;
    width: 86px;
    height: 86px;
    cursor: pointer;
    text-align: center;
    align-items: center;
    justify-content: center;
    color: gainsboro;
  }

  border: 1px gainsboro dashed;
  border-radius: 3px;
  padding: 1px;
  width: 90px;
  height: 90px;
  cursor: pointer;
}
</style>
