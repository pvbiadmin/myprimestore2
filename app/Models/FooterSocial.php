<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FooterSocial
 *
 * @property int $id
 * @property string $icon
 * @property string $name
 * @property string $url
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|FooterSocial newModelQuery()
 * @method static Builder|FooterSocial newQuery()
 * @method static Builder|FooterSocial query()
 * @method static Builder|FooterSocial whereCreatedAt($value)
 * @method static Builder|FooterSocial whereIcon($value)
 * @method static Builder|FooterSocial whereId($value)
 * @method static Builder|FooterSocial whereName($value)
 * @method static Builder|FooterSocial whereStatus($value)
 * @method static Builder|FooterSocial whereUpdatedAt($value)
 * @method static Builder|FooterSocial whereUrl($value)
 * @mixin \Eloquent
 */
class FooterSocial extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'icon',
        'name',
        'url',
        'status',
    ];
}
