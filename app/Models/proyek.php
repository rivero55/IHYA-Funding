<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class proyek extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table='proyek';
    protected $fillable = [
        'name',
        'type',
        'location_code',
        'image',
        'description'
    ];
    protected $hidden= [];
}

