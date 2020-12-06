<template>
  <div class="card w-100">
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" :href="tabId('write', '#')">Write</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" :href="tabId('preview', '#')">Preview</a>
        </li>
      </ul>
    </div>
    <div class="card-body tab-content">
      <div class="tab-pane active" :id="tabId('write')">
        <slot></slot>
      </div>
      <div class="tab-pane" v-html="preview" :id="tabId('preview')">
      </div>
    </div>
  </div>
</template>

<script>
import MarkdownIt from 'markdown-it'
// import MDhiglightjs from 'markdown-it-highlightjs'
import hljs from 'highlight.js'
 
let markdown = new MarkdownIt({
  highlight(str, lang){
    if(lang && hljs.getLanguage(lang)){
      try {
        console.log(lang, str)
        return '<pre class="hljs"><code>' +
                hljs.highlight(lang, str, true).value;
                '</code></pre>';
      } catch (__) {}
    } else{
      return ''
    }
  }
})

// markdown.use(MDhiglightjs)

export default {
  props: ['body', 'name'],
  computed: {
    preview(){
      // return (this.body)
      
      return markdown.render(this.body)
    }
  },
  methods: {
    tabId(tabName, hash = ''){
      return `${hash}${tabName}-${this.name}`
    }
  }
}
</script>

<style></style>
