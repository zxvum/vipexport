<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function AllUsers(){
        $users = User::all();
        return view('admin.users.table', ['users' => $users]);
    }

    public function EditUser($id){
        $user = User::find($id);
        $countries = Country::all();
        if (!$user) {
            return redirect()->back()->with('user_not_found', 'Данный пользователь не найден.');
        }
        return view('admin.users.edit.index', ['user' => $user, 'countries' => $countries]);
    }

    public function EditUserPost($id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'surname' => ['required'],
            'email' => ['required', 'email'],
            'country_name' => ['required'],
            'city' => ['required'],
            'phone_number' => ['required', 'integer']
        ]);

        if ($validator->fails()) {
            session()->put(['data' => ['name' => $request->name, 'surname' => $request->surname, 'email' => $request->email, 'city' => $request->city, 'phone_number' => $request->phone_number]]);
            return redirect()->back()->withErrors($validator);
        }

        $user = User::find($id);

        if (!$user){
            return redirect()->back()->with('user_not_found', 'Данный пользователь не найден.');
        }
        return '';
    }

    public function AddAddressUser($id){
        $user = User::find($id);
        $countries = Country::all();
        return view('admin.users.edit.add-address', ['user' => $user, 'addresses' => $user->addresses, 'countries' => $countries]);
    }
}
