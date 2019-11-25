# Vue 自定义上传组件

在这个项目里面并没有封装组件，只是单纯的美化了`<input type="file" id="idValue"/>`，也挺简单的，就是给标签一个 id 值，然后通过`<label for="idValue"></label>`在点击这个`label`的时候，会激活`input`选择上传文件的窗口。

然后就是`input`的`change`事件的触发，然后后端接口返回的值，直接替换我们 vue 中`data`的值就 OK 了。
