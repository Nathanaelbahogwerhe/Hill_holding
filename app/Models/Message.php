<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'recipient_id',
        'subject',
        'body',
        'attachment',
        'is_read',
    ];

    // 🔁 Relations
    public function sender()
    {
        return $this->belongsTo(Employee::class, 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo(Employee::class, 'recipient_id');
    }

    // 🔍 Helper : savoir si le message a une pièce jointe
    public function hasAttachment(): bool
    {
        return !empty($this->attachment);
    }
}




