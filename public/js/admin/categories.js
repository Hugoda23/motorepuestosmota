document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("imageInput");
  const preview = document.getElementById("previewImage");

  if (input) {
    input.addEventListener("change", (e) => {
      const file = e.target.files[0];

      if (file) {
        const reader = new FileReader();
        reader.onload = (event) => {
          preview.src = event.target.result;
          preview.classList.remove("d-none");
        };
        reader.readAsDataURL(file);
      } else {
        preview.src = "";
        preview.classList.add("d-none");
      }
    });
  }
});
