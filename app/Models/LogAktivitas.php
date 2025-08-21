<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';
    protected $fillable = [
        'model', 'title', 'user_id', 'type', 'datetime'
    ];
    public $timestamps = false;

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
