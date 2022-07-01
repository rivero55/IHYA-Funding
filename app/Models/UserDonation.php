<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDonation extends Model
{
    use HasFactory;
    
    protected $table = 'user_donations';

	protected $casts = [
		'user_id' => 'int',
		'proyek_id' => 'int',
		'proyek_batch_id' => 'int',
		'nominal' => 'float',
	];

	protected $fillable = [
		'user_id',
		'proyek_id',
		'proyek_batch_id',
		'nominal',
		'isAnonim',
		'message'
	];

	public function proyek_batch()
	{
		return $this->belongsTo(ProyekBatch::class)->withTrashed();
	}

	public function proyek()
	{
		return $this->belongsTo(proyek::class)->withTrashed();
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

}
