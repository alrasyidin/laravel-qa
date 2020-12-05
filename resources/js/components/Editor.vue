<template>
  <div class="card w-100">
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#write">Write</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#preview">Preview</a>
        </li>
      </ul>
    </div>
    <div class="card-body tab-content">
      <div class="tab-pane active" id="write">
        <slot></slot>
      </div>
      <div class="tab-pane" v-html="preview" id="preview">
      </div>
    </div>
  </div>
</template>

<script>
import MarkdownIt from 'markdown-it'
let markdown = new MarkdownIt()

export default {
  props: ['body'],
  computed: {
    preview(){
      return markdown.render(this.body)
    }
  }
}
</script>

<style></style>
