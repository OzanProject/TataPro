<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'nis',
        'nisn',
        'name',
        'gender',
        'class',
        'email',
        'phone',
        'address',
        'status',
        // Buku Induk Fields
        'place_of_birth',
        'date_of_birth',
        'religion',
        'father_name',
        'mother_name',
        'father_job',
        'mother_job',
        'parent_phone',
        'parent_address',
        'previous_school',
        'accepted_grade',
        'accepted_date',
    ];
}
