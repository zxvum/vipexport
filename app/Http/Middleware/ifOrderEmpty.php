<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;
use Illuminate\Http\Request;

class ifOrderEmpty
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $orders = Order::all();
        foreach ($orders as $order) {
            if ($order->products->count() > 0){
                continue;
            } else {
                return to_route('order.product.add-product', ['id' => $order->id]);
            }
        }
        return $next($request);
    }
}
