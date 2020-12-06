import highlight from 'highlight.js'
import autosize from 'autosize'

export default{
  updated(){
    autosize(this.$refs.textbox)

    highlight.highlightBlock(this.$refs.bodyHtml.querySelector('pre code'))
  },  
  mounted(){
    let mdText = this.$refs.bodyHtml.querySelector('pre code')

    if(mdText){
      highlight.highlightBlock(mdText)
    }
  }
}