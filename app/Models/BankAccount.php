<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bank_name',
        'account_number',
        'account_name',
        'balance',
        'is_shared',
    ];

    protected function casts(): array
    {
        return [
            'balance' => 'decimal:2',
            'is_shared' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sharedItems()
    {
        return $this->morphMany(SharedItem::class, 'item');
    }
}
