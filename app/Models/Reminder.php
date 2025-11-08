<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'remind_at', 'notified',
    ];

    protected $casts = [
        'remind_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reactivar(Reminder $reminder)
{
    if ($reminder->user_id !== Auth::id()) {
        abort(403);
    }

    $reminder->update(['notified' => false]);

    return response()->json([
        'success' => true,
        'message' => 'Recordatorio reactivado correctamente.'
    ]);
}

}
