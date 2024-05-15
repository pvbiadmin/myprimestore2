<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CodSetting
 *
 * @property int $id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CodSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CodSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CodSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|CodSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CodSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CodSetting whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CodSetting whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CodSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'status'
    ];
}
