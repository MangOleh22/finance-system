<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'amount',
        'description',
        'debtor',
        'document_url',
        'status',
        'is_shared',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'amount' => 'decimal:2',
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
