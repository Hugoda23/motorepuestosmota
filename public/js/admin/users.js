document.addEventListener("DOMContentLoaded", () => {
  const editButtons = document.querySelectorAll(".btn-edit");

  editButtons.forEach(btn => {
    btn.addEventListener("click", () => {
      const id = btn.dataset.id;
      const name = btn.dataset.name;
      const email = btn.dataset.email;
      const role = btn.dataset.role;

      document.getElementById("edit_user_id").value = id;
      document.getElementById("edit_name").value = name;
      document.getElementById("edit_email").value = email;
      document.getElementById("edit_role_id").value = role;

      document.getElementById("editUserForm").action = `/admin/usuarios/${id}`;
      const modal = new bootstrap.Modal(document.getElementById("editUserModal"));
      modal.show();
    });
  });
});
