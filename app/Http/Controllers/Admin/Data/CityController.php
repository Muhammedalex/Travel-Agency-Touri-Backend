<?php

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Data\CityStoreRequest;
use App\Http\Requests\Admin\Data\CityUpdateRequest;
use App\Models\City;
use App\Models\Country;
use App\Traits\AuthorizeCheck;
use App\Traits\CreateResponse;

use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{
    use AuthorizeCheck, CreateResponse;

    public function index()
    {
        return response('nothing here yet');
    }

    //Store 

    public function store(CityStoreRequest $request)
    {

        try {
            $valid = $request->validated();
            $data = City::create($valid);

            return $this->create_response(true,  'ok', $data, 201);
        } catch (\Exception $e) {
            return $this->create_response(false,  $e->getMessage());
        }
    }

    public function show($lang, $countryId)
    {
        $user = Auth::guard('sanctum')->user();

        $this->authorizeCheck('country edit');

        try {

            if ($user->role == 'super admin') {
                $data = Country::with('cities')->find($countryId);
            } else   {
                $data = Country::with('cities')->find($user->country_id);
            }

            return $this->create_response(true,  'ok', $data, 200);
        } catch (\Exception $e) {
            return $this->create_response(false,  $e->getMessage());
        }
    }

    public function update($lang, CityUpdateRequest $request, City $city)
    {
        try {
            $valid = $request->validated();
            $city->update($valid);
            $data = City::findOrFail($city->id);

            return $this->create_response(true,  'ok', $data, 202);
        } catch (\Exception $e) {
            return $this->create_response(false,  $e->getMessage(), null, 500);
        }
    }

    public function destroy($lang, City $city)
    {
       $this->authorizeCheck('country delete');
        try {
            $data = City::findOrFail($city->id);
            if ($data) {
                $city->delete();
                return $this->create_response(true,  'ok', $data, 203);
            }

            return $this->create_response(false,  'not ok', $data, 422);
        } catch (\Exception $e) {
            return $this->create_response(false,  $e->getMessage(), null, 500);
        }
    }
}
