<?php

namespace App\Models;

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
 * @method static \Illuminate\Database\Eloquent\Builder|FooterSocial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FooterSocial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FooterSocial query()
 * @method static \Illuminate\Database\Eloquent\Builder|FooterSocial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterSocial whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterSocial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterSocial whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterSocial whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterSocial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterSocial whereUrl($value)
 * @mixin \Eloquent
 */
class FooterSocial extends Model
{
    use HasFactory;
}
