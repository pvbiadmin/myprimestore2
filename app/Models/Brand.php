<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Brand
 *
 * @property int $id
 * @property string $logo
 * @property string $name
 * @property string $slug
 * @property int $is_featured
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Brand newModelQuery()
 * @method static Builder|Brand newQuery()
 * @method static Builder|Brand query()
 * @method static Builder|Brand whereCreatedAt($value)
 * @method static Builder|Brand whereId($value)
 * @method static Builder|Brand whereIsFeatured($value)
 * @method static Builder|Brand whereLogo($value)
 * @method static Builder|Brand whereName($value)
 * @method static Builder|Brand whereSlug($value)
 * @method static Builder|Brand whereStatus($value)
 * @method static Builder|Brand whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Brand extends Model
{
    use HasFactory;
}
