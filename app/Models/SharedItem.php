<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shared_with_id',
        'item_type',
        'item_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sharedWith()
    {
        return $this->belongsTo(User::class, 'shared_with_id');
    }

    public function item()
    {
        return $this->morphTo();
    }
}
