<?php
namespace App\Services\Artist;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\API\BaseController as BaseController;
use Str;
use Auth;
use Validator;
class ArtistService extends BaseController
{
    protected $Repo;

    public function __construct(UserRepositoryInterface  $userRepo)
    {
        $this->userRepo = $Repo;
    }


}
