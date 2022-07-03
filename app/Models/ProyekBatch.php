<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
Carbon::setLocale('id');
class ProyekBatch extends Model
{
    use HasFactory;
    protected $table= "proyek_batch";
	protected $casts = [
		'proyek_id' => 'int',
		'batch_no' => 'int',
		'minimum_fund' => 'float',
		'maximum_fund' => 'float',
		'target_nominal' => 'float',
	];

	protected $dates = [
		'start_date',
		'end_date'
	];
    protected $fillable = [
		'proyek_id',
		'batch_no',
		'minimum_fund',
		'maximum_fund',
		'target_nominal',
		'start_date',
		'end_date',
		'status',
	];

    public function proyek(){
        return $this->belongsTo(proyek::class)->withTrashed();
    }
	public function daysLeft(){
		$daysLeft = Carbon::parse(Carbon::today())->diffInDays($this->end_date,false);
		return $daysLeft >= 0 ? $daysLeft: "close";
	}

	public function user_donations()
	{
		return $this->hasMany(UserDonation::class);
	}

	public function totalDonations()
	{
		return $this->user_donations()->sum('nominal');
	}
	public function countDonations()
	{
		return $this->user_donations()->count();
	}


	public function totalPercentage()
	{
		return round(($this->totalDonations()/$this->target_nominal*100));
	}
	public function fullName(){
		$batch= $this->batch_no;
		if($batch > 1){
		return $this-> proyek->name.' - Batch '.$this->batch_no;
		}
		return $this-> proyek->name;
	}
	public function isFullyFunded()
	{
		$isFullyFunded = ($this->end_date->endofday()->isPast()) || ($this->status != 'funding');
		return $isFullyFunded;
	}
}
