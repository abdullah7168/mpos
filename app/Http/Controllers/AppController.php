<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use View;
use App\Order;
use App\OrderProduct;
use Illuminate\Support\Facades\DB;

class AppController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home(){
        return view('dashboard.home');
    }

    public function getInventory(){
        $products = Product::all();
        return view('dashboard.inventory-index',compact('products'));
    }

    public function getAddProduct(){
        return view('dashboard.inventory-add-product');
    }

    public function postAddProduct(Request $request){

        $prd = Product::where('name',$request->name)->get();
        if(count($prd) > 0){
            $prd[0]->quantity = $prd[0]->quantity + $request->quantity;
            $prd[0]->save();
            return redirect('/inventory')
                    ->with('message','Updated the quantity');
        }
        $product = new Product;
        $product->name = $request->name;
        $product->quantity = $request->quantity;
        $product->sale_price = $request->sale_price;
        $product->purchase_price = $request->purchase_price;
        $product->save();
        return redirect('/inventory')
                ->with('message','Added a new product');
    }

    public function getPlaceOrder(){
        return view('dashboard.place-order');
    }

    public function postPlaceOrder(Request $request){

        $_order = json_decode($request->order);

        $order = new Order;
        $order->total = 0;
        $order->save();
        $total = 0;
        foreach($_order as $item){

            $product = Product::findOrFail($item->id);
            if($product->quantity < $item->quantity)
                return response()->json(
                    array(
                        'status' => 0,
                        'quantities' => [
                                            'prq'=>$product->quantity,
                                            'itemq'=>$item->quantity
                                        ],
                        'product_id' => $product->id
                    ));
    
            $product->quantity = (int)$product->quantity - (int)$item->quantity;
            $product->save();

            $order_product = new OrderProduct;
            $order_product->product_id = $product->id;
            $order_product->quantity = $item->quantity;
            $order_product->sale_price = $item->sale_price;
            $order_product->order_id = $order->id;
            $order_product->save();

            $total = (int) $total + (int) $item->sale_price;
        }

        DB::table('orders')->where('id',$order->id)->update(['total' => $total]);

        return response()->json(array('status' => 1,'order_id' => $order->id));
        
    }
    public function getProductList(Request $request){
        $products = Product::where('name','LIKE','%'.$request->name.'%')
                            ->where('quantity', '>=',1)
                            ->limit(10)
                            ->get();
        $productsHTML = View::make(
                    'dashboard.partials.__product_list',
                    ['products' => $products]
                );
        return $productsHTML->render();
    }

    public function getOrders(){
        $orders = Order::with('products')->get();
       
        return view('dashboard.orders',compact('orders'));
    }

    public function showOrder($id){
        $order = Order::where('id',$id)->with('products')->first();
        return view('dashboard.order',compact('order'));
    }

    public function showSalesReport(){
        return view('dashboard.sales-reports');
    }
    
    public function getOrdersJson(Request $request){

        $query = DB::raw('DATE(created_at) as date');
        if($request->has('type')){
            switch ($request->type) {
                case 'monthly':
                    $query = DB::raw('DATE(created_at) as date');
                    break;
                case 'day':
                    $query = DB::raw('DATE(created_at) as date');
                    break;

                default:
                    $query = DB::raw('DATE(created_at) as date');
                    break;
            }
        }

        $orders = Order::select(DB::raw('DATE(created_at) as date'),DB::raw('COUNT(id) as units'))
                        ->groupBy('date')
                        ->get();
        
        return json_encode($orders);
    }                   
    

}
