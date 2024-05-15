<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FooterTitle
 *
 * @property int $id
 * @property string|null $footer_grid_two_title
 * @property string|null $footer_grid_three_title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FooterTitle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FooterTitle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FooterTitle query()
 * @method static \Illuminate\Database\Eloquent\Builder|FooterTitle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterTitle whereFooterGridThreeTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterTitle whereFooterGridTwoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterTitle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterTitle whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FooterTitle extends Model
{
    use HasFactory;

    protected $fillable = [
        'footer_grid_two_title',
        'footer_grid_three_title'
    ];
}
