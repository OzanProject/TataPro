<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposition extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'due_date' => 'date',
    ];

    public function incoming_mail()
    {
        return $this->belongsTo(IncomingMail::class, 'incoming_mail_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
