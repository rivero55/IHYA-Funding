<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    protected $table = 'user_profiles';

	protected $casts = [
		'user_id' => 'int'
	];
	protected $fillable = [
		'user_id',
		'ktp_name',
		'ktp_number',
		'ktp_image',
		'job',
		'job_detail',
        'social_media',
        'social_link'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
