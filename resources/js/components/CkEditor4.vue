<template>
  <div class="ckeditor-v3-wrapper">
    <textarea :id="id" ref="editorRef"></textarea>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue';

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
    if (window.CKEDITOR) {
      instance = window.CKEDITOR.replace(props.id, {
        ...props.config,
        versionCheck: false,
        uiColor: '#111827',
        toolbar: [
          { name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
          { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
          { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
          '/',
          { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
          { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl' ] },
          { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
          { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
          '/',
          { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
          { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
          { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
          { name: 'about', items: [ 'About' ] }
        ],
        contentsCss: [ 'https://cdn.ckeditor.com/4.22.1/full-all/contents.css' ],
        extraPlugins: 'colorbutton,font,justify,colordialog,showblocks',
        removeButtons: '',
        height: 350
      });

      window.CKEDITOR.addCss(`
        body { 
          background-color: #1f2937 !important; 
          color: #f3f4f6 !important; 
          font-family: ui-sans-serif, system-ui, -apple-system, sans-serif !important;
          padding: 20px !important;
        }
        a { color: #3b82f6 !important; }
        .cke_editable { line-height: 1.6 !important; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #111827; }
        ::-webkit-scrollbar-thumb { background: #374151; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #4b5563; }
      `);

      instance.on('instanceReady', () => {
        isSettingData = true;
        instance.setData(props.modelValue || '');
        isSettingData = false;
      });

      instance.on('change', () => {
        if (isSettingData) return;
        const data = instance.getData();
        if (data !== props.modelValue) {
          emit('update:modelValue', data);
        }
      });

      instance.on('blur', () => {
        if (isSettingData) return;
        emit('update:modelValue', instance.getData());
      });
    } else {
      setTimeout(initEditor, 100);
    }
  };

  initEditor();
});

onBeforeUnmount(() => {
  if (instance) {
    instance.destroy();
    instance = null;
  }
});

watch(() => props.modelValue, (newVal) => {
  if (instance && newVal !== instance.getData()) {
    isSettingData = true;
    instance.setData(newVal || '', {
      callback: () => {
        isSettingData = false;
      }
    });
  }
});
</script>

<style>
/* CKEditor 4 styling overrides to match dark theme better */
.ckeditor-v3-wrapper {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    border-radius: 0.75rem;
    overflow: hidden;
}

.cke_chrome {
    border: 1px solid rgba(55, 65, 81, 0.5) !important;
    border-radius: 0.75rem !important;
    overflow: hidden !important;
    box-shadow: none !important;
}

.cke_inner {
    background: #111827 !important; /* gray-900 */
}

.cke_top {
    background: #111827 !important;
    border-bottom: 1px solid rgba(55, 65, 81, 0.5) !important;
    padding: 8px !important;
}

.cke_bottom {
    background: #111827 !important;
    border-top: 1px solid rgba(55, 65, 81, 0.5) !important;
}

.cke_status {
    color: #6b7280 !important; /* gray-500 */
}

.cke_button_icon {
    filter: invert(0.8) hue-rotate(180deg); /* Make icons more visible on dark */
}

.cke_combo_button {
    background: #1f2937 !important; /* gray-800 */
    border: 1px solid rgba(55, 65, 81, 0.5) !important;
    border-radius: 4px !important;
}

.cke_combo_text {
    color: #d1d5db !important; /* gray-300 */
}

.cke_toolbar_separator {
    background-color: rgba(55, 65, 81, 0.5) !important;
}

/* CKEditor 4 Floating Panels (Dropdowns like Styles, Format, etc.) */
.cke_panel {
    background-color: #111827 !important;
    border: 1px solid rgba(55, 65, 81, 0.5) !important;
    border-radius: 0.75rem !important;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5) !important;
    overflow: hidden !important;
}

.cke_panel_block {
    background-color: #111827 !important;
}

.cke_panel_listItem a {
    color: #e5e7eb !important;
    padding: 6px 10px !important;
    transition: all 0.2s ease !important;
}

.cke_panel_listItem a:hover, 
.cke_panel_listItem.cke_selected a {
    background-color: #3b82f6 !important;
    color: #ffffff !important;
}

.cke_panel_grouptitle {
    background: #1f2937 !important;
    color: #9ca3af !important;
    text-shadow: none !important;
    font-size: 11px !important;
    text-transform: uppercase !important;
    letter-spacing: 0.05em !important;
    border-bottom: 1px solid rgba(55, 65, 81, 0.3) !important;
    padding: 6px 10px !important;
}

/* Scrollbar for dropdowns */
.cke_panel_block::-webkit-scrollbar {
    width: 6px;
}

.cke_panel_block::-webkit-scrollbar-track {
    background: #111827;
}

.cke_panel_block::-webkit-scrollbar-thumb {
    background: #374151;
    border-radius: 3px;
}
</style>
