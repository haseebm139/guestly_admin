<?php
namespace App\Services\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Repositories\API\UserRepositoryInterface;
use App\Http\Controllers\API\BaseController as BaseController;
use Str;
use Auth;
use Validator;
class UserService extends BaseController
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface  $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function handleUpload($request)
    {
        $paths = [];
        foreach (['front', 'back'] as $side) {
            if ($request->has($side)) {
                $paths[$side] = $this->uploadFile($request->file($side),$request->type,$side);

            }
        }

        $this->userRepo->updateVerificationImages($request->user(), array_filter($paths), $request->type);

        return $this->sendResponse([], 'Document uploaded.');
    }

    private function uploadFile($file,$type,$side)
    {

        $imageName = $side.'-'.$type.'-'.time().'.'.$file->extension();

        $file->move(public_path('documents/verification'), $imageName);
        return 'documents/verification/' . $imageName;
    }

    public function confirm($user)
    {
        $success = $this->userRepo->confirmVerification($user);
        return $this->sendResponse([], $success ? 'Verification submitted.' : 'Already confirmed.');
    }

    public function getStatus($user)
    {

        $status = $this->userRepo->getVerificationStatus($user);
        return $this->sendResponse(['status' => $status], 'Status fetched.');
    }
}
