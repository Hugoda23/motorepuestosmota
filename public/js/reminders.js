document.addEventListener('DOMContentLoaded', function () {
  const calendarEl   = document.getElementById('calendar');
  const modalElement = document.getElementById('reminderModal');
  const modal        = new bootstrap.Modal(modalElement);
  const form         = document.getElementById('reminderForm');

  const modalTitle = document.getElementById('modalTitle');
  const saveBtn    = document.getElementById('saveBtn');        // Crear
  const updateBtn  = document.getElementById('updateBtn');      // Editar
  const deleteBtn  = document.getElementById('deleteBtn');      // Eliminar
  const reactivarBtn = document.getElementById('reactivarBtn'); // Reactivar
  const csrf = document.querySelector('meta[name="csrf-token"]').content;

  let selectedEvent   = null;
  let eventsCache     = [];
  const alreadyNotifiedClient = new Set(); // Para no notificarlo repetido en la misma sesión

  // 🔔 Pedir permiso para notificaciones del navegador
  if ('Notification' in window && Notification.permission === 'default') {
    Notification.requestPermission();
  }

  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'es',
    buttonText: {
      today: 'Hoy',
      month: 'Mes',
      week: 'Semana',
      day: 'Día'
    },
    weekText: 'Sm',
    allDayText: 'Todo el día',
    moreLinkText: 'más',
    noEventsText: 'No hay eventos para mostrar',
    dayPopoverFormat: { weekday: 'long', month: 'long', day: 'numeric' },
    weekTextLong: 'Semana',

    height: 'auto',
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },

    events: '/admin/recordatorios/fetch',

    // Cada vez que FullCalendar ponga los eventos en pantalla, los guardamos en cache
    eventsSet: function (events) {
      eventsCache = events;
    },

    // Crear nuevo al hacer click en un día
    dateClick: (info) => {
      selectedEvent = null;
      form.reset();

      modalTitle.innerHTML = '<i class="bi bi-plus-circle"></i> Nuevo Recordatorio';
      form.querySelector('[name="id"]').value = '';
      form.querySelector('[name="remind_at"]').value = info.dateStr + 'T12:00';
      const notifiedCheck = form.querySelector('[name="notified"]');
      if (notifiedCheck) notifiedCheck.checked = false;

      // Botones visibles/ocultos según contexto
      saveBtn.classList.remove('d-none');
      updateBtn?.classList.add('d-none');
      deleteBtn.classList.add('d-none');
      reactivarBtn.classList.add('d-none');

      modal.show();
    },

    // Ver/Editar al hacer click en evento
    eventClick: (info) => {
      const r = info.event.extendedProps; // description, notified, etc.
      selectedEvent = info.event;

      modalTitle.innerHTML = '<i class="bi bi-info-circle"></i> Detalle del Recordatorio';
      form.querySelector('[name="id"]').value = selectedEvent.id;
      form.querySelector('[name="title"]').value = selectedEvent.title;
      form.querySelector('[name="description"]').value = r.description || '';
      form.querySelector('[name="remind_at"]').value = selectedEvent.startStr.slice(0, 16);

      const notifiedCheck = form.querySelector('[name="notified"]');
      if (notifiedCheck) {
        notifiedCheck.checked = !!r.notified;
      }

      // Botones visibles/ocultos según contexto
      saveBtn.classList.add('d-none');
      updateBtn?.classList.remove('d-none');
      deleteBtn.classList.remove('d-none');

      if (r.notified) {
        reactivarBtn.classList.remove('d-none');
      } else {
        reactivarBtn.classList.add('d-none');
      }

      modal.show();
    }
  });

  calendar.render();

  // ✅ Crear (submit del formulario cuando no hay id -> nuevo)
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(form).entries());
    const isEditing = !!data.id; // si tiene id, es edición -> no lo manejamos aquí

    if (isEditing) return;

    const res = await fetch('/admin/recordatorios/store', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrf
      },
      body: JSON.stringify(data)
    });

    const json = await res.json();
    if (json.success) {
      modal.hide();
      calendar.refetchEvents();
      alert('✅ Recordatorio creado correctamente');
    } else {
      alert('⚠️ Error al crear recordatorio');
    }
  });

  // ✏️ Editar (guardar cambios)
  updateBtn?.addEventListener('click', async () => {
    const data = Object.fromEntries(new FormData(form).entries());
    if (!data.id) return;

    const res = await fetch(`/admin/recordatorios/${data.id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrf
      },
      body: JSON.stringify({
        title: data.title,
        description: data.description,
        remind_at: data.remind_at
        // Si quieres permitir editar "notified" aquí, también lo mandas
      })
    });

    const json = await res.json();
    if (json.success) {
      modal.hide();
      calendar.refetchEvents();
      alert('✏️ Recordatorio actualizado');
    } else {
      alert('⚠️ Error al actualizar recordatorio');
    }
  });

  // 🗑️ Eliminar
  deleteBtn.addEventListener('click', async () => {
    const id = form.querySelector('[name="id"]').value;
    if (!id) return;
    if (!confirm('¿Eliminar este recordatorio?')) return;

    const res = await fetch(`/admin/recordatorios/${id}`, {
      method: 'DELETE',
      headers: { 'X-CSRF-TOKEN': csrf }
    });

    if (res.ok) {
      modal.hide();
      calendar.refetchEvents();
    } else {
      alert('⚠️ Error al eliminar recordatorio');
    }
  });

  // 🔁 Reactivar (pone notified=false desde backend)
  reactivarBtn.addEventListener('click', async () => {
    const id = form.querySelector('[name="id"]').value;
    if (!id) return;

    const res = await fetch(`/admin/recordatorios/${id}/reactivar`, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': csrf }
    });

    const json = await res.json();
    if (json.success) {
      alert('🔁 Recordatorio reactivado');
      modal.hide();
      calendar.refetchEvents();
    } else {
      alert('⚠️ Error al reactivar recordatorio');
    }
  });

  // ==========================================================
  // 🔔 WATCHER DE NOTIFICACIONES: SOLO EN EL MOMENTO INDICADO
  // ==========================================================

  async function handleReminderNotification(event) {
    const props = event.extendedProps || {};
    const now   = new Date();

    const mensaje =
      `Recordatorio: ${event.title}\n\n` +
      (props.description ? props.description + '\n\n' : '') +
      `Hora programada: ${event.start.toLocaleString()}`;

    // Notificación del navegador (si se permite)
    if ('Notification' in window && Notification.permission === 'granted') {
      new Notification('Recordatorio', {
        body: mensaje
      });
    }

    // Mensajes en pantalla
    alert(mensaje);

    const quiereRepetir = confirm('¿Quieres que te vuelva a recordar este recordatorio?');

    if (!quiereRepetir) {
      // 👉 Lo marcamos como notificado en el backend
      try {
        await fetch(`/admin/recordatorios/${event.id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf
          },
          body: JSON.stringify({
            title: event.title,
            description: props.description || '',
            // dejamos la misma fecha original
            remind_at: event.start.toISOString().slice(0, 16),
            notified: true
          })
        });
      } catch (e) {
        console.error(e);
      }
      return;
    }

    // Si sí quiere que se repita, pedimos en cuántos minutos
    let minutos = prompt('¿En cuántos minutos quieres que se vuelva a recordar?', '5');
    if (minutos === null) {
      // Canceló el prompt
      return;
    }

    minutos = parseInt(minutos, 10);
    if (isNaN(minutos) || minutos <= 0) {
      alert('Minutos inválidos, no se reprogramó el recordatorio.');
      return;
    }

    // Nueva fecha de recordatorio: ahora + minutos
    const nuevaFecha = new Date(now.getTime() + minutos * 60 * 1000);

    try {
      await fetch(`/admin/recordatorios/${event.id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrf
        },
        body: JSON.stringify({
          title: event.title,
          description: props.description || '',
          // Formato compatible con input[type=datetime-local]
          remind_at: nuevaFecha.toISOString().slice(0, 16),
          notified: false
        })
      });

      alert(`Te volveré a recordar en ${minutos} minuto(s).`);
      calendar.refetchEvents();
    } catch (e) {
      console.error(e);
      alert('⚠️ Ocurrió un error al reprogramar el recordatorio.');
    }
  }

  function startReminderWatcher() {
    // Revisar cada 30 segundos
    setInterval(() => {
      if (!eventsCache || eventsCache.length === 0) return;

      const now = new Date();

      eventsCache.forEach(event => {
        const props = event.extendedProps || {};
        const remindDate = event.start;

        if (!remindDate) return;

        // Si ya fue notificado en esta sesión, no repetir
        if (alreadyNotifiedClient.has(event.id)) return;

        // Si el backend ya lo marca como notificado, tampoco
        if (props.notified) return;

        // Diferencia entre ahora y la fecha del recordatorio
        const diffMs = now - remindDate; // positivo si ya pasó

        // Ventana de activación: 0 a 60 segundos después de la hora
        if (diffMs >= 0 && diffMs <= 60000) {
          alreadyNotifiedClient.add(event.id);
          handleReminderNotification(event);
        }
      });
    }, 30000);
  }

  startReminderWatcher();
});
