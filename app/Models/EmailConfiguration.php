<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EmailConfiguration
 *
 * @property int $id
 * @property string $email
 * @property string $host
 * @property string $username
 * @property string $password
 * @property string $port
 * @property string $encryption
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EmailConfiguration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailConfiguration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailConfiguration query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailConfiguration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailConfiguration whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailConfiguration whereEncryption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailConfiguration whereHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailConfiguration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailConfiguration wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailConfiguration wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailConfiguration whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailConfiguration whereUsername($value)
 * @mixin \Eloquent
 */
class EmailConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'host',
        'username',
        'password',
        'port',
        'encryption'
    ];
}
