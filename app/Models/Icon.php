<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Hubungan dengan Dropdown (One to Many)
    public function dropdowns()
    {
        return $this->hasMany(Dropdown::class);
    }
}
