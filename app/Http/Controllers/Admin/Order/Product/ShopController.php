<?php

namespace App\Http\Controllers\Admin\Order\Product;

use App\Http\Controllers\Controller;
use App\Models\OrderProductShop;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function viewAll(){
        $shops = OrderProductShop::orderBy('order', 'ASC')->select('id', 'name')->get();
        return view('admin.orders.products.shops.table', ['shops' => $shops]);
    }

    public function addShop(){
        return view('admin.orders.products.shops.add');
    }

    public function addShopPost(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
        ]);

        if ($validator->fails()) {
            session()->put(['data' => ['name' => $request->name, 'hex' => $request->hex]]);
            return redirect()->back()->withErrors($validator);
        }

        $shop = OrderProductShop::create([
            'name' => $request->name,
            'order' => OrderProductShop::orderBy('order', 'DESC')->first()->order + 1
        ]);

        if (!$shop){
            return redirect()->back()->with('shop_create_fail', 'Не удалось создать магазин');
        }

        return to_route('admin.shop.all')->with('shop_create_success', 'Магазин успешно создан');
    }

    public function editShop($id){
        $shop = OrderProductShop::find($id);
        return view('admin.orders.products.shops.edit', ['shop' => $shop]);
    }

    public function editShopPost($id, Request $request){
        $shop = OrderProductShop::find($id);

        if (!$shop){
            return redirect()->back()->with('shop_not_find', 'Магазин не удалось найти, повторите попытку еще раз');
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required']
        ]);

        if ($validator->fails()){
            session()->put(['data' => ['name' => $request->name, 'hex' => $request->hex]]);
            return redirect()->back()->withErrors($validator);
        }

        $shop->name = $request->name;

        return to_route('admin.shop.all')->with('shop_edit_success', 'Магазин успешно отредактирован');
    }

    public function deleteShop($id){
        $shop = OrderProductShop::find($id);

        if (!$shop){
            return redirect()->back()->with('shop_not_find', 'Данный магазин не найден');
        }

        if ($shop->delete()){
            return redirect()->back()->with('shop_delete_success', 'Магазин успешно удален');
        }

        return redirect()->back()->with('shop_delete_failed', 'Не удалось удалить магазин');
    }

    public function updateOrder(Request $request){
        $shops = OrderProductShop::all();

        foreach ($shops as $shop) {
            $shop->timestamps = false; // To disable update_at field updation
            $id = $shop->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $shop->update(['order' => $order['position']]);
                }
            }
        }

        return response('Update Successfully.', 200);
    }
}
