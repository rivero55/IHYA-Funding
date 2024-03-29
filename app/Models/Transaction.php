<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    // protected $table = 'transactions';

	protected $casts = [
		'user_id' => 'int',
		'user_donations_id' => 'int',
		'nominal' => 'float'
	];

	protected $fillable = [
		'user_id',
		'type',
		'transaction_type',
		'proyek_batch_id',
		'user_donations_id',
		'nominal',
		'payment_method',
		'status',
		'description',
		'payment_token',
		'payment_url',
		'external_id',
		'created_by',
		'updated_by'
	];
    public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function user_portofolio()
	{
		return $this->belongsTo(Userdonation::class);
	}

	public function proyek_batch()
	{
		return $this->belongsTo(ProyekBatch::class);
	}
	public function user_donation()
	{
		return $this->belongsTo(UserDonation::class);
	}
	public function waktuTarikDana(){
		$time = Carbon::parse(Carbon::now())->diffForHumans($this->created_at,true) . ' yang lalu';
		return $time;
	}
}
