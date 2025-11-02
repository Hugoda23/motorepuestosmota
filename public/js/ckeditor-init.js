// ✅ public/js/ckeditor-init.js
document.addEventListener('DOMContentLoaded', function() {
  const editors = document.querySelectorAll('textarea.editor');

  if (!editors.length) return;

  editors.forEach((el) => {
    ClassicEditor
      .create(el, {
        toolbar: [
          'heading', '|',
          'bold', 'italic', 'underline', 'link', '|',
          'bulletedList', 'numberedList', '|',
          'blockQuote', 'insertTable', '|',
          'undo', 'redo'
        ],
        table: {
          contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
        },
        language: 'es'
      })
      .then(editor => {
        console.log('✅ CKEditor inicializado en:', el.id || el.name);
      })
      .catch(error => {
        console.error('❌ Error al inicializar CKEditor:', error);
      });
  });
});
