<?php

namespace App\Http\Controllers\Booking\Accommodation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\Accommodation\AccTypeStoreRequest;
use App\Http\Requests\Booking\Accommodation\AccTypeUpdateRequest;
use App\Models\AccommodationType;
use App\Traits\AuthorizeCheck;
use App\Traits\CreateResponse;
use Illuminate\Http\Request;

class AccTypeController extends Controller
{
    use AuthorizeCheck, CreateResponse;

    public function index()
    {
        try {
           $data = AccommodationType::with('accommodations')->get();
           foreach($data as $single){
            foreach($single->accommodations as $item){
                $item->refresh();
                $item->cover = $item->cover_url ?? '';
            }
           }

            return $this->create_response(true,  'ok', $data, 201);
        } catch (\Exception $e) {
            return $this->create_response(false,  $e->getMessage());
        }
    }

    public function store(AccTypeStoreRequest $request)
    {

        try {
            $valid = $request->validated();
            $data = AccommodationType::create($valid);

            return $this->create_response(true,  'ok', $data, 201);
        } catch (\Exception $e) {
            return $this->create_response(false,  $e->getMessage());
        }
    }

                                                                            

    public function update($lang, AccTypeUpdateRequest $request, AccommodationType $accomodation_type)
    {
        try {
            $valid = $request->validated();

            // Now, you can use $accomodation_type directly
            if ($accomodation_type->update($valid)) {
                return $this->create_response(true, 'ok', $accomodation_type, 200);
            } else {
                return $this->create_response(false, 'not ok', $accomodation_type, 422);
            }
        } catch (\Exception $e) {
            return $this->create_response(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy($lang, AccommodationType $accomodation_type)
    {
        $this->authorizeCheck('country delete');
        try {
            
                $accomodation_type->delete();
                return $this->create_response(true,  'ok', $accomodation_type, 203);

            // return $this->create_response(false,  'not ok', $data, 422);
        } catch (\Exception $e) {
            return $this->create_response(false,  $e->getMessage(), null, 500);
        }
    }
}
