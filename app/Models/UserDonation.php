<?php

namespace App\Models;

use Carbon\Carbon;
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

	public function transactions()
	{
		return $this->hasMany(Transaction::class);
	}

	public function donaturName(){
		$input = array("Orang Baik","Hamba Allah");
		if($this->isAnonim != 1){
		return $this->user->name;
		}
		$random=array_rand($input);
		$name=$input[$random];
		return "Orang Baik";
	}
	public function waktuDonasi(){
		$time = Carbon::parse(Carbon::now())->diffForHumans($this->created_at,true) . ' yang lalu';
		return $time;
	}
}
