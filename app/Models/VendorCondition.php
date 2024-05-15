<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\VendorCondition
 *
 * @property int $id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|VendorCondition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VendorCondition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VendorCondition query()
 * @method static \Illuminate\Database\Eloquent\Builder|VendorCondition whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendorCondition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendorCondition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VendorCondition whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class VendorCondition extends Model
{
    use HasFactory;

    protected $fillable = ['content'];
}
