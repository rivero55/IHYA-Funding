<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyekType extends Model
{
    use HasFactory;
    protected $table='proyek_type';
    protected $fillable = [
        'name',
        'image'
    ];
}
