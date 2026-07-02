<template>
  <div class="tinymce-wrapper">
    <textarea :id="id" ref="editorRef"></textarea>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue';
import axios from 'axios';

const props = defineProps({
  modelValue: {
    type: String,
    default: ''
  },
  id: {
    type: String,
    default: () => `editor-${Math.random().toString(36).substr(2, 9)}`
  },
  config: {
    type: Object,
    default: () => ({})
  }
});

const emit = defineEmits(['update:modelValue']);

const editorRef = ref(null);
let instance = null;
let isSettingData = false;

onMounted(() => {
  const initEditor = () => {
    if (window.tinymce) {
      window.tinymce.init({
        target: editorRef.value,
        height: 350,
        menubar: 'file edit view insert format tools table help',
        promotion: false,
        skin: 'oxide-dark',
        content_css: 'dark',
        plugins: [
          'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
          'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
          'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks fontfamily fontsize | ' +
          'bold italic underline strikethrough | forecolor backcolor | ' +
          'link image media table | alignleft aligncenter alignright alignjustify | ' +
          'bullist numlist outdent indent | removeformat | code fullscreen help',
        images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
          const formData = new FormData();
          formData.append('file', blobInfo.blob(), blobInfo.filename());

          axios.post('/admin/editor/upload-image', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            },
            onUploadProgress: (e) => {
              progress(e.loaded / e.total * 100);
            }
          })
          .then(response => {
            if (response.data && response.data.location) {
              resolve(response.data.location);
            } else {
              reject('Invalid upload response');
            }
          })
          .catch(error => {
            reject(error.response?.data?.error || error.response?.data?.message || error.message || 'Image upload failed');
          });
        }),
        ...props.config,
        setup: (editor) => {
          instance = editor;
          editor.on('init', () => {
            isSettingData = true;
            editor.setContent(props.modelValue || '');
            isSettingData = false;
          });
          editor.on('input change undo redo keyup ExecCommand NodeChange SetContent', () => {
            if (isSettingData) return;
            emit('update:modelValue', editor.getContent());
          });
        }
      });
    } else {
      setTimeout(initEditor, 100);
    }
  };

  initEditor();
});

onBeforeUnmount(() => {
  if (instance) {
    instance.remove();
    instance = null;
  }
});

watch(() => props.modelValue, (newVal) => {
  if (instance && newVal !== instance.getContent()) {
    isSettingData = true;
    instance.setContent(newVal || '');
    isSettingData = false;
  }
});
</script>

<style>
.tinymce-wrapper {
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  border-radius: 0.75rem;
  overflow: hidden;
}
.tox-tinymce {
  border: 1px solid rgba(55, 65, 81, 0.5) !important;
  border-radius: 0.75rem !important;
}
</style>

