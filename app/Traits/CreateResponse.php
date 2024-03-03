<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait CreateResponse
{
    protected $jsonResponses = [
        100 => "Continue",
        200 => "",
        201 => "",
        202 => "",
        203 => "",
        403 => "",
        404 => "",
    ];

    public function __construct()
    {
        // The constructor is not the best place to set translations based on locale.
        // Instead, do this in the create_response method where the locale is more reliably set.
    }

    function create_response(bool $success, string $message = '', $data = "", $status = 200)
    {
        // Retrieve the current locale from the application.
        $locale = app()->getLocale();

        // Use the locale to set translations dynamically.
        $this->setTranslations($locale);

        $statusMessage = $this->jsonResponses[$status] ?? 'Something went wrong, please reload the page and try again';

        return response()->json(
            [
                'success' => $success,
                'message' => $message,
                'data' => $data,
                'status' => $status,
                'status_message' => $statusMessage,
            ],
            $status
        );
    }

//     public function create_response(bool $success, string $message = '', $data = "")
// {
//     // Retrieve the current locale from the application.
//     $locale = app()->getLocale();

//     // Use the locale to set translations dynamically.
//     $this->setTranslations($locale);

//     // Capture the response object after calling response()->json.
//     $response = response()->json(
//         [
//             'success' => $success,
//             'message' => $message,
//             'data' => $data,
//             // No need to include 'status' here since it will be dynamically obtained later.
//         ]
//     );

//     // Get the HTTP status code from the response object.
//     $status = $response->getStatusCode();

//     $statusMessage = $this->jsonResponses[$status] ?? 'Something went wrong, please reload the page and try again';

//     return $response->setData([
//         'success' => $success,
//         'message' => $message,
//         'data' => $data,
//         'status' => $status,
//         'status_message' => $statusMessage,
//     ]);
// }
    private function setTranslations(string $locale)
    {
        // Assign the translated strings for specific status codes based on the locale.
        switch ($locale) {
            case 'en':
                $this->jsonResponses[200] = __('crud.Index');
                $this->jsonResponses[201] = __('crud.Created');
                $this->jsonResponses[202] = __('crud.Updated');
                $this->jsonResponses[203] = __('crud.Deleted');
                $this->jsonResponses[404] = __('crud.NotFound');
                $this->jsonResponses[403] = __('auth.Unauthorised');


                break;
            case 'ar':
                $this->jsonResponses[200] = __('crud.Index');
                $this->jsonResponses[201] = __('crud.Created');
                $this->jsonResponses[202] = __('crud.Updated');
                $this->jsonResponses[203] = __('crud.Deleted');
                $this->jsonResponses[403] = __('auth.Unauthorised');
                $this->jsonResponses[404] = __('crud.NotFound');

                break;
            // Add more cases as needed for other languages.
        }
    }
}
