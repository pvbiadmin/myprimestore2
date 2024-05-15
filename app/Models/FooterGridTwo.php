<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FooterGridTwo
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FooterGridTwo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FooterGridTwo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FooterGridTwo query()
 * @method static \Illuminate\Database\Eloquent\Builder|FooterGridTwo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterGridTwo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterGridTwo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterGridTwo whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterGridTwo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterGridTwo whereUrl($value)
 * @mixin \Eloquent
 */
class FooterGridTwo extends Model
{
    use HasFactory;
}
