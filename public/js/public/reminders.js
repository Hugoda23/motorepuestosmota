document.addEventListener('DOMContentLoaded', function () {
  const calendarEl = document.getElementById('calendar');
  const modal = new bootstrap.Modal(document.getElementById('reminderModal'));
  const form = document.getElementById('reminderForm');

  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'es',
    height: 'auto',
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    events: '/recordatorios/fetch',
    dateClick: (info) => {
      form.reset();
      form.querySelector('[name="remind_at"]').value = info.dateStr + 'T12:00';
      modal.show();
    },
    eventClick: (info) => {
      if (confirm('¿Eliminar este recordatorio?')) {
        fetch(`/recordatorios/${info.event.id}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          }
        }).then(() => {
          calendar.refetchEvents();
        });
      }
    }
  });

  calendar.render();

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(form).entries());
    const res = await fetch('/recordatorios/store', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify(data)
    });
    const json = await res.json();
    if (json.success) {
      modal.hide();
      calendar.refetchEvents();
      alert('Recordatorio creado correctamente');
    }
  });
});
