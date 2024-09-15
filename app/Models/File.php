<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file_path',
        'file_date',
        'document_id',
        'data_id',
    ];

    protected $casts = [
        'file_path' => 'array',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
    public function data()
    {
        return $this->belongsTo(Data::class);
    }
}
