<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingMail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'received_date' => 'date',
        'mail_date' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(MailCategory::class, 'category_id');
    }

    public function dispositions()
    {
        return $this->hasMany(Disposition::class, 'incoming_mail_id');
    }
}
