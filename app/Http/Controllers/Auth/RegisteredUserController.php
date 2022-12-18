<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDocument;
use App\Models\UserIp;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'surname' => ['required', 'string', 'max:255', 'min:3'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8', Rules\Password::defaults()],
            'terms' => ['required']
        ]);

        if ($validator->fails()) {
            session()->put('data', ['name' => $request->name, 'surname' => $request->surname, 'email' => $request->email]);
            return redirect()->back()->withErrors($validator);
        }

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        UserIp::create([
            'user_id' => $user->id,
            'ip' => $request->ip()
        ]);

        event(new Registered($user));

        Auth::login($user);

        UserDocument::create([
            'user_id' => $user->id,
            'name' => 'Скан паспорта',
            'status_id' => 1,
        ]);

        UserDocument::create([
            'user_id' => $user->id,
            'name' => 'Скан договора',
            'status_id' => 1,
        ]);

        UserDocument::create([
            'user_id' => $user->id,
            'name' => 'Скан форма 1583',
            'status_id' => 1,
        ]);

        return redirect(RouteServiceProvider::HOME);
    }
}
