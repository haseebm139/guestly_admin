<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;
class LanguageController extends Controller
{
    public function ajaxSwitch(Request $request)
    {
        $lang = $request->input('lang');

        if (in_array($lang, ['en', 'ko'])) {
            Session::put('locale', $lang);

            cookie()->queue('locale', $lang, 60*24*30);

            return response()->json([
                'status' => 'success',
                'message' => 'Language changed to ' . $lang
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid language'
        ], 400);
    }
}
