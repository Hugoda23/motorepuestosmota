<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReminderController;

// ============================================
// 🔔 Suscripción de notificaciones push (WebPush)
// ============================================
Route::middleware('auth:sanctum')->post('/push/subscribe', function (Request $request) {
    $user = $request->user();
    $user->updatePushSubscription(
        $request->endpoint,
        $request->publicKey,
        $request->authToken
    );

    return response()->json(['success' => true]);
});

// ============================================
// 🕒 Recordatorios del usuario autenticado
// ============================================
Route::middleware('auth:sanctum')->group(function () {
    // Obtener todos los recordatorios pendientes del usuario
    Route::get('/reminders', [ReminderController::class, 'index'])
        ->name('api.reminders.index');

    // Marcar recordatorio como notificado
    Route::post('/reminders/{reminder}/notified', [ReminderController::class, 'markNotified'])
        ->name('api.reminders.markNotified');
});
