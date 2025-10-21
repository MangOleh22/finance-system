<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'email_verified_at',
        'password',
        'role',
        'reset_token',
        'reset_expiry',
        'last_login_at',
        'last_activity',
        'is_online',
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
            'reset_expiry' => 'datetime',
            'last_login_at' => 'datetime',
            'last_activity' => 'datetime',
            'is_online' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function isViewer(): bool
    {
        return $this->role === 'viewer';
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function debts()
    {
        return $this->hasMany(Debt::class);
    }

    public function bankAccounts()
    {
        return $this->hasMany(BankAccount::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function isOnline(): bool
    {
        if ($this->is_online) {
            return true;
        }

        if (!$this->last_activity) {
            return false;
        }

        return $this->last_activity->diffInMinutes(now()) <= 5;
    }
}
