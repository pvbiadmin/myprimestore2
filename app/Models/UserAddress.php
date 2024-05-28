<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\UserAddress
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $country
 * @property string $state
 * @property string $city
 * @property string $zip
 * @property string $address
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|UserAddress newModelQuery()
 * @method static Builder|UserAddress newQuery()
 * @method static Builder|UserAddress query()
 * @method static Builder|UserAddress whereAddress($value)
 * @method static Builder|UserAddress whereCity($value)
 * @method static Builder|UserAddress whereCountry($value)
 * @method static Builder|UserAddress whereCreatedAt($value)
 * @method static Builder|UserAddress whereEmail($value)
 * @method static Builder|UserAddress whereId($value)
 * @method static Builder|UserAddress whereName($value)
 * @method static Builder|UserAddress wherePhone($value)
 * @method static Builder|UserAddress whereState($value)
 * @method static Builder|UserAddress whereUpdatedAt($value)
 * @method static Builder|UserAddress whereUserId($value)
 * @method static Builder|UserAddress whereZip($value)
 * @mixin Eloquent
 */
class UserAddress extends Model
{
    use HasFactory;
}
