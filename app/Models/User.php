<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'google_id',
        'is_admin',
        'status',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    public function isBlocked(): bool
    {
        return $this->status === 'blocked';
    }

    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    public function isActive(): bool
    {
        return $this->status === 'active' || $this->status === null;
    }

    public function isViewer(): bool
    {
        return $this->role === 'viewer';
    }
}
