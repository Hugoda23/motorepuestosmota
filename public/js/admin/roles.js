document.addEventListener('DOMContentLoaded', function () {
  const editButtons = document.querySelectorAll('.edit-btn');
  const editForm = document.getElementById('editRoleForm');
  const idInput = document.getElementById('editRoleId');
  const nameInput = document.getElementById('editRoleName');
  const displayInput = document.getElementById('editRoleDisplay');

  editButtons.forEach(button => {
    button.addEventListener('click', function () {
      const id = this.dataset.id;
      const name = this.dataset.name;
      const display = this.dataset.display || '';

      idInput.value = id;
      nameInput.value = name;
      displayInput.value = display;

      // Cambiar acción del formulario dinámicamente
      editForm.action = `/admin/roles/${id}`;
    });
  });
});
