<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\NewsletterSubscriber
 *
 * @property int $id
 * @property string $email
 * @property string $verified_token
 * @property string $is_verified
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterSubscriber newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterSubscriber newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterSubscriber query()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterSubscriber whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterSubscriber whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterSubscriber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterSubscriber whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterSubscriber whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewsletterSubscriber whereVerifiedToken($value)
 * @mixin \Eloquent
 */
class NewsletterSubscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'is_verified',
        'verified_token'
    ];
}
