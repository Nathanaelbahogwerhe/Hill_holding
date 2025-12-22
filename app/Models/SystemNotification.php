<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'type',
        'target',
        'role_name',
        'created_by',
        'is_active',
        'expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    // Relations
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where(function($q) {
                         $q->whereNull('expires_at')
                           ->orWhere('expires_at', '>', now());
                     });
    }

    public function scopeForUser($query, $user)
    {
        return $query->where(function($q) use ($user) {
            $q->where('target', 'all')
              ->orWhere(function($subQ) use ($user) {
                  $subQ->where('target', 'admins')
                       ->whereHas('creator', function($userQ) use ($user) {
                           // Check if user has admin role
                       });
              })
              ->orWhere(function($subQ) use ($user) {
                  $subQ->where('target', 'specific_role')
                       ->where('role_name', $user->roles->pluck('name')->first());
              });
        });
    }

    // Accessors
    public function getTypeColorAttribute()
    {
        return match($this->type) {
            'info' => 'blue',
            'success' => 'green',
            'warning' => 'yellow',
            'error' => 'red',
            default => 'gray',
        };
    }

    public function getIsExpiredAttribute()
    {
        return $this->expires_at && $this->expires_at < now();
    }
}
