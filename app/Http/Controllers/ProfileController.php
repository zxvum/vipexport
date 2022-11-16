<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\UserDocument;

class ProfileController extends Controller
{
    public function view()
    {
        return view('profile', ['countries' => Country::all()]);
    }

    public function updateProfileInformation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255', 'string'],
            'surname' => ['required', 'max:255', 'string'],
            'country_name' => ['required'],
            'phone_number' => ['required']
        ]);

        if ($validator->fails()) {
            session()->put(['data' => ['country_name' => $request->country_name, 'phone_number' => $request->phone_number]]);
            return redirect()->back()->withErrors($validator);
        }

        $country = Country::where('name', $request->country_name)->first();

        if (!$country) {
            session()->put(['data' => ['country_name' => $request->country_name, 'phone_number' => $request->phone_number]]);
            return redirect()->back()->with('country_not_find', 'Указанная вами страна не найдена в списке стран, проверьте корректность ввода!');
        }

        $validate_city = Validator::make($request->all(), [
            'city' => 'required'
        ]);
        if ($validate_city->fails()) {
            session()->put(['data' => ['country_name' => $request->country_name, 'city' => $request->city, 'phone_number' => $request->phone_number]]);
            return redirect()->back()->withErrors($validate_city);
        }


        User::find(Auth::user()->id)->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'country_id' => $country->id,
            'city' => $request->city,
            'phone_number' => $request->phone_number
        ]);

        return redirect()->back()->with('profile_update_success', 'Данные профиля успешно изменены');
    }

    public function resetPassword()
    {
        return null;
    }

    public function documentsAll()
    {
        $documents = UserDocument::where('user_id', auth()->user()->id)->get();
        return view('documents.table', ['documents' => $documents]);
    }
}
