<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FooterGridThree
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FooterGridThree newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FooterGridThree newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FooterGridThree query()
 * @method static \Illuminate\Database\Eloquent\Builder|FooterGridThree whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterGridThree whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterGridThree whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterGridThree whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterGridThree whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterGridThree whereUrl($value)
 * @mixin \Eloquent
 */
class FooterGridThree extends Model
{
    use HasFactory;
}
