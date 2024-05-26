<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'referral', 'unilevel'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}