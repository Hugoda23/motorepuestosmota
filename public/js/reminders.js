document.addEventListener('DOMContentLoaded', function () {
  const calendarEl = document.getElementById('calendar');
  const modal = new bootstrap.Modal(document.getElementById('reminderModal'));
  const form = document.getElementById('reminderForm');

  const modalTitle = document.getElementById('modalTitle');
  const saveBtn = document.getElementById('saveBtn');        // Crear
  const updateBtn = document.getElementById('updateBtn');    // Editar (debes tenerlo en el modal)
  const deleteBtn = document.getElementById('deleteBtn');    // Eliminar
  const reactivarBtn = document.getElementById('reactivarBtn'); // Reactivar
  const csrf = document.querySelector('meta[name="csrf-token"]').content;

  let selectedEvent = null;

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
monthNames: [
  'Enero','Febrero','Marzo','Abril','Mayo','Junio',
  'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'
],
monthNamesShort: [
  'Ene','Feb','Mar','Abr','May','Jun',
  'Jul','Ago','Sep','Oct','Nov','Dic'
],
dayNames: [
  'Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'
],
dayNamesShort: [
  'Dom','Lun','Mar','Mié','Jue','Vie','Sáb'
],


  height: 'auto',
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
  events: '/admin/recordatorios/fetch',


    // Crear nuevo al hacer click en día
    dateClick: (info) => {
      selectedEvent = null;
      form.reset();

      modalTitle.innerHTML = '<i class="bi bi-plus-circle"></i> Nuevo Recordatorio';
      form.querySelector('[name="id"]').value = '';
      form.querySelector('[name="remind_at"]').value = info.dateStr + 'T12:00';
      form.querySelector('[name="notified"]').checked = false;

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
      form.querySelector('[name="id"]').value = selectedEvent.id; // FullCalendar setea id
      form.querySelector('[name="title"]').value = selectedEvent.title;
      form.querySelector('[name="description"]').value = r.description || '';
      form.querySelector('[name="remind_at"]').value = selectedEvent.startStr.slice(0, 16);
      form.querySelector('[name="notified"]').checked = !!r.notified;

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

  // ✅ Crear (submit del formulario cuando no hay id)
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(form).entries());
    const isEditing = !!data.id;

    // Si tienes botón separado de update, dejamos el submit solo para crear.
    if (isEditing) return;

    const res = await fetch('/admin/recordatorios/store', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
      body: JSON.stringify(data)
    });
    const json = await res.json();
    if (json.success) {
      modal.hide();
      calendar.refetchEvents();
      alert('✅ Recordatorio creado correctamente');
    }
  });

  // ✏️ Editar (guardar cambios)
  updateBtn?.addEventListener('click', async () => {
    const data = Object.fromEntries(new FormData(form).entries());
    if (!data.id) return;

    const res = await fetch(`/admin/recordatorios/${data.id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
      body: JSON.stringify({
        title: data.title,
        description: data.description,
        remind_at: data.remind_at
      })
    });
    const json = await res.json();
    if (json.success) {
      modal.hide();
      calendar.refetchEvents();
      alert('✏️ Recordatorio actualizado');
    }
  });

  // 🗑️ Eliminar
  deleteBtn.addEventListener('click', async () => {
    const id = form.querySelector('[name="id"]').value;
    if (!id) return;
    if (!confirm('¿Eliminar este recordatorio?')) return;

    await fetch(`/admin/recordatorios/${id}`, {
      method: 'DELETE',
      headers: { 'X-CSRF-TOKEN': csrf }
    });

    modal.hide();
    calendar.refetchEvents();
  });

  // 🔁 Reactivar (pone notified=false)
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
    }
  });
});
