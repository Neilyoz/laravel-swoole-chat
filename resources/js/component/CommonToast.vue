<template>
  <div aria-live="assertive" aria-atomic="true">
    <!-- Then put toasts within -->
    <div
      :id="idValue"
      class="toast"
      role="alert"
      aria-live="assertive"
      aria-atomic="true"
      style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -200%); z-index: 9999;"
      data-delay="1500"
    >
      <div class="toast-header">
        <strong class="mr-auto">{{ title }}</strong>
        <button
          type="button"
          class="ml-2 mb-1 close"
          data-dismiss="toast"
          aria-label="Close"
        >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="toast-body pl-5 pr-5">
        {{ content }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    idValue: String,
    title: String,
    content: String
  }
};
</script>
