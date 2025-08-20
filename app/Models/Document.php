<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'data_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function data()
    {
        return $this->belongsTo(Data::class);
    }
    public function file()
    {
        return $this->hasMany(File::class);
    }
}
