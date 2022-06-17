<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
	protected $table = 'addresses';
	public $timestamps = false;

	protected $fillable = [
		'kode',
		'name'
	];
    

	// public static function getProvince($code){
	// 	$code = substr($code, 0, 2);
	// 	$province = Address::where('kode', $code)->pluck('nama')[0];

	// 	return $province;
	// }
	// public static function getDistrict($code)
	// {
	// 	$code = substr($code, 0, 5);
	// 	$district = Address::where('kode', $code)->pluck('nama')[0];
	// 	return $district;
	// }
	// public static function getSubDistrict($code)
	// {
	// 	$code = substr($code, 0, 8);
	// 	$sub_district = Address::where('kode', $code)->pluck('nama')[0];
	// 	return $sub_district;
	// }

	// public static function getFullAddress($location_code)
	// {
	// 	$province_code = substr($location_code, 0, 2);
	// 	$district_code = substr($location_code, 0, 5);
	// 	$sub_district_code = substr($location_code, 0, 8);
	// 	$village_code = $location_code;

	// 	$province = Address::where('kode', $province_code)->pluck('nama')[0];
	// 	$district = Address::where('kode', $district_code)->pluck('nama')[0];
	// 	$sub_district = Address::where('kode', $sub_district_code)->pluck('nama')[0];
	// 	$village = Address::where('kode', $village_code)->pluck('nama')[0];

	// 	return $village.', '.$sub_district.', '.$district.', '.$province;
	// }



}
