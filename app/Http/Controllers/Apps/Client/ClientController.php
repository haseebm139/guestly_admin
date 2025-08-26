<?php

namespace App\Http\Controllers\Apps\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CustomForm;
class ClientController extends Controller
{
    public function index($artist_name,$share_token)
    {
        $clientForm = CustomForm::with('fields')->where('share_token', $share_token)->first();
        //  dd($clientForm->fields);
        return view('user.pages.client.custom_form',compact('clientForm'));
    }
}
