<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GcashSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'name',
        'number'
    ];
}
