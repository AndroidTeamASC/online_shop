<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Order;
use App\Order_Detail;
use Carbon\Carbon;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $items = Item::all();
        return view('frontend.index', compact('items'));
    }
    public function shop()
    {
        return view('frontend.shop');
    }

    public function productDetail($id)
    {
        $item = Item::find($id);
        return view('frontend.product_detail', compact('item'));
    }
    public function cart($value='')
    {
        return view('frontend.cart');
    }

    public function order(Request $request)
    {
        $mycard = request('itemArray');
        $total = request('total');
       
        $address=request('address');

        $voucherno = uniqid();
       
        $order_date = Carbon::now();
        $order = Order::create([
                'user_id' => Auth::id(),
                'voucher_no' => $voucherno,
                'order_date' =>  $order_date,
                'total' =>$total,
            ]);

 

        foreach($mycard as $cart) {
           
            $orderdetail = Order_Detail::create([
                
               'order_id' => $order->id,
                'subtotal'=> $cart['price']*$cart['qty'],
                'qty'=> $cart['qty'],
                'item_id'=> $cart['id'],
                
            ]);

        }   

          return response()->json(['success' => "Order  Successful"]);
    }
}
