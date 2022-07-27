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
    protected $casts = [
		'owner_id' => 'int'
	];

    protected $fillable = [
        'owner_id',
		'name',
		'type',
		'location_code',
		'image',
		'description'
    ];

    public function proyek_owner()
	{
		return $this->belongsTo(ProyekOwner::class, 'owner_id');
	}
	public function proyek_batch()
	{
		return $this->hasMany(ProyekBatch::class);
	}


}

