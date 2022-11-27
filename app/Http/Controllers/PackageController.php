<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\Package;
use App\Models\PackageHasProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;

class PackageController extends Controller
{
    public function allPackages(){
        $packages = Package::all();
        return view('packages.table', ['packages' => $packages]);
    }

    public function createPackageView(){
        $user_package_count = Package::where('user_id', auth()->user()->id)->count();
        $user_addresses = Address::where('user_id', auth()->user()->id)->get();
        return view('packages.create', ['user_package_count' => $user_package_count, 'user_addresses' => $user_addresses]);
    }

    public function createPackagePost(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'address_id' => ['required', 'exists:addresses,id'],
        ]);

        if ($validator->fails()){
            session()->put(['data' => ['title' => $request->title, 'address_id' => $request->address_id, 'description' => $request->description]]);
            return redirect()->back()->withErrors($validator);
        }

        $package = Package::create([
            'title' => $request->title,
            'address_id' => $request->address_id,
            'description' => $request->description,
            'status_id' => 1,
            'user_id' => auth()->user()->id,
        ]);

        if (!$package){
            return redirect()->back()->with('package_create_failed', 'Не удалось создать посылку');
        }

        return to_route('package.view', ['id' => $package->id])->with('please_add_orders', 'Для продолжения добавьте товары в посылку');
    }

    public function viewPackage($id){
        $package = Package::find($id);
        $addresses = Address::where('user_id', auth()->user()->id)->get();
        if (!$package){
            return to_route('package.all')->with('package_not_find', 'Посылка не найдена');
        }

        $orders = auth()->user()->orders()->get();

        return view('packages.package', ['package' => $package, 'addresses' => $addresses, 'orders' => $orders]);
    }

    public function editPackagePost($id, Request $request){
        $package = Package::find($id);

        if (!$package){
            return to_route('package.edit')->with('package_not_find', 'Посылка не найдена');
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'address_id' => ['required', 'exists:addresses'],
            'description' => ['required']
        ]);

        if ($validator->fails()){
            session()->put(['data' => ['name' => $request->name, 'address_id' => $request->address_id, 'description' => $request->description]]);
            return redirect()->back()->withErrors($validator);
        }

        $package->title = $request->title;
        $package->address_id = $request->address_id;
        $package->description = $request->description;

        $package->save();

        return to_route('package.all')->with('package_update_success', 'Посылка успешно обновлена');
    }

    public function deletePackage($id){
        $package = Package::find($id);

        if (!$package){
            return redirect()->back()->with('package_not_find', 'Посылка не найдена');
        }

        $package->delete();

        return to_route('package.all')->with('package_delete_success');
    }

    public function addOrder($id, Request $request){
        foreach ($request->orders as $order){
            PackageHasProduct::create([
                'user_id' => auth()->user()->id,
                'package_id' => $id,
                'product_id' => $order
            ]);
        }

        return redirect()->back()->with('products_add_success', 'Товары успешно уложены в посылку.');
    }
}
