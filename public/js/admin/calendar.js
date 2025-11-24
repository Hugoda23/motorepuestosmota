document.addEventListener('DOMContentLoaded', function () {
  const calendarEl = document.getElementById('calendar');
  const alertContainer = document.createElement('div');
  alertContainer.id = 'calendar-alert';
  alertContainer.className = 'position-fixed top-0 start-50 translate-middle-x mt-3';
  alertContainer.style.zIndex = '2000';
  document.body.appendChild(alertContainer);

  // 🔔 Función para mostrar alerta Bootstrap
  function showAlert(message, type = 'danger') {
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show shadow`;
    alert.role = 'alert';
    alert.innerHTML = `
      <strong>${type === 'danger' ? '⚠️ ' : '✅ '}</strong> ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    alertContainer.appendChild(alert);

    setTimeout(() => {
      alert.classList.remove('show');
      setTimeout(() => alert.remove(), 200);
    }, 4000);
  }

  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'es',
    selectable: true,
    themeSystem: 'bootstrap5',
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    buttonText: {
      today: 'Hoy',
      month: 'Mes',
      week: 'Semana',
      day: 'Día'
    },

    // ❌ YA NO usamos "events: function() {}" aquí

    dateClick: function(info) {
      $('#formCita')[0].reset();
      $('#cita-id').val('');
      $('#fecha').val(info.dateStr);
      $('#btnActualizar, #btnEliminar').hide();
      $('#modalCita').modal('show');
    },

    eventClick: function(info) {
      const evento = info.event;
      const props = evento.extendedProps || {};

      $('#cita-id').val(evento.id);
      $('#fecha').val(evento.startStr);
      $('input[name=nombre]').val(props.nombre || '');
      $('input[name=telefono]').val(props.telefono || '');
      $('textarea[name=observacion]').val(props.observacion || '');
      $('input[name=hora]').val(props.hora || '');
      $('#btnActualizar, #btnEliminar').show();
      $('#modalCita').modal('show');
    }
  });

  calendar.render();

  // =========================
  // 🔁 FUNCIÓN PARA CARGAR EVENTOS (CITAS + DÍAS LLENOS)
  // =========================
  function cargarEventos() {
    const antiCache = Date.now();

    $.when(
      $.get(RUTA_CITAS_GET,  { _: antiCache }),
      $.get(RUTA_DIAS_LLENO, { _: antiCache })
    ).done(function(citas, diasLlenos) {
      const eventosCombinados = (citas[0] || []).concat(diasLlenos[0] || []);

      // ❌ Borramos todo lo que tiene el calendario
      calendar.removeAllEvents();

      // ✅ Agregamos los nuevos eventos uno por uno
      eventosCombinados.forEach(ev => {
        calendar.addEvent(ev);
      });
    }).fail(function() {
      showAlert('Error al cargar los eventos del calendario.', 'danger');
    });
  }

  // 🔃 Cargar eventos al entrar
  cargarEventos();

  // 🔁 Auto-refresco del calendario cada 10 segundos
  setInterval(() => {
    if (!document.hidden) { // solo si la pestaña está visible
      cargarEventos();
    }
  }, 10000); // 10 segundos

  // =========================
  // Guardar / Actualizar cita
  // =========================
  $('#formCita').on('submit', function (e) {
    e.preventDefault();
    const id = $('#cita-id').val();
    const ruta = id ? RUTA_CITAS_ACTUALIZAR : RUTA_CITAS_STORE;

    $.ajax({
      url: ruta,
      method: 'POST',
      data: $(this).serialize(),
      success: function () {
        $('#modalCita').modal('hide');
        cargarEventos(); // 👈 refrescamos manualmente
        showAlert('Cita guardada correctamente.', 'success');
      },
      error: function (xhr) {
        try {
          const response = JSON.parse(xhr.responseText);
          if (response.error) {
            showAlert(response.error, 'danger');
          } else {
            showAlert('Ocurrió un error al guardar la cita.', 'danger');
          }
        } catch {
          showAlert('Error al guardar la cita.', 'danger');
        }
      }
    });
  });

  // =========================
  // Eliminar cita
  // =========================
  $('#btnEliminar').on('click', function () {
    const id = $('#cita-id').val();
    if (!id) return showAlert('ID de cita no definido.', 'danger');

    if (confirm("¿Estás seguro de eliminar esta cita?")) {
      $.ajax({
        url: `${RUTA_CITAS_ELIMINAR}/${id}`,
        type: "POST",
        data: { _token: $('input[name="_token"]').val() },
        success: function () {
          $('#modalCita').modal('hide');
          cargarEventos(); // 👈 refrescamos manualmente
          showAlert('Cita eliminada correctamente.', 'success');
        },
        error: function () {
          showAlert('Error al eliminar la cita.', 'danger');
        }
      });
    }
  });
});
