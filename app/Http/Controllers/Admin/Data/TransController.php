<?php

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Data\TransStoreRequest;
use App\Http\Requests\Admin\Data\TransUpdateRequest;
use App\Models\Transportation;
use App\Models\Transprice;
use App\Traits\AuthorizeCheck;
use App\Traits\CreateResponse;

class TransController extends Controller
{
    use AuthorizeCheck, CreateResponse;

    public function show($lang,$countryId)
    {
        try {
            $transportationPrices = Transprice::with('transportation','country')->where('country_id',$countryId)->get();
            $data = collect($transportationPrices)->map(function ($item) {
                return [
                    'id' => $item['id'],
                    'price' => $item['price'],
                    'type' => $item['transportation']['type'],
                    'country' => $item['country']['country'],
                ];
            });
            
            // Convert the collection to an array
            $resultArray = $data->toArray();
    
            return $this->create_response(true ,  'ok', $resultArray ,200  );

        } catch (\Exception $e) {
            return $this->create_response(false ,  $e->getMessage() );

        }
    
    }
    
    
    public function store(TransStoreRequest $request)
    {
       
        try {
            $valid = $request->validated();
            $data = Transportation::create($valid);
    
            return $this->create_response(true ,  'ok', $data ,201  );

        } catch (\Exception $e) {
            return $this->create_response(false ,  $e->getMessage() );

        }
    }

   

    public function update($lang, TransUpdateRequest $request, Transportation $transportation)
    {
        try {
            $valid = $request->validated();
            $transportation->update($valid);
            $data =Transportation::findOrFail($transportation->id);
            
            return $this->create_response(true ,  'ok', $data ,202);

        } catch (\Exception $e) {
            return $this->create_response(false ,  $e->getMessage() ,null,500 );

        }
    }

    public function destroy($lang ,Transportation $transportation)
    {
        $this->authorizeCheck('country delete');
        try {
            $data =Transportation::findOrFail($transportation->id);
            if($data){
                $transportation->delete();
                return $this->create_response(true ,  'ok', $data ,203);
            }
           
            return $this->create_response(false ,  'not ok', $data ,422);

        } catch (\Exception $e) {
            return $this->create_response(false ,  $e->getMessage() ,null,500  );

        }
    }
}
