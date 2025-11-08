// ============================================================
// 1️⃣ Registrar Service Worker
// ============================================================
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/service-worker.js')
    .then(reg => console.log('✅ Service Worker registrado en:', reg.scope))
    .catch(err => console.error('❌ Error registrando Service Worker:', err));
}

// ============================================================
// 2️⃣ Pedir permiso de notificaciones
// ============================================================
if (Notification.permission !== 'granted') {
  Notification.requestPermission();
}

// ============================================================
// 3️⃣ Revisar recordatorios cada minuto
// ============================================================
async function checkReminders() {
  try {
    const response = await fetch('/admin/recordatorios/fetch');
    if (!response.ok) throw new Error(`HTTP ${response.status}`);

    const reminders = await response.json();
    const now = new Date();

    for (const r of reminders) {
      const remindTime = new Date(r.start);

      // 👇 Evita notificar recordatorios ya marcados como notificados
      if (r.notified) continue;

      // 👇 Notifica solo si ya llegó la hora
      if (remindTime <= now) {
        // 🔔 Mostrar notificación
        new Notification(r.title, { body: r.description || 'Recordatorio activo' });

        // ✅ Marcar como notificado en la base de datos
        await fetch(`/admin/recordatorios/${r.id}/notified`, {
          method: 'POST',
          headers: { 'X-CSRF-TOKEN': window.Laravel?.csrfToken }
        });
      }
    }
  } catch (error) {
    console.error('Error comprobando recordatorios:', error);
  }
}

// 🕒 Comprobación cada minuto (60,000 ms)
setInterval(checkReminders, 60 * 1000);

// ============================================================
// 4️⃣ WebPush con VAPID
// ============================================================
if ('serviceWorker' in navigator) {
  window.addEventListener('load', async () => {
    const registration = await navigator.serviceWorker.ready;
    const permission = await Notification.requestPermission();
    if (permission !== 'granted') return;

    const vapidKey = window.Laravel?.vapidKey;
    const csrfToken = window.Laravel?.csrfToken;

    if (!vapidKey) {
      console.warn('⚠️ Clave VAPID pública no configurada.');
      return;
    }

    const applicationServerKey = urlBase64ToUint8Array(vapidKey);

    const subscription = await registration.pushManager.subscribe({
      userVisibleOnly: true,
      applicationServerKey,
    });

    await fetch('/api/push/subscribe', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
      },
      body: JSON.stringify(subscription),
    });

    console.log('📬 Suscripción enviada correctamente.');
  });
}

// ============================================================
// 5️⃣ Función auxiliar
// ============================================================
function urlBase64ToUint8Array(base64String) {
  const padding = '='.repeat((4 - base64String.length % 4) % 4);
  const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
  const rawData = atob(base64);
  const outputArray = new Uint8Array(rawData.length);
  for (let i = 0; i < rawData.length; ++i) {
    outputArray[i] = rawData.charCodeAt(i);
  }
  return outputArray;
}
