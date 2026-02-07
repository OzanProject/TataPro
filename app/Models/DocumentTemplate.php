<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentTemplate extends Model
{
    protected $fillable = [
        'name',
        'description',
        'file_path',
        'variables',
        'type',
    ];

    protected $casts = [
        'variables' => 'array',
    ];
}
