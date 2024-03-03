<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;
use Illuminate\Http\Request;
use App\Traits\ImageProccessing;
class UpdateProfileController extends Controller
{
    use ImageProccessing;

    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();

        $validatedData = $request->validated();

        if ($request->hasFile('photo')) {
            // Delete the existing photo if it exists
            $user->photo ? $this->deleteImage($user->photo) : '';
            $mime = $request->file('photo')->getMimeType();

        // Get the file extension based on the MIME type
        $ext = $this->getExtensionFromMime($mime);

            // Save the new photo and update the validated data
            $validatedData['photo'] = $this->saveImage($request->photo , $ext);
        }

        // Update the user's profile with the validated data
        $user->update($validatedData);
        
        // Refresh the user instance to get the updated information
        $user = $user->refresh();

        $user->photo ? $user->photo = $user->photo_url: '';
        $user->save();
        // Build the response data
        $success['user'] = $user;
        $success['success'] = true;

        // Return a JSON response with the updated user data and success status
        return response($success, 201);
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

