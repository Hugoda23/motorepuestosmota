// resources/js/ckeditor.js
document.addEventListener('DOMContentLoaded', function () {
    const editorElement = document.querySelector('#featuresEditor');
    if (editorElement) {
        ClassicEditor
            .create(editorElement, {
                toolbar: [
                    'undo', 'redo', '|',
                    'bold', 'italic', 'underline', 'link', '|',
                    'bulletedList', 'numberedList', '|',
                    'blockQuote'
                ]
            })
            .catch(error => console.error('Error inicializando CKEditor:', error));
    }
});
