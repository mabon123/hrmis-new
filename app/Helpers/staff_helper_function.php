<?php 

use App\Models\District;
use App\Models\Location;
use App\Models\Province;

// Get provinces of user
if (!function_exists('user_provinces')) {
	function user_provinces()
	{
		$userProCode = auth()->user()->work_place->pro_code;

		// Province
        $provinces = Province::when(!auth()->user()->hasRole('administrator'), function($query) use($userProCode) {
                                $query->where('pro_code', $userProCode);
                            })
                            ->pluck('name_kh', 'pro_code')
                            ->all();

        if (auth()->user()->hasRole('administrator')) {
            $provinces = ['' => __('common.choose').' ...'] + $provinces;
        }

        return $provinces;
	}
}

// Get user districts
if (!function_exists('user_districts')) {
	function user_districts()
	{
		$userWorkPlace = auth()->user()->work_place;

        $districts = District::when((auth()->user()->level_id == 5 || auth()->user()->level_id == 4), function($query) use($userWorkPlace) {
                                $query->where('dis_code', $userWorkPlace->dis_code);
                            })
                            ->when((auth()->user()->level_id == 3 || auth()->user()->level_id == 2), function($query) use($userWorkPlace) {
                                $query->where('pro_code', $userWorkPlace->pro_code);
                            })
                            ->when(auth()->user()->hasRole('administrator'), function($query) {
                                $query->where('pro_code', 0);
                            })
                            ->pluck('name_kh', 'dis_code')
                            ->all();

        if (auth()->user()->hasRole('administrator')) {
            $districts = ['' => __('common.choose').' ...'];
        }
        elseif (auth()->user()->level_id == 3) {
            $districts = ['' => __('common.choose').' ...'] + $districts;
        }

        return $districts;
	}
}

// Get locations of user
if (!function_exists('user_locations')) {
	function user_locations()
	{
		$userWorkPlace = auth()->user()->work_place;

        $locations = Location::when(auth()->user()->level_id == 5, function($query) use($userWorkPlace) {
                                $query->where('location_code', $userWorkPlace->location_code);
                            })
                            ->when(auth()->user()->level_id == 4, function($query) use($userWorkPlace) {
                                $query->where('dis_code', $userWorkPlace->dis_code);
                            })
                            ->when(auth()->user()->level_id == 3, function($query) use($userWorkPlace) {
                                $query->where('pro_code', $userWorkPlace->pro_code);
                            })
                            ->when(auth()->user()->level_id == 2, function($query) use($userWorkPlace) {
                                $query->where('pro_code', $userWorkPlace->pro_code);
                            })
                            ->get()
                            ->pluck('location_commune', 'location_code')
                            ->all();

        if (auth()->user()->level_id != 5) {
            $locations = ['' => __('common.choose').' ...'] + $locations;
        }

        return $locations;
	}
}
