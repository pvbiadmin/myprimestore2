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
 * @property string $name
 * @property string $slug
 * @property int $is_package
 * @property int $degree
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ProductType newModelQuery()
 * @method static Builder|ProductType newQuery()
 * @method static Builder|ProductType query()
 * @method static Builder|ProductType whereCreatedAt($value)
 * @method static Builder|ProductType whereDegree($value)
 * @method static Builder|ProductType whereId($value)
 * @method static Builder|ProductType whereIsPackage($value)
 * @method static Builder|ProductType whereName($value)
 * @method static Builder|ProductType whereSlug($value)
 * @method static Builder|ProductType whereStatus($value)
 * @method static Builder|ProductType whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ProductType extends Model
{
    use HasFactory;
}
