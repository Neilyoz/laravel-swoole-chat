<template>
  <div
    :id="idValue"
    class="modal fade"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            {{ title }}
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
          <slot></slot>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            关闭
          </button>
          <button type="button" class="btn btn-primary" @click="$emit('save')">
            保存
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    idValue: String,
    title: String
  }
};
</script>
