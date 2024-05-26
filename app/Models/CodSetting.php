<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\CodSetting
 *
 * @property int $id
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|CodSetting newModelQuery()
 * @method static Builder|CodSetting newQuery()
 * @method static Builder|CodSetting query()
 * @method static Builder|CodSetting whereCreatedAt($value)
 * @method static Builder|CodSetting whereId($value)
 * @method static Builder|CodSetting whereStatus($value)
 * @method static Builder|CodSetting whereUpdatedAt($value)
 * @mixin Eloquent
 */
class CodSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'status'
    ];
}
