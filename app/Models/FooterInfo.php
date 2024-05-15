<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FooterInfo
 *
 * @property int $id
 * @property string|null $logo
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $address
 * @property string|null $copyright
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FooterInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FooterInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FooterInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|FooterInfo whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterInfo whereCopyright($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterInfo whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterInfo whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterInfo wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterInfo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FooterInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'phone',
        'email',
        'address',
        'copyright'
    ];
}
