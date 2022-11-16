<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view(){
        return view('index');
    }

    public function checkCountry(Request $request){
        $country = Country::where('name', $request->name)->first();

        if ($country) {
           return response()->json(['status' => true, 'regex' => $country->postal_code_regex]);
        }

        return response()->json(['status' => false]);
    }
}
