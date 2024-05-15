<?php /** @noinspection ALL */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LogoSetting
 *
 * @property int $id
 * @property string $logo
 * @property string $favicon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LogoSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogoSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogoSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|LogoSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogoSetting whereFavicon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogoSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogoSetting whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogoSetting whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LogoSetting extends Model
{
    use HasFactory;

    protected $fillable = ['logo', 'favicon'];
}
