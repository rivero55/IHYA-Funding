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
        'user_id',
        'description'
    ];
    protected $hidden= [];
    
    public function proyek()
	{
		return $this->hasMany(Proyek::class, 'owner_id');
	}
    public function user()
	{
		return $this->belongsTo(user::class);
	}
}
