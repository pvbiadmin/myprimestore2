<?php

namespace App\Models;

use Database\Factories\ChatFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Chat
 *
 * @property int $id
 * @property int $sender_id
 * @property int $receiver_id
 * @property string $message
 * @property int $seen
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $receiverProfile
 * @property-read \App\Models\User|null $senderProfile
 * @method static ChatFactory factory($count = null, $state = [])
 * @method static Builder|Chat newModelQuery()
 * @method static Builder|Chat newQuery()
 * @method static Builder|Chat query()
 * @method static Builder|Chat whereCreatedAt($value)
 * @method static Builder|Chat whereId($value)
 * @method static Builder|Chat whereMessage($value)
 * @method static Builder|Chat whereReceiverId($value)
 * @method static Builder|Chat whereSeen($value)
 * @method static Builder|Chat whereSenderId($value)
 * @method static Builder|Chat whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['seen'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiverProfile(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id')
            ->select(['id', 'image', 'name', 'last_seen'])->with('vendor');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function senderProfile(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id', 'id')
            ->select(['id', 'image', 'name', 'last_seen'])->with('vendor');
    }
}
