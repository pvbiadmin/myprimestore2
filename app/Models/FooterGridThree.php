<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
 * @method static Builder|FooterGridThree newModelQuery()
 * @method static Builder|FooterGridThree newQuery()
 * @method static Builder|FooterGridThree query()
 * @method static Builder|FooterGridThree whereCreatedAt($value)
 * @method static Builder|FooterGridThree whereId($value)
 * @method static Builder|FooterGridThree whereName($value)
 * @method static Builder|FooterGridThree whereStatus($value)
 * @method static Builder|FooterGridThree whereUpdatedAt($value)
 * @method static Builder|FooterGridThree whereUrl($value)
 * @mixin \Eloquent
 */
class FooterGridThree extends Model
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
