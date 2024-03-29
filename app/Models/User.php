<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
         protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'balance',
        'profile_image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function donations()
	{
		return $this->hasMany(UserDonation::class);
	}

	public function profile()
	{
		return $this->hasOne(UserProfile::class);
	}
    public function transactions()
	{
		return $this->hasMany(Transaction::class);
	}
    public function proyek_owner(){
        return $this->hasOne(ProyekOwner::class);
    }
    
    public function minusBalance($nominal){
		$balance_now = $this->balance - $nominal;
		if($balance_now>=0){
			$update = $this->update([
				'balance' => $balance_now
			]);
			return $update;
		}

		return false;
	}
    public function getPhotoProfile()
	{
		return (empty($this->photo_profile) ? asset('img/default-profile.png'):asset('storage/images/profiles/'.$this->photo_profile));
	}
}
