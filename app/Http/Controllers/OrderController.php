<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderProductShop;
use App\Models\OrderProductStatus;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function tableView(){
        $orders = Order::all();
        return view('orders.all-orders', ['orders' => $orders]);
    }

    public function createView(){
        $orders_count = Order::where('user_id', auth()->user()->id)->count();
        return view('orders.new-order', ['title' => 'Заказ №'.$orders_count+1]);
    }

    public function viewOrder($id){
        $order = Order::find($id);
        $products  = $order->products;
        return view('orders.order', ['order' => $order, 'products' => $products]);
    }

    public function viewOrderEdit($id){
        $order = Order::find($id);
        return view('orders.edit-order', ['order' => $order]);
    }

    public function orderEditPost(Request $request, $id){
        $order = Order::find($id);

        if (!$order){
            return redirect()->back()->with('order_not_found', 'Товар с данным id не найден');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string'
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $order->name = $request->name;
        $order->description = $request->description;

        $order->save();

        return redirect()->back()->with('order_updated', 'Заказ успешно обновлен!');
    }

    public function createOrder(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', Rule::unique('orders')->where('user_id', auth()->user()->id)],
        ]);

        if ($validator->fails()) {
            session()->put(['data' => ['name' => $request->name, 'description' => $request->description]]);
            return redirect()->back()->withErrors($validator);
        }

        $order = Order::create([
            'user_id' => auth()->user()->id,
            'status_id' => 1,
            'name' => $request->name,
            'description' => $request->description
        ]);

        return to_route('order.product.add-product', ['id' => $order->id])->with('order_created', 'Ваш заказ успешно создан, теперь добавьте в него товары.');
    }

    public function deleteOrder($order_id){
        $order = Order::find($order_id);
        if (!$order){
            return redirect()->back()->with('order_not_found', 'Заказ не найден');
        }
        $order->delete();
        return to_route('order.all')->with('order_delete', 'Заказ успешно удален');
    }

    public function addProductView($id){
        $shops = OrderProductShop::orderBy('order', 'ASC')->get();
        $order = Order::where('id', $id)->first();
        $products = OrderProduct::where('order_id', $id)->get();
        if (!$order){
            return abort(404);
        }
        return view('orders.products.new-product', ['shops' => $shops, 'order' => $order, 'products' => $products]);
    }

    public function addProductToOrder($order_id, Request $request){
        $order = Order::where('id', $order_id)->where('user_id', auth()->user()->id)->first();
        if (!$order){
            return redirect()->back()->with('order_not_found', 'Что-то пошло не так, заказ не найден в базе.');
        }

        $validator = Validator::make($request->all(), [
            'shop_id' => ['required', 'exists:order_product_shops,id'],
            'link' => ['required', 'url'],
            'title' => ['required'],
            'price' => ['required', 'integer', 'max_digits::10'],
            'quantity' => ['required', 'integer', 'max_digits:2']
        ]);

        if ($validator->fails()){
            session()->put(['data' => [
                'shop_id' => $request->shop_id,
                'link' => $request->link,
                'title' => $request->title,
                'price' => $request->price,
                'quantity' => $request->quantity
            ]]);
            return redirect()->back()->withErrors($validator);
        }

        OrderProduct::create([
            'order_id' => $order_id,
            'status_id' => OrderProductStatus::first()->id,
            'shop_id' => $request->shop_id,
            'title' => $request->title,
            'link' => $request->link,
            'price' => $request->price,
            'quantity' => $request->quantity
        ]);

        return redirect()->back()->with('product_created', 'Товар успешно добавлен в заказ.');
    }

    public function editProductView($order_id, $product_id) {
        $order = Order::find($order_id);
        $product = OrderProduct::find($product_id);
        $shops = OrderProductShop::orderBy('order', 'ASC')->get();
        return view('orders.products.edit', ['order' => $order, 'product' => $product, 'shops' => $shops]);
    }

    public function editProductPost($order_id, $product_id, Request $request) {
        $order = Order::find($order_id);
        $product = OrderProduct::find($product_id);
        if (!$order || !$product) {
            session()->put(['data' => ['shop_id' => $request->shop_id, 'link' => $request->link, 'title' => $request->title, 'price' => $request->price, 'quantity' => $request->quantity]]);
            return redirect()->back()->with('order_or_product_not_found');
        }
        $validator = Validator::make($request->all(), [
            'shop_id' => ['required', 'integer'],
            'link' => ['required', 'url'],
            'title' => ['required', 'string'],
            'price' => ['required', 'integer'],
            'quantity' => ['required', 'integer']
        ]);

        if ($validator->fails()) {
            session()->put(['data' => ['shop_id' => $request->shop_id, 'link' => $request->link, 'title' => $request->title, 'price' => $request->price, 'quantity' => $request->quantity]]);
            return redirect()->back()->withErrors($validator);
        }

        $product->shop_id = $request->shop_id;
        $product->link = $request->link;
        $product->title = $request->title;
        $product->price = $request->price;
        $product->quantity = $request->quantity;

        $product->save();

        return redirect()->back()->with('product_edit_success', 'Товар с ID: '.$product->id.' успешно изменен.');
    }

    public function viewProduct($order_id, $product_id){
        $order = Order::find($order_id);
        $product = OrderProduct::find($product_id);
        return view('orders.products.index', ['order' => $order, 'product' => $product]);
    }

    public function deleteProduct(Request $request, $order_id, $product_id){
        $product = \App\Models\OrderProduct::find($product_id);
        $order = Order::find($order_id);
        if (!$order || !$product) {
            return redirect()->back()->with('order_or_product_not_found');
        }
        $product->delete();
        return redirect()->back()->with('product_delete_success', 'Товар успешно удален');
    }
}
