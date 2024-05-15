<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TermsAndCondition
 *
 * @property int $id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TermsAndCondition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TermsAndCondition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TermsAndCondition query()
 * @method static \Illuminate\Database\Eloquent\Builder|TermsAndCondition whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermsAndCondition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermsAndCondition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermsAndCondition whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TermsAndCondition extends Model
{
    use HasFactory;

    protected $fillable = ['content'];
}
