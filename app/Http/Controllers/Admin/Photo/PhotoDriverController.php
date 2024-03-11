<?php

namespace App\Http\Controllers\Admin\Photo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Photo\PhotoDriverStoreRequest;
use App\Models\PhotoDriver;
use App\Traits\AuthorizeCheck;
use App\Traits\CreateResponse;
use App\Traits\ImageProccessing;

class PhotoDriverController extends Controller
{
    use ImageProccessing, CreateResponse, AuthorizeCheck;


    public function store(PhotoDriverStoreRequest $request)
    {
        try {
            $valid = $request->validated();
            if ($request->hasFile('car_photo')) {
                foreach ($request->file('car_photo') as $photo) {
                    $mime = $photo->getMimeType();
                    $ext = $this->getExtensionFromMime($mime);


                    $upload = ['photo' => $photo, 'ext' => $ext];

                    $pic = $this->saveImage($upload['photo'], $upload['ext']);
                    $data[] = PhotoDriver::create([
                        'driver_id' => $request->driver_id,
                        'car_photo' => $pic,
                    ]);
                }
                return $this->create_response(true,  'ok', $data, 201);
            }
        } catch (\Exception $e) {
            return $this->create_response(false, $e->getMessage());
        }
    }

    public function show($lang, PhotoDriver $photo_driver)
    {
        $data = $photo_driver;
        return $this->create_response(true,  'ok', $data, 203);
    }

    public function destroy($lang, PhotoDriver $photo_driver)
    {

        $this->authorizeCheck('country delete');
        try {
           
            $data = PhotoDriver::findOrFail($photo_driver->id);
            if ($data) {
                $data->car_photo ? $this->deleteImage($data->car_photo ) : '';
                $photo_driver->delete();
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
