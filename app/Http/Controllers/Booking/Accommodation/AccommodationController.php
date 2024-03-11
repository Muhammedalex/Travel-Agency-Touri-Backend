<?php

namespace App\Http\Controllers\Booking\Accommodation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\Accommodation\AccommodationStoreRequest;
use App\Models\Accommodation;
use App\Traits\AuthorizeCheck;
use App\Traits\CreateResponse;
use App\Traits\ImageProccessing;
use Illuminate\Http\Request;

class AccommodationController extends Controller
{

    use AuthorizeCheck, CreateResponse, ImageProccessing;
    
    public function index()
    {
        try {
            $data = Accommodation::getAllWithCoverUrls();
            return $this->create_response(true, 'ok', $data, 200);
        } catch (\Exception $e) {
            return $this->create_response(false, $e->getMessage());
        }
    }

    public function store(AccommodationStoreRequest $request)
    {
        try {
            $valid = $request->validated();
    
            if ($request->file('cover')->isValid()) {
                $mime = $request->file('cover')->getMimeType();
                $ext = $this->getExtensionFromMime($mime);
                $valid['cover'] = $this->saveImage($request->cover, $ext);
            } else {
                return response()->json(['error' => 'Invalid or missing file.'], 422);
            }
    
            $data = Accommodation::create($valid);
            $data = $data->refresh();
    
            $data->cover = $data->cover_url ?? '';
            
            // Uncomment and adjust based on your actual relationship
            // $data->load('accommodation_type');
    
            return $this->create_response(true, 'ok', $data, 201);
        } catch (\Exception $e) {
            return $this->create_response(false, $e->getMessage());
        }
    }



    //image ext

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
