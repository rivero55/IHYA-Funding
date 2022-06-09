<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProyekOwner extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table='proyek_owner';
    protected $fillable = [
        'name',
        'description'
    ];
    protected $hidden= [];
}
