<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutgoingMail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'mail_date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(MailCategory::class, 'category_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
