document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("imageInput");
  const preview = document.getElementById("previewImage");

  if (input && preview) {
    input.addEventListener("change", (event) => {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          preview.src = e.target.result;
          preview.classList.remove("d-none");
        };
        reader.readAsDataURL(file);
      } else {
        preview.src = "/images/placeholder.png";
        preview.classList.add("d-none");
      }
    });
  }
});
