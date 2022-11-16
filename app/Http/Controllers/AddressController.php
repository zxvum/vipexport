<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Country;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function create(){
        $countries = Country::all();
        return view('address.create', ['countries' => $countries]);
    }

    public function createPost(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'country_name' => ['required'],
            'region' => ['required'],
            'city' => ['required'],
            'street' => ['required'],
            'phone_number' => ['required', 'regex:/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/'],
        ]);

        $data = [
            'name' => $request->name,
            'surname' => $request->surname,
            'country_name' => $request->country_name,
            'region' => $request->region,
            'city' => $request->city,
            'street' => $request->street,
            'phone_number' => $request->phone_number,
            'email' => $request->email
        ];

        if ($validator->fails()){
            session()->put(['data' => $data]);
            return redirect()->back()->withErrors($validator);
        }

        $country = Country::where('name', $request->country_name)->first();
        if (!$country){
            session()->put(['data' => $data]);
            return redirect()->back()->with('country_cot_found', 'Указанная вами страна не найдена в списке, используйте только предлагаемые значения или обратитесь в тех. поддержку');
        }

        $validate_postal_code = Validator::make($request->all(), [
            'postal_code' => 'regex:'.'/'.$country->postal_code_regex.'/'
        ]);
        $data['postal_code'] = $request->postal_code;
        if ($validate_postal_code->fails()){
            session()->put(['data' => $data]);
            return redirect()->back()->withErrors($validate_postal_code);
        }

        $address = new Address();

        if ($request->email != '' || $request->email != null) {
            $validate_email = Validator::make($request->all(), [
                'email' => ['email']
            ]);

            if ($validate_email->fails()){
                session()->put(['data' => $data]);
                return redirect()->back()->withErrors($validate_email);
            }

            $address->email = $request->email;
        } else {
            $address->email = auth()->user()->email;
        }

        $address->user_id = auth()->user()->id;
        $address->name = $request->name;
        $address->surname = $request->surname;
        $address->country_id = $country->id;
        $address->postal_code = $request->postal_code;
        $address->region = $request->region;
        $address->city = $request->city;
        $address->street = $request->street;
        $address->phone_number = $request->phone_number;

        $address->save();

        return to_route('address.all')->with('address_create_success', 'Адрес успешно создан, вы можете перейти к созданию заказа/посылки!');
    }

    public function all(){
        $addresses = Address::where('user_id', auth()->user()->id)->get();
        return view('address.table', ['addresses' => $addresses]);
    }

    public function edit($id){
        $address = Address::find($id);
        if (!$address){
            return abort(404);
        }

        $countries = Country::all();

        return view('address.edit', ['address' => $address, 'countries' => $countries]);

    }

    public function editPost($id, Request $request){
        $address = Address::find($id);
        if (!$address){
            return abort(404);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'country_name' => ['required'],
            'region' => ['required'],
            'city' => ['required'],
            'street' => ['required'],
            'phone_number' => ['required', 'regex:/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/'],
            'email' => ['required', 'email']
        ]);

        $data = [
            'name' => $request->name,
            'surname' => $request->surname,
            'country_name' => $request->country_name,
            'region' => $request->region,
            'city' => $request->city,
            'street' => $request->street,
            'phone_number' => $request->phone_number,
            'email' => $request->email
        ];

        if ($validator->fails()){
            session()->put(['data' => $data]);
            return redirect()->back()->withErrors($validator);
        }

        $country = Country::where('name', $request->country_name)->first();
        if (!$country){
            session()->put(['data' => $data]);
            return redirect()->back()->with('country_cot_found', 'Указанная вами страна не найдена в списке, используйте только предлагаемые значения или обратитесь в тех. поддержку');
        }

        $validate_postal_code = Validator::make($request->all(), [
            'postal_code' => 'regex:'.'/'.$country->postal_code_regex.'/'
        ]);
        $data['postal_code'] = $request->postal_code;
        if ($validate_postal_code->fails()){
            session()->put(['data' => $data]);
            return redirect()->back()->withErrors($validate_postal_code);
        }

        $address->update($data);

        return to_route('address.all')->with('address_edit_success', 'Адрес успешно изменен!');
    }

    public function delete($id){
        $is_order_has_address = Package::where('address_id', $id)->get();
        if ($is_order_has_address->count() != 0){
            return redirect()->back()->with('address_delete_failed', 'Не удалось удалить адрес потому что он используется в посылке');
        }

        $address = Address::find($id);
        if (!$address){
            return abort(404);
        }

        $address->delete();

        return redirect()->back()->with('address_delete_success', 'Адрес успешно удален!');
    }
}
