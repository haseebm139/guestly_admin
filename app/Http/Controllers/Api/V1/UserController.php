<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\User\UserService;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\API\User\UploadDocumentRequest;
use App\Http\Controllers\Api\BaseController as BaseController;
class UserController extends BaseController
{
    protected $userService;

     public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // GET /api/user/verification/options
    public function getVerificationOptions()
    {
        $options = ['id_card' => 'ID Card', 'passport' => 'Passport', 'tattoo_license' => 'Tattoo License'];
        return $this->sendResponse($options, 'Document options retrieved.');
    }


    // POST /api/user/verification/upload
    public function uploadVerificationDocument(UploadDocumentRequest $request)
    {

        return $this->userService->handleUpload($request);
    }


    public function confirmVerification(Request $request)
    {
        return $this->userService->confirm($request->user());
    }

    // GET /api/user/verification/status
    public function getVerificationStatus(Request $request)
    {

        return $this->userService->getStatus($request->user());
    }

    public function uploadChatImage(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $file = $request->file('image'); 

        $filename = 'chat-images-' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('chat_images/'.auth()->user()->id), $filename);

        $path = 'chat_images/'.auth()->user()->id.'/'.$filename;
         
        return $this->sendResponse(['url' => $path], 'Image uploaded successfully.');
         
    }
}
