<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function ajaxSwitch(Request $request)
    {

        $lang = $request->input('lang');
        $allowedLocales = ['en', 'ko'];  

        if (in_array($lang, $allowedLocales)) {
             
            Session::put('locale', $lang);
            app()->setLocale($lang);

             
            Cookie::queue('locale', $lang, 60 * 24 * 30);

            return response()->json([
                'status' => 'success',
                'message' => 'Language changed to '.$lang,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid language',
        ], 400);
        // $lang = $request->input('lang');

        // if (in_array($lang, ['en', 'ko'])) {
        //     Session::put('locale', $lang);

        //     cookie()->queue('locale', $lang, 60*24*30);

        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'Language changed to ' . $lang
        //     ]);
        // }

        // return response()->json([
        //     'status' => 'error',
        //     'message' => 'Invalid language'
        // ], 400);
    }
}
