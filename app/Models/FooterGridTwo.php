<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
 * @method static Builder|FooterGridTwo newModelQuery()
 * @method static Builder|FooterGridTwo newQuery()
 * @method static Builder|FooterGridTwo query()
 * @method static Builder|FooterGridTwo whereCreatedAt($value)
 * @method static Builder|FooterGridTwo whereId($value)
 * @method static Builder|FooterGridTwo whereName($value)
 * @method static Builder|FooterGridTwo whereStatus($value)
 * @method static Builder|FooterGridTwo whereUpdatedAt($value)
 * @method static Builder|FooterGridTwo whereUrl($value)
 * @mixin \Eloquent
 */
class FooterGridTwo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'url',
        'status',
    ];
}
