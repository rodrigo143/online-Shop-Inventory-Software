<?php

namespace App\Http\Controllers\user;

use App\City;
use App\Courier;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\Notification;
use App\Order;
use App\OrderProducts;
use App\Payment;
use App\PaymentType;
use App\Product;
use App\Stock;
use App\Store;
use App\User;
use App\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Show Orders Page
    public function index()
    {
        $status = 'all';
        return view('user.order.index',compact('status'));
    }

    // Create Order Page
    public function create()
    {
        $unique =  $this->uniqueID();
        return view('user.order.create',compact('unique'));
    }

    // Order Store
    public function store(Request $request)
    {
        $order = new Order();
        $order->invoiceID = $request['data']['invoiceID'];
        $order->store_id = $request['data']['storeID'];
        $order->subTotal = $request['data']['total'];
        $order->deliveryCharge = $request['data']['deliveryCharge'];
        $order->discountCharge = $request['data']['discountCharge'];
        $order->payment_type_id = $request['data']['paymentTypeID'];
        $order->payment_id = $request['data']['paymentID'];
        $order->paymentAmount = $request['data']['paymentAmount'];
        $order->paymentAgentNumber = $request['data']['paymentAgentNumber'];
        $order->orderDate = $request['data']['orderDate'];
        $order->courier_id = $request['data']['courierID'];
        $order->city_id = $request['data']['cityID'];
        $order->zone_id = $request['data']['zoneID'];
        $products = $request['data']['products'];
        $order->user_id = Auth::id();
        $result = $order->save();
        if ($result) {
            $customer = new Customer();
            $customer->order_id = $order->id;
            $customer->customerName = $request['data']['customerName'];
            $customer->customerPhone = $request['data']['customerPhone'];
            $customer->customerAddress = $request['data']['customerAddress'];
            $customer->save();
            foreach ($products as $product) {
                $orderProducts  = new OrderProducts();
                $orderProducts->order_id = $order->id;
                $orderProducts->product_id = $product['productID'];
                $orderProducts->productCode = $product['productCode'];
                $orderProducts->productName = $product['productName'];
                $orderProducts->quantity = $product['productQuantity'];
                $orderProducts->productPrice = $product['productPrice'];
                $orderProducts->save();
            }

            $notification = new Notification();
            $notification->order_id = $order->id;
            $notification->notificaton = 'Order Has Been Created';
            $notification->user_id =  Auth::id();
            $notification->save();
            $notification = new Notification();
            $notification->order_id = $order->id;
            $notification->notificaton = 'Order Has Been Assign To '.Auth::user()->name;
            $notification->user_id =  Auth::id();
            $notification->save();
            $response['status'] = 'success';
            $response['message'] = 'Successfully Add Order';
        } else {
            Customer::where('order_id','=',$order->id)->delete();
            OrderProducts::where('order_id','=',$order->id)->delete();
            Notification::where('order_id','=',$order->id)->delete();
            Order::where('id','=',$order->id)->delete();
            $response['status'] = 'failed';
            $response['message'] = 'Unsuccessful to Add Order';
        }
        return json_encode($response);
        die();
    }

   // Show orders
    public function show($id)
    {
        $orders  = DB::table('orders')
            ->select('orders.*', 'customers.customerName', 'customers.customerPhone', 'customers.customerAddress', 'couriers.courierName', 'cities.cityName', 'zones.zoneName', 'users.name')
            ->leftJoin('customers', 'orders.id', '=', 'customers.order_id')
            ->leftJoin('couriers', 'orders.courier_id', '=', 'couriers.id')
            ->leftJoin('cities', 'orders.city_id', '=', 'cities.id')
            ->leftJoin('zones', 'orders.zone_id', '=', 'zones.id')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id');
        if ($_REQUEST['status'] == 'All') {
            $orders  = $orders->latest('orders.id')->get();
        } else if ($_REQUEST['status'] == 'Pending Invoiced') {
             $orders  = $orders->where([
                 ['orders.status', 'like', 'Completed'],
                 ['orders.user_id', '=', Auth::id()]
             ])->orWhere('orders.status', 'like', 'Pending Invoiced')->latest('orders.id')->get();
         } else {
            $orders  = $orders->where([
                ['orders.status', 'like', $_REQUEST['status']],
                ['orders.user_id', '=', Auth::id()]
            ])->latest('orders.id')->get();
        }
        $order['data'] = $orders->map(function ($order) {
            $products = DB::table('order_products')->select('order_products.*')->where('order_id', '=', $order->id)->get();
            $orderProducts = '';
            foreach ($products as $product) {
                $orderProducts = $orderProducts . $product->quantity.' x '. $product->productName . '<br>';
            }
            $notification = Notification::query()->where('order_id', '=', $order->id)->latest('id')->get()->first();
            if($_REQUEST['status'] != 'Paid' && $_REQUEST['status'] != 'Return' && $_REQUEST['status'] != 'Lost'){
                if($_REQUEST['status'] == 'Pending Invoiced' ){
                    $order->status = $this->statusList('Pending Invoiced', $order->id);
                }else{
                    $order->status = $this->statusList($order->status, $order->id);
                }
            }
            $order->products = rtrim($orderProducts, '<br>');
            $order->notification = $notification->notificaton;

            return $order;
        });
        return $order;
    }

    // Edit Single Order
    public function edit($id)
    {
        $orders  = DB::table('orders')
            ->select('orders.*', 'customers.customerName', 'customers.customerPhone', 'customers.customerAddress', 'couriers.courierName', 'cities.cityName', 'zones.zoneName', 'users.name', 'stores.*', 'payment_types.paymentTypeName', 'payments.paymentNumber')
            ->leftJoin('customers', 'orders.id', '=', 'customers.order_id')
            ->leftJoin('couriers', 'orders.courier_id', '=', 'couriers.id')
            ->leftJoin('payment_types', 'orders.payment_type_id', '=', 'payment_types.id')
            ->leftJoin('payments', 'orders.payment_id', '=', 'payments.id')
            ->leftJoin('cities', 'orders.city_id', '=', 'cities.id')
            ->leftJoin('zones', 'orders.zone_id', '=', 'zones.id')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('stores', 'orders.store_id', '=', 'stores.id')
            ->where('orders.id', '=', $id)->get()->first();
        $products = DB::table('order_products')->where('order_id', '=', $id)->get();
        $orders->products = $products;
        $orders->id = $id;
        return view('user.order.edit')->with('order', $orders);
    }

    // Update Order
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $order->store_id = $request['data']['storeID'];
        $order->subTotal = $request['data']['total'];

        $order->memo = $request['data']['memo'];
        $order->deliveryCharge = $request['data']['deliveryCharge'];
        $order->discountCharge = $request['data']['discountCharge'];
        $order->payment_type_id = $request['data']['paymentTypeID'];
        $order->payment_id = $request['data']['paymentID'];
        $order->paymentAmount = $request['data']['paymentAmount'];
        $order->paymentAgentNumber = $request['data']['paymentAgentNumber'];
        $order->orderDate = $request['data']['orderDate'];
        $order->courier_id = $request['data']['courierID'];
        $order->city_id = $request['data']['cityID'];
        $order->zone_id = $request['data']['zoneID'];
        $products = $request['data']['products'];
        $result = $order->update();
        if ($result) {
            $customer = Customer::where('order_id','=',$id)->first();
            $customer->customerName = $request['data']['customerName'];
            $customer->customerPhone = $request['data']['customerPhone'];
            $customer->customerAddress = $request['data']['customerAddress'];
            $customer->update();
            OrderProducts::where('order_id','=',$id)->delete();
            foreach ($products as $product) {
                $orderProducts  = new OrderProducts();
                $orderProducts->order_id = $id;
                $orderProducts->product_id = $product['productID'];
                $orderProducts->productCode = $product['productCode'];
                $orderProducts->productName = $product['productName'];
                $orderProducts->quantity = $product['productQuantity'];
                $orderProducts->productPrice = $product['productPrice'];
                $orderProducts->save();
            }

            $notification = new Notification();
            $notification->order_id = $order->id;
            $notification->notificaton = Auth::user()->name .' Update Order Details';
            $notification->user_id =  Auth::id();
            $notification->save();
            $response['status'] = 'success';
            $response['message'] = 'Successfully Update Order';
        } else {
            $response['status'] = 'failed';
            $response['message'] = 'Unsuccessful to Update Order';
        }
        return json_encode($response);
    }

    // Show Order By status
    public function ordersByStatus($status)
    {
        $users = DB::table('users')->where([
            ['status', 'like', 'Active'],
            ['role_id', '=', '2']
        ])->inRandomOrder()->get();
        if($status == 'Pending Invoiced' ||$status ==  'Invoiced' || $status == 'Stock Out' ){
            return view('user.order.invoiced',compact('status','users'));
        }
        if($status == 'Delivered' ||$status ==  'Customer Confirm' || $status == 'Paid' || $status == 'Return' || $status == 'Lost' ){
            return view('user.order.delivered',compact('status','users'));
        }else{
            return view('user.order.index',compact('status','users'));
        }

    }

    // Get Products
    public function product(Request $request)
    {
        if (isset($request['q'])) {
            $products = Product::query()->where('productName', 'like', '%' . $request['q'] . '%')->get();
        } else {
            $products = Product::all();
        }
        $product = array();
        foreach ($products as $item) {
            $product[] = array(
                "id" => $item['id'],
                "text" => $item['productName'],
                "image" => url('/product/' . $item['productImage']),
                "productCode" => $item['productCode'],
                "productPrice" => $item['productPrice']
            );
        }
        $data['data'] = $product;
        return json_encode($data);
        die();
    }

    // get Stores
    public function stores(Request $request)
    {
        if (isset($request['q'])) {
            $stores = Store::query()->where([
                ['storeName', 'like', '%' . $request['q'] . '%'],
                ['status', 'like', 'Active']
            ])->get();
        } else {
            $stores = Store::query()->where('status', 'like', 'Active')->get();
        }
        $store = array();
        foreach ($stores as $item) {
            $store[] = array(
                "id" => $item['id'],
                "text" => $item['storeName']
            );
        }
        return json_encode($store);
        die();
    }

    // Get Payment Type
    public function paymenttype(Request $request)
    {
        if (isset($request['q'])) {
            $paymentTypes = PaymentType::query()->where([
                ['paymentTypeName', 'like', '%' . $request['q'] . '%'],
                ['status', 'like', 'Active']
            ])->get();
        } else {
            $paymentTypes = PaymentType::query()->where('status', 'like', 'Active')->get();
        }
        $paymentType = array();
        foreach ($paymentTypes as $item) {
            $paymentType[] = array(
                "id" => $item['id'],
                "text" => $item['paymentTypeName']
            );
        }
        return json_encode($paymentType);
    }

    // Get Payment Number
    public function paymentnumber(Request $request)
    {
        if (isset($request['q']) && $request['paymentTypeID']) {
            $payments = Payment::query()->where([
                ['paymentNumber', 'like', '%' . $request['q'] . '%'],
                ['status', 'like', 'Active'],
                ['payment_type_id', '=',  $request['paymentTypeID']]
            ])->get();
        } else {
            $payments = Payment::query()->where([
                ['status', 'like', 'Active'],
                ['payment_type_id', '=',  $request['paymentTypeID']]
            ])->get();
        }
        $payment = array();
        foreach ($payments as $item) {
            $payment[] = array(
                "id" => $item['id'],
                "text" => $item['paymentNumber']
            );
        }
        return json_encode($payment);
    }

    // Get Courier
    public function courier(Request $request)
    {
        if (isset($request['q'])) {
            $couriers = Courier::query()->where([
                ['courierName', 'like', '%' . $request['q'] . '%'],
                ['status', 'like', 'Active']
            ])->get();
        } else {
            $couriers = Courier::query()->where('status', 'like', 'Active')->get();
        }
        $courier = array();
        foreach ($couriers as $item) {
            $courier[] = array(
                "id" => $item['id'],
                "text" => $item['courierName']
            );
        }
        return json_encode($courier);
    }

    // Get City
    public function city(Request $request)
    {
        if (isset($request['q']) && $request['courierID']) {
            $cites = City::query()->where([
                ['cityName', 'like', '%' . $request['q'] . '%'],
                ['status', 'like', 'Active'],
                ['courier_id', '=',  $request['courierID']]
            ])->get();
        } else {
            $cites = City::query()->where([
                ['status', 'like', 'Active'],
                ['courier_id', '=',  $request['courierID']]
            ])->get();
        }
        $city = array();
        foreach ($cites as $item) {
            $city[] = array(
                "id" => $item['id'],
                "text" => $item['cityName']
            );
        }
        return json_encode($city);
    }

    // Get Zone
    public function zone(Request $request)
    {
        if (isset($request['q'])) {
            $zones = Zone::query()->where([
                ['zoneName', 'like', '%' . $request['q'] . '%'],
                ['courier_id', '=',  $request['courierID']],
                ['status', 'like', 'Active'],
                ['city_id', '=',  $request['cityID']]
            ])->get();
        } else {
            $zones = Zone::query()->where([
                ['courier_id', '=',  $request['courierID']],
                ['city_id', '=',  $request['cityID']],
                ['status', 'like', 'Active']
            ])->get();
        }
        $zone = array();
        foreach ($zones as $item) {
            $zone[] = array(
                "id" => $item['id'],
                "text" => $item['zoneName']
            );
        }
        return json_encode($zone);
    }

    // All Status List
    public function statusList($status, $id)
    {
        $allStatus = array(
            'order' => array(
                "Processing" => array(
                    "name" => "Processing",
                    "icon" => "fe-tag",
                    "color" => "bg-primary"
                ),
                "On Hold" => array(
                    "name" => "On Hold",
                    "icon" => "far fa-stop-circle",
                    "color" => "bg-warning"
                ),
                "Payment Pending" => array(
                    "name" => "Payment Pending",
                    "icon" => "fe-tag",
                    "color" => "bg-info"
                ),
                "Canceled" => array(
                    "name" => "Canceled",
                    "icon" => "fe-trash-2",
                    "color" => "bg-danger"
                ),
                "Completed" => array(
                    "name" => "Completed",
                    "icon" => "fe-check-circle",
                    "color" => "bg-success"
                )
            ),
            'invoice' =>array(
                "Pending Invoiced" => array(
                    "name" => "Pending Invoiced",
                    "color" => "bg-primary"
                ),
                "Invoiced" => array(
                    "name" => "Invoiced",
                    "color" => "bg-warning"
                ),
                "Stock Out" => array(
                    "name" => "Stock Out",
                    "color" => "bg-info"
                ),
                "Delivered" => array(
                    "name" => "Delivered",
                    "color" => "bg-info"
                )
            ),
            'delivered' =>array(
                "Delivered" => array(
                    "name" => "Delivered",
                    "color" => "bg-primary"
                ),
                "Customer Confirm" => array(
                    "name" => "Customer Confirm",
                    "color" => "bg-warning"
                ),
                "Paid" => array(
                    "name" => "Paid",
                    "color" => "bg-info"
                ),
                "Return" => array(
                    "name" => "Return",
                    "color" => "bg-danger"
                ),
                "Lost" => array(
                    "name" => "Lost",
                    "color" => "bg-danger"
                )
            )
        );

        $temp= 'order';
        foreach($allStatus as $key => $value){
            foreach($value as $kes => $val){
                if($kes == $status){
                    $temp = $key;
                }
            }
        }
        $args = $allStatus[$temp];
        $html = '';
        foreach ($args as $value) {

            if($args[$status]['name'] !=  $value['name']){
                $html = $html . "<a class='dropdown-item btn-status' data-id='" . $id . "' data-status='" . $value['name'] . "' href='#'>" . $value['name'] . "</a>";
            }
        }
        $response =  "<div class='btn-group dropdown'>
            <a href='javascript: void(0);'  class='table-action-btn dropdown-toggle arrow-none btn " . $args[$status]['color'] . " btn-xs' data-toggle='dropdown' aria-expanded='false'>" . $args[$status]['name'] . "</a>
            <div class='dropdown-menu dropdown-menu-right'>
            " . $html . "
            </div>
        </div>";

        return $response;
    }

    // Create Invoice ID
    public function uniqueID()
    {
        $lastOrder = Order::latest('id')->first();
        if($lastOrder){
            $orderID = $lastOrder->id + 1;
        }else{
            $orderID = 1;
        }

        return 'DN'.$orderID;
    }

    // Order Sync
    public function orderSync(Request $request)
    {
        $stores = Store::query()->where('status', 'like', 'Active')->get();
        $orderCount = 0 ;
        foreach ($stores as $store){
            $syncOrders = json_decode($this->getOrders($store->storeUrl));
            foreach ($syncOrders as $syncOrder){
                $orderExist = Order::query()->where('web_ID', '=',$syncOrder->wp_id)->get()->first();

                if(!$orderExist){
                    $user = DB::table('users')->where([
                        ['status', 'like', 'Active'],
                        ['role_id', '=', '2']
                    ])->inRandomOrder()->first();

                    $order = new Order();
                    $order->invoiceID = $this->uniqueID();
                    $order->web_ID = $syncOrder->wp_id;
                    $order->subTotal =$syncOrder->total;
                    $order->orderDate = date('yy-m-d');
                    $order->user_id = $user->id;
                    $order->store_id = $store->id;
                    $result = $order->save();
                    $products = $syncOrder->products;
                    if ($result) {
                        $customer = new Customer();
                        $customer->order_id = $order->id;
                        $customer->customerName = $syncOrder->customer->first_name;
                        $customer->customerPhone = $syncOrder->customer->phone;
                        $customer->customerAddress = $syncOrder->customer->address_1;
                        $customer->save();
                        foreach ($products as $product) {
                            $orderProducts  = new OrderProducts();
                            $productExist = Product::query()->where('productCode', 'like', $product->sku)->get()->first();
                            if($productExist){
                                $orderProducts->order_id = $order->id;
                                $orderProducts->product_id = $productExist->id;
                                $orderProducts->productCode = $product->sku;
                                $orderProducts->productName = $product->product_name;
                                $orderProducts->quantity = $product->quantity;
                                $orderProducts->productPrice = $product->price;
                                $orderProducts->save();
                            }else{
                                $this->productSync();
                                $productExist = Product::query()->where('productCode', 'like', $product->sku)->get()->first();
                                $orderProducts->order_id = $order->id;
                                $orderProducts->product_id = $productExist->id;
                                $orderProducts->productCode = $product->sku;
                                $orderProducts->productName = $product->product_name;
                                $orderProducts->quantity = $product->quantity;
                                $orderProducts->productPrice = $product->price;
                                $orderProducts->save();
                            }
                        }
                        $notification = new Notification();
                        $notification->order_id = $order->id;
                        $notification->notificaton = 'Order Has Been Created';
                        $notification->user_id =  $user->id;
                        $notification->save();
                    }
                    $orderCount++;
                }
            }

        }

        if($orderCount > 0){
            $response['status'] = 'success';
            $response['orders'] = $orderCount;
        }else{
            $response['status'] = 'failed';
            $response['orders'] = $orderCount;
        }
        return json_encode($response);
    }

    // Get Orders from website
    public function getOrders($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/wp-json/inventory/v1/order/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));
        return curl_exec($curl);
    }


    // Change Single order Status
    public function status(Request $request)
    {
        $id = $request['id'];

        $status = $request['status'];
        $order = Order::find($id);


        if($request['status'] == 'Delivered'){
            $order->deliveryDate = date('yy-m-d');
            $orderProducts = OrderProducts::query()->where('order_id','=',$order->id)->get();
            foreach ($orderProducts as $orderProduct) {
                $stock =  Stock::query()->where('product_id','=',$orderProduct->product_id)->first();
                $stock->stock =  $stock->stock - $orderProduct->quantity;
                $stock->save();
            }
        }
        if($request['status'] == 'Paid'){
            $order->completeDate = date('yy-m-d');
        }
        if($request['status'] == 'Return'){
            $order->completeDate = date('yy-m-d');
            $orderProducts = OrderProducts::query()->where('order_id','=',$order->id)->get();
            foreach ($orderProducts as $orderProduct) {
                $stock =  Stock::query()->where('product_id','=',$orderProduct->product_id)->first();
                $stock->stock =  $stock->stock + $orderProduct->quantity;
                $stock->save();
            }
        }

        if($order->courier_id || $status == 'On Hold'){
            $order->status = $status;
            $result = $order->save();
            if ($result) {
                $response['status'] = 'success';
                $response['message'] = 'Successfully Update Status to ' . $request['status'];
                $notification = new Notification();
                $notification->order_id = $id;
                $notification->notificaton = 'Successfully Update status to '.$status . ' by '. Auth::user()->name;
                $notification->user_id =  Auth::id();
                $notification->save();
            } else {
                $response['status'] = 'failed';
                $response['message'] = 'Unsuccessful to update Status ' . $request['status'];
            }
        }else {
            $response['status'] = 'failed';
            $response['message'] = 'Please Update order courier and try again !';
        }

        return json_encode($response);
    }

    // Change Multiple Order Status
    public function changeStatusByCheckbox(Request $request)
    {

        $status = $request['status'];
        $ids = $request['ids'];
        if($ids){
            foreach ($ids as $id){
                $order = Order::find($id);
                $order->status = $status;
                $order->save();
                $notification = new Notification();
                $notification->order_id = $id;
                $notification->notificaton = 'Successfully Update status to '.$status . ' by '. Auth::user()->name;
                $notification->user_id =  Auth::id();
                $notification->save();
            }
            $response['status'] = 'success';
            $response['message'] = 'Successfully Assign User to this Order';
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Unsuccessful to Assign User to this Order';
        }
        return json_encode($response);
    }

    //
    public function pendingInvoiced()
    {
        $status = 'all';
        return view('user.order.index',compact('status'));
    }

    // Product Sync if Not exist
    public function productSync()
    {
        $stores = Store::query()->where('status', 'like', 'Active')->get();
        $orderCount = 0;
        foreach ($stores as $store){
            $syncProducts = json_decode($this->getProducts($store->storeUrl));
            foreach ($syncProducts as $syncProduct){
                $LocalProduct = Product::where('productCode', 'like', $syncProduct->sku)->get()->first();
                if(!$LocalProduct && $syncProduct->price) {
                    $image = $syncProduct->image;
                    $imageName =  uniqid() . '.jpg';
                    $img = public_path('product/') .$imageName;
                    file_put_contents($img, file_get_contents($image));
                    $newProduct = new Product();
                    $newProduct->productCode = $syncProduct->sku;
                    $newProduct->productName = $syncProduct->name;
                    $newProduct->productPrice = $syncProduct->price;
                    $newProduct->productImage = $imageName;
                    $newProduct->save();
                    $orderCount++;
                }
            }

        }
        if($orderCount > 0){
            $response['status'] = 'success';
            $response['products'] = $orderCount;
        }else{
            $response['status'] = 'failed';
            $response['products'] = $orderCount;
        }
        return json_encode($response);
    }

    // Get Products From website
    public function getProducts($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/wp-json/inventory/v1/products/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));
        return curl_exec($curl);
    }

    // Get Note of order
    public function getNotes(Request $request)
    {

        $order_id = $request['id'];
        $notification = Notification::query()->where('order_id','=',$order_id)->latest()->get();
        $notification['data'] = $notification->map(function ($notification) {
            $user = DB::table('users')->select('users.name')->where('id', '=', $notification->user_id)->get()->first();
            $notification->name = $user->name;
            $notification->date = $this->time_ago_in_php($notification->created_at);

            return $notification;
        });
        return json_encode($notification);

    }

    // Update Note of Order
    public function updateNotes(Request $request)
    {
        $id = $request['id'];
        $note = $request['note'];

        $notification = new Notification();
        $notification->order_id = $id;
        $notification->notificaton = $note;
        $notification->user_id =  Auth::id();
        $request = $notification->save();

        if($request) {
            $response['status'] = 'success';
            $response['message'] = 'Successfully to Update Order note';
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Unsuccessful to Update Order note';
        }
        return json_encode($response);

    }

    // Change time to facebook Style
    public function time_ago_in_php($timestamp)
    {

    date_default_timezone_set("Asia/Dhaka");
    $time_ago        = strtotime($timestamp);
    $current_time    = time();
    $time_difference = $current_time - $time_ago;
    $seconds         = $time_difference;

    $minutes = round($seconds / 60); // value 60 is seconds
    $hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec
    $days    = round($seconds / 86400); //86400 = 24 * 60 * 60;
    $weeks   = round($seconds / 604800); // 7*24*60*60;
    $months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60
    $years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60

    if ($seconds <= 60) {

        return "Just Now";
    } else if ($minutes <= 60) {

        if ($minutes == 1) {

            return "one minute ago";
        } else {

            return "$minutes minutes ago";
        }
    } else if ($hours <= 24) {

        if ($hours == 1) {

            return "an hour ago";
        } else {

            return "$hours hrs ago";
        }
    } else if ($days <= 7) {

        if ($days == 1) {

            return "yesterday";
        } else {

            return "$days days ago";
        }
    } else if ($weeks <= 4.3) {

        if ($weeks == 1) {

            return "a week ago";
        } else {

            return "$weeks weeks ago";
        }
    } else if ($months <= 12) {

        if ($months == 1) {

            return "a month ago";
        } else {

            return "$months months ago";
        }
    } else {

        if ($years == 1) {

            return "one year ago";
        } else {

            return "$years years ago";
        }
    }
}

    // Get Old Orders
    public function oldOrders(Request $request)
    {
        $order_id = $request['id'];
        $customer = Customer::query()->where('order_id','=',$order_id)->get()->first();
        $orders  = DB::table('orders')
            ->select('orders.*', 'customers.*')
            ->leftJoin('customers', 'orders.id', '=', 'customers.order_id')
            ->where([
                ['customers.order_id','!=',$order_id],
                ['customers.customerPhone','like',$customer->customerPhone]
            ])->get();
        $order['data'] = $orders->map(function ($order) {
            $products = DB::table('order_products')->select('order_products.*')->where('order_id', '=', $order->id)->get();
            $orderProducts = '';
            foreach ($products as $product) {
                $orderProducts = $orderProducts . $product->quantity.' x '. $product->productName . '<br>';
            }
            $order->products = rtrim($orderProducts, '<br>');
            return $order;
        });
        return json_encode($order);

//        return $orders;
    }

    // Get Status Wise order Count
    public function countOrders()
    {
        $user_id = Auth::id();
        $response['all'] = DB::table('orders')->where('orders.user_id','=',$user_id)->count();
        $response['processing'] = DB::table('orders')->where('status','like','Processing')->where('orders.user_id','=',$user_id)->count();
        $response['pendingPayment'] = DB::table('orders')->where('status','like','Payment Pending')->where('orders.user_id','=',$user_id)->count();
        $response['onHold'] = DB::table('orders')->where('status','like','On Hold')->where('orders.user_id','=',$user_id)->count();
        $response['canceled'] = DB::table('orders')->where('status','like','Canceled')->where('orders.user_id','=',$user_id)->count();
        $response['completed'] = DB::table('orders')->where('status','like','Completed')->where('orders.user_id','=',$user_id)->count();
        $response['pendingInvoiced'] = DB::table('orders')->where('status','like','Completed')->where('orders.user_id','=',$user_id)->orWhere('orders.status', 'like', 'Pending Invoiced')->count();
        $response['invoiced'] = DB::table('orders')->where('status','like','Invoiced')->where('orders.user_id','=',$user_id)->count();
        $response['stockOut'] =  DB::table('orders')->where('status','like','Stock Out')->where('orders.user_id','=',$user_id)->count();
        $response['delivered'] = DB::table('orders')->where('status','like','Delivered')->where('orders.user_id','=',$user_id)->count();
        $response['customerConfirm'] =  DB::table('orders')->where('status','like','Customer Confirm')->where('orders.user_id','=',$user_id)->count();
        $response['paid'] = DB::table('orders')->where('status','like','Paid')->where('orders.user_id','=',$user_id)->count();
        $response['return'] = DB::table('orders')->where('status','like','Return')->where('orders.user_id','=',$user_id)->count();
        $response['lost'] = DB::table('orders')->where('status','like','Lost')->where('orders.user_id','=',$user_id)->count();
        $response['status'] = 'success';
        return json_encode($response);
    }

    // Invoice Display
    public function storeInvoice(Request $request)
    {
        $ids = serialize($request['ids']);
        $invoice = new Invoice();
        $invoice->order_id = $ids;
        $result = $invoice->save();
        if($result){
            $response['status'] = 'success';
            $response['link'] = url('user/order/invoice/').'/'.$invoice->id;
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Unsuccessful to Add Order';
        }
        return json_encode($response);
        die();
    }

    public function invoice()
    {
        //        return view();
    }

    public function viewInvoice()
    {
        $orders  = DB::table('orders')
            ->select('orders.*', 'customers.customerName', 'customers.customerPhone', 'customers.customerAddress', 'couriers.courierName', 'cities.cityName', 'zones.zoneName', 'users.name')
            ->join('customers', 'orders.id', '=', 'customers.order_id')
            ->leftJoin('couriers', 'orders.courier_id', '=', 'couriers.id')
            ->leftJoin('cities', 'orders.city_id', '=', 'cities.id')
            ->leftJoin('zones', 'orders.zone_id', '=', 'zones.id')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id');


        return view('user.order.print');

    }

}
