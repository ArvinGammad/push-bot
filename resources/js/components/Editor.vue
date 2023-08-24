<template>
    <medium-editor
      v-model="content"
      :prefill="defaultValue"
      :options="options"
      :on-change="onChange"
      :hide-gist="true"
      :hide-image="false"
      :hide-video="true"
      :hide-newline="false"
      @uploaded="uploadCallback"
    >
    </medium-editor>
</template>

<script lang="ts">
import Editor from 'vuejs-medium-editor' // import 'medium-editor/dist/css/medium-editor.css'

export default {
  name: 'App',
  components: {
    'medium-editor': Editor,
  },
  data() {
    return {
      content: $('#article-content').val(),
      defaultValue: $('#article-content').val(),
      options: {
        uploadUrl: 'https://api.imgur.com/3/image',
        uploadUrlHeader: { Authorization: 'Client-ID db856b43cc7f441' },
        file_input_name: 'image',
        file_size: 1024 * 1024 * 10,
        imgur: true,
        placeholder: {
          text: 'Type your content here...',
        },
        toolbar: {
          buttons: [
            'bold',
            'italic',
            {
              name: 'anchor',
              action: 'createLink',
              aria: 'link',
              tagNames: ['a'],
              contentDefault: '<b>🔗</b>',
              contentFA: '<i class="fa fa-link"></i>',
            },
            'underline',
            'quote',
            'h1',
            'h2',
            'h3',
            'h4',
            {
              name: 'justifyLeft',
              action: 'justifyLeft',
              aria: 'Align Left',
              contentDefault: '<b><i class="ti ti-align-left"></i></b>',
              contentFA: '<i class="ti ti-align-left"></i>',
            },{
              name: 'justifyCenter',
              action: 'justifyCenter',
              aria: 'Align Center',
              tagNames: ['align-center'],
              contentDefault: '<b><i class="ti ti-align-center"></i></b>',
              contentFA: '<i class="ti ti-align-center"></i>',
            },{
              name: 'justifyRight',
              action: 'justifyRight',
              aria: 'Align Right',
              contentDefault: '<b><i class="ti ti-align-right"></i></b>',
              contentFA: '<i class="ti ti-align-right"></i>',
            },{
              name: 'justifyFull',
              action: 'justifyFull',
              aria: 'Align Justify',
              contentDefault: '<b><i class="ti ti-align-justified"></i></b>',
              contentFA: '<i class="ti ti-align-justified"></i>',
            },
            {
              name: 'pre',
              action: 'append-pre',
              aria: 'code highlight',
              tagNames: ['pre'],
              contentDefault: '<b><\\></b>',
              contentFA: '<i class="fa fa-code fa-lg"></i>',
            },
            {
              name: 'unorderedlist',
              aria: 'Unordered List',
              contentDefault: '<b><i class="ti ti-list-details"></i></b>',
              contentFA: '<i class="ti ti-list-details"></i>',
            },{
              name: 'orderedlist',
              aria: 'Ordered List',
              contentDefault: '<b><i class="ti ti-list-numbers"></i></b>',
              contentFA: '<i class="ti ti-list-numbers"></i>',
            },
            {
              name: 'image',
              action: 'image',
              aria: 'insert image from url',
              tagNames: ['img'],
              contentDefault: '<b><i class="ti ti-photo-plus"></i></b>',
              contentFA: '<i class="ti ti-photo-plus"></i>',
            },
          ],
        },
      },
    }
  },
  methods: {
    onChange() {
      console.log(this.content)
    },
    uploadCallback(url: string) {
      console.log('uploaded url', url)
    },
  },
}
</script>

<style lang="css">
@import "medium-editor/dist/css/medium-editor.css";
@import "vuejs-medium-editor/dist/themes/default.css";
@import 'highlight.js/styles/github.css';
</style>