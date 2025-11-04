document.addEventListener("DOMContentLoaded", function () {

  // =========================
  // Inicializar DataTable
  // =========================
  $('#diasTable').DataTable({
    responsive: true,
    dom: 'Bfrtip',
    buttons: [
      { extend: 'copy', text: '📋 Copiar' },
      { extend: 'excel', text: '📊 Excel' },
      { extend: 'pdf', text: '📑 PDF' },
      { extend: 'print', text: '🖨 Imprimir' },
      { extend: 'colvis', text: '📌 Columnas' }
    ],
    language: {
      decimal: ",",
      thousands: ".",
      lengthMenu: "Mostrar _MENU_ registros",
      zeroRecords: "No se encontraron resultados",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
      infoEmpty: "Mostrando 0 a 0 de 0 registros",
      infoFiltered: "(filtrado de _MAX_ registros en total)",
      search: "Buscar:",
      paginate: {
        first: "Primero",
        last: "Último",
        next: "Siguiente",
        previous: "Anterior"
      }
    }
  });

  // =========================
  // Abrir modal de edición
  // =========================
  document.querySelectorAll(".btn-edit").forEach(btn => {
    btn.addEventListener("click", function () {
      document.getElementById("dia_id").value = this.dataset.id;
      document.getElementById("edit_fecha").value = this.dataset.fecha;
      document.getElementById("edit_hora_inicio").value = this.dataset.hora_inicio;
      document.getElementById("edit_hora_fin").value = this.dataset.hora_fin;
      document.getElementById("edit_limite").value = this.dataset.limite;

      document
        .getElementById("editDiaForm")
        .setAttribute("action", `/dias-disponibles/${this.dataset.id}`);

      let modal = new bootstrap.Modal(document.getElementById("editarDiaModal"));
      modal.show();
    });
  });

  // =========================
  // Toastr (mensajes Laravel)
  // =========================
  if (window.toastr) {
    const successMsg = "{{ session('success') }}";
    const errorMsg = "{{ session('error') }}";

    if (successMsg) toastr.success(successMsg);
    if (errorMsg) toastr.error(errorMsg);
  }
});
