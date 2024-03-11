<?php

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Data\TransPriceStoreRequest;
use App\Http\Requests\Admin\Data\TransPriceUpdateRequest;
use App\Models\Transprice;
use App\Traits\AuthorizeCheck;
use App\Traits\CreateResponse;
use Illuminate\Http\Request;

class TransPriceController extends Controller
{
    use AuthorizeCheck, CreateResponse;
    public function store(TransPriceStoreRequest $request)
{
   
    try {
        $valid = $request->validated();
        $data = Transprice::create($valid);

        return $this->create_response(true ,  'ok', $data ,201  );

    } catch (\Exception $e) {
        return $this->create_response(false ,  $e->getMessage() );

    }
}

public function show($lang, Transprice $transprice)
{
    $this->authorizeCheck('country view');
    try {
        
        $data =$transprice;

        return $this->create_response(true ,  'ok', $data ,200  );

    } catch (\Exception $e) {
        return $this->create_response(false ,  $e->getMessage() );

    }
}

public function update($lang, TransPriceUpdateRequest $request, Transprice $transprice)
{
    try {
        $valid = $request->validated();
        $transprice->update($valid);
        $data =Transprice::findOrFail($transprice->id);
        
        return $this->create_response(true ,  'ok', $data ,202);

    } catch (\Exception $e) {
        return $this->create_response(false ,  $e->getMessage() ,null,500 );

    }
}

public function destroy($lang ,Transprice $transprice)
{
    $this->authorizeCheck('trans delete');
    try {
        $data =Transprice::findOrFail($transprice->id);
        if($data){
            $transprice->delete();
            return $this->create_response(true ,  'ok', $data ,203);
        }
       
        return $this->create_response(false ,  'not ok', $data ,422);

    } catch (\Exception $e) {
        return $this->create_response(false ,  $e->getMessage() ,null,500  );

    }
}
}
