<?php

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Data\CountryStoreRequest;
use App\Http\Requests\Admin\Data\CountryUpdateRequest;
use App\Models\Country;
use App\Traits\AuthorizeCheck;
use App\Traits\CreateResponse;

class CountryController extends Controller
{
    use AuthorizeCheck , CreateResponse;

    public function index()
    {
        $this->authorizeCheck('country view');
        
        try {
            $data = Country::all();
            

            return $this->create_response(true ,  'ok', $data,200   );

        } catch (\Exception $e) {
            return $this->create_response(false ,  $e->getMessage() );

        }
    }

    //Store 

    public function store(CountryStoreRequest $request)
    {
       
        try {
            $valid = $request->validated();
            $data = Country::create($valid);
    
            return $this->create_response(true ,  'ok', $data ,201  );

        } catch (\Exception $e) {
            return $this->create_response(false ,  $e->getMessage() );

        }
    }

    public function show($lang, Country $country)
    {
        $this->authorizeCheck('country view');
        try {
            
            $data =$country;
    
            return $this->create_response(true ,  'ok', $data ,200  );

        } catch (\Exception $e) {
            return $this->create_response(false ,  $e->getMessage() );

        }
    }

    public function update($lang, CountryUpdateRequest $request, Country $country)
    {
        try {
            $valid = $request->validated();
            $country->update($valid);
            $data =Country::findOrFail($country->id);
            
            return $this->create_response(true ,  'ok', $data ,202);

        } catch (\Exception $e) {
            return $this->create_response(false ,  $e->getMessage() ,null,500 );

        }
    }

    public function destroy($lang , Country $country)
    {
        $this->authorizeCheck('country delete');
        try {
            $data =Country::findOrFail($country->id);
            if($data){
                $country->delete();
                return $this->create_response(true ,  'ok', $data ,203);
            }
           
            return $this->create_response(false ,  'not ok', $data ,422);

        } catch (\Exception $e) {
            return $this->create_response(false ,  $e->getMessage() ,null,500  );

        }
    }
}
