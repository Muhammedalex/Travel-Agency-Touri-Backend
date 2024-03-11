<?php

namespace App\Http\Controllers\Admin\Employees;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Employees\DriverStoreRequest;
use App\Http\Requests\Admin\Employees\DriverUpdateRequest;
use App\Http\Requests\Admin\Photo\PhotoDriverStoreRequest;
use App\Models\Driver;
use App\Models\PhotoDriver;
use App\Traits\AuthorizeCheck;
use App\Traits\CreateResponse;
use App\Traits\ImageProccessing;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    use AuthorizeCheck, CreateResponse, ImageProccessing;

    public function index()
    {
        $this->authorizeCheck('country view');

        try {
            $data = Driver::all();


            return $this->create_response(true,  'ok', $data, 200);
        } catch (\Exception $e) {
            return $this->create_response(false,  $e->getMessage());
        }
    }

    //Store 

    public function store(DriverStoreRequest $request, PhotoDriverStoreRequest $photoRequest)
    {

        try {
            $valid = $request->validated();
            $validPhoto = $photoRequest->validated();
            // uploade pic driver personal photoo 
            if ($request->hasFile('picture')) {

                $mime = $request->file('picture')->getMimeType();
                $ext = $this->getExtensionFromMime($mime);
                $valid['picture'] = $this->saveImage($request->picture, $ext);
            } else {
                return 'pic is required';
            }
            $data = Driver::create($valid);
            $data = $data->refresh();

            // uploade pic car driver photos array 

            if ($photoRequest->hasFile('car_photo')) {
                foreach ($photoRequest->file('car_photo') as $photo) {
                    $mime = $photo->getMimeType();
                    $ext = $this->getExtensionFromMime($mime);


                    $upload = ['photo' => $photo, 'ext' => $ext];

                    $pic = $this->saveImage($upload['photo'], $upload['ext']);
                    $dataPhoto[] = PhotoDriver::create([
                        'driver_id' => $data->id,
                        'car_photo' => $pic,
                    ]);
                }
            }


            $data->picture ? $data->picture = $data->picture_url : '';
            $data->with('photoDrivers');
            return $this->create_response(true,  'ok', [$data, $dataPhoto], 201);
        } catch (\Exception $e) {
            return $this->create_response(false,  $e->getMessage());
        }
    }

    //show driver with photos and transportation data

    public function show($lang, Driver $driver)
    {
        $this->authorizeCheck('country view');
        try {

            $data = Driver::with('photoDrivers', 'transportation')->where('id', $driver->id)->first();

            $data =  $data->refresh();
            foreach ($data->photoDrivers as $photo) {
                $photo->car_photo ? $photo->car_photo = $photo->car_photo_url : '';
            }


            return $this->create_response(true,  'ok', $data, 200);
        } catch (\Exception $e) {
            return $this->create_response(false,  $e->getMessage());
        }
    }

    //update 

    public function update($lang, DriverUpdateRequest $request, Driver $driver)
    {
        try {
            $valid = $request->validated();

            if ($request->hasFile('picture')) {
                $driver->picture ? $this->deleteImage($driver->picture) : '';
                $mime = $request->file('picture')->getMimeType();
                $ext = $this->getExtensionFromMime($mime);
                $valid['picture'] = $this->saveImage($request->picture, $ext);
            }
            $driver->update($valid);
            $data = $driver->refresh();
            $data->picture ? $data->picture = $data->picture_url : '';
            return $this->create_response(true,  'ok', $data, 201);
        } catch (\Exception $e) {
            return $this->create_response(false,  $e->getMessage());
        }
    }

    //delete 

    public function destroy($lang, Driver $driver)
    {
        $this->authorizeCheck('country delete');
        try {
            $data = Driver::with('photoDrivers')->findOrFail($driver->id);
            if ($data) {

                foreach ($data->photoDrivers as $photo) {
                    $photo->car_photo ? $this->deleteImage($photo->car_photo) : '';
                }
                $driver->picture ? $this->deleteImage($driver->picture) : '';
                $driver->delete();
                return $this->create_response(true,  'ok', $data, 203);
            }

            return $this->create_response(false,  'not ok', $data, 422);
        } catch (\Exception $e) {
            return $this->create_response(false,  $e->getMessage(), null, 500);
        }
    }

    private function getExtensionFromMime($mime)
    {
        $extensions = [
            'image/jpeg' => '.jpg',
            'image/png' => '.png',
            'image/gif' => '.gif',
            // Add more MIME type to extension mappings as needed
        ];

        // Default extension if not found
        $defaultExtension = '.jpg';

        return $extensions[$mime] ?? $defaultExtension;
    }
}
