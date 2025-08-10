<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jenis',
        'alamat',
        'nomor_telepon',
        'email',
        'nib',
        'deskripsi',
        'foto',
        'google_maps_link',
        'latitude',
        'longitude',
        'status',
        'user_id'
    ];

    protected $casts = [
        'status' => 'integer',
        'foto' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
