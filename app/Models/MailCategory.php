<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function incomingMails()
    {
        return $this->hasMany(IncomingMail::class, 'category_id');
    }

    public function outgoingMails()
    {
        return $this->hasMany(OutgoingMail::class, 'category_id');
    }
}
