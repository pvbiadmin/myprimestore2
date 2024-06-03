<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReferralSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'package',
        'bonus',
        'points',
        'status'
    ];

    /**
     * Relationship: This Model Belongs to ProductType
     *
     * @return BelongsTo
     */
    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class, 'package', 'id');
    }
}
