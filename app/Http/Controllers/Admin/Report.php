<?php

namespace App\Http\Controllers\Admin;

use App\Courier;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Report extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dateCourierUser()
    {
        return view('admin.report.dateCourierUser');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function multipleDateCourierUser()
    {
        return view('admin.report.multipleDateCourierUser');
    }

    public function getMultipleDateCourierUser(Request $request)
    {

        $orders  = DB::table('orders')
            ->select('orders.*', 'customers.customerName', 'customers.customerPhone', 'customers.customerAddress', 'couriers.courierName', 'cities.cityName', 'zones.zoneName', 'users.name')
            ->join('customers', 'orders.id', '=', 'customers.order_id')
            ->leftJoin('couriers', 'orders.courier_id', '=', 'couriers.id')
            ->leftJoin('cities', 'orders.city_id', '=', 'cities.id')
            ->leftJoin('zones', 'orders.zone_id', '=', 'zones.id')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id');
        if($request['startDate'] != '' && $request['endDate'] != ''){
            $orders = $orders->whereBetween('orders.orderDate', [$request['startDate'].' 00:00:00',$request['endDate'].' 23:59:59']);
        }
        if($request['courierID'] != ''){
            $orders = $orders->where('orders.courier_id','=',$request['courierID']);
        }
        if($request['orderStatus'] != 'All'){
            $orders = $orders->where('orders.status','like',$request['orderStatus']);
        }
        if($request['userID'] != ''){
            $orders = $orders->where('orders.user_id','=',$request['userID']);
        }
        $orders = $orders->latest()->get();
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dateCourier()
    {
        return view('admin.report.dateCourier');
    }

    public function getDateCourier(Request $request)
    {
        $response = [];
        if($request['courierID'] == ''){
            $couriers = Courier::all();
            foreach ($couriers as $courier){
                $temp['courier'] = $courier->courierName;
                $temp['date'] = $request['startDate'].' to '.$request['endDate'];
                $temp['all'] = $this->getStatusDateCourier($request['startDate'],$request['endDate'],$courier->id,'');
                $temp['pendingPayment'] = $this->getStatusDateCourier($request['startDate'],$request['endDate'],$courier->id,'Payment Pending');
                $temp['onHold'] = $this->getStatusDateCourier($request['startDate'],$request['endDate'],$courier->id,'On Hold');
                $temp['canceled'] = $this->getStatusDateCourier($request['startDate'],$request['endDate'],$courier->id,'Canceled');
                $temp['invoiced'] = $this->getStatusDateCourier($request['startDate'],$request['endDate'],$courier->id,'Invoiced');
                $temp['stockOut'] = $this->getStatusDateCourier($request['startDate'],$request['endDate'],$courier->id,'Stock Out');
                $temp['delivered'] = $this->getStatusDateCourier($request['startDate'],$request['endDate'],$courier->id,'Delivered');
                $temp['paid'] = $this->getStatusDateCourier($request['startDate'],$request['endDate'],$courier->id,'Paid');
                $temp['paidAmount'] = $this->getStatusDateCourierAmount($request['startDate'],$request['endDate'],$courier->id,'Paid');
                $temp['return'] = $this->getStatusDateCourier($request['startDate'],$request['endDate'],$courier->id,'Return');
                array_push($response,$temp);
            }
        }else{
            $courier = Courier::find($request['courierID']);
            $temp['courier'] = $courier->courierName;
            $temp['date'] = $request['startDate'].' to '.$request['endDate'];
            $temp['all'] = $this->getStatusDateCourier($request['startDate'],$request['endDate'],$courier->id,'');
            $temp['pendingPayment'] = $this->getStatusDateCourier($request['startDate'],$request['endDate'],$courier->id,'Payment Pending');
            $temp['onHold'] = $this->getStatusDateCourier($request['startDate'],$request['endDate'],$courier->id,'On Hold');
            $temp['canceled'] = $this->getStatusDateCourier($request['startDate'],$request['endDate'],$courier->id,'Canceled');
            $temp['invoiced'] = $this->getStatusDateCourier($request['startDate'],$request['endDate'],$courier->id,'Invoiced');
            $temp['stockOut'] = $this->getStatusDateCourier($request['startDate'],$request['endDate'],$courier->id,'Stock Out');
            $temp['delivered'] = $this->getStatusDateCourier($request['startDate'],$request['endDate'],$courier->id,'Delivered');
            $temp['paid'] = $this->getStatusDateCourier($request['startDate'],$request['endDate'],$courier->id,'Paid');
            $temp['paidAmount'] = $this->getStatusDateCourierAmount($request['startDate'],$request['endDate'],$courier->id,'Paid');
            $temp['return'] = $this->getStatusDateCourier($request['startDate'],$request['endDate'],$courier->id,'Return');
            array_push($response,$temp);
        }
        $result['data'] = $response;
        return json_encode($result);
    }

    public function getStatusDateCourier($startDate,$endDate,$courierID,$status)
    {
        $orders  = DB::table('orders')
            ->select('orders.*','couriers.courierName')
            ->leftJoin('couriers', 'orders.courier_id', '=', 'couriers.id');
        $orders = $orders->where('orders.courier_id','=',$courierID);

        if($startDate != '' && $endDate != ''){
            $orders = $orders->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59']);
        }
        if(!empty($status)){
            $orders = $orders->Where('orders.status','=',$status);
        }
        return $orders->get()->count();
    }

    public function getStatusDateCourierAmount($startDate,$endDate,$courierID,$status)
    {
        $orders  = DB::table('orders')
            ->select('orders.*','couriers.courierName')
            ->leftJoin('couriers', 'orders.courier_id', '=', 'couriers.id');
        $orders = $orders->where('orders.courier_id','=',$courierID);

        if($startDate != '' && $endDate != ''){
            $orders = $orders->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59']);
        }
        if(!empty($status)){
            $orders = $orders->Where('orders.status','=',$status);
        }
        return $orders->get()->sum('subTotal');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dateUser()
    {
        return view('admin.report.dateUser');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return false|string
     */
    public function getDateUser(Request $request)
    {
        $response = [];
        if($request['userID'] == ''){
            $users = User::all();
            foreach ($users as $user){
                $temp['name'] = $user->name;
                $temp['date'] = $request['startDate'].' to '.$request['endDate'];
                $temp['all'] = $this->getStatusDateUser($request['startDate'],$request['endDate'],$user->id,'');
                $temp['pendingPayment'] = $this->getStatusDateUser($request['startDate'],$request['endDate'],$user->id,'Payment Pending');
                $temp['onHold'] = $this->getStatusDateUser($request['startDate'],$request['endDate'],$user->id,'On Hold');
                $temp['canceled'] = $this->getStatusDateUser($request['startDate'],$request['endDate'],$user->id,'Canceled');
                $temp['invoiced'] = $this->getStatusDateUser($request['startDate'],$request['endDate'],$user->id,'Invoiced');
                $temp['stockOut'] = $this->getStatusDateUser($request['startDate'],$request['endDate'],$user->id,'Stock Out');
                $temp['delivered'] = $this->getStatusDateUser($request['startDate'],$request['endDate'],$user->id,'Delivered');
                $temp['paid'] = $this->getStatusDateUser($request['startDate'],$request['endDate'],$user->id,'Paid');
                $temp['paidAmount'] = $this->getStatusDateUserAmount($request['startDate'],$request['endDate'],$user->id,'Paid');
                $temp['return'] = $this->getStatusDateUser($request['startDate'],$request['endDate'],$user->id,'Return');
                array_push($response,$temp);
            }
        }else{
            $user = User::find($request['userID']);
            $temp['name'] = $user->name;
            $temp['date'] = $request['startDate'].' to '.$request['endDate'];
            $temp['all'] = $this->getStatusDateUser($request['startDate'],$request['endDate'],$user->id,'');
            $temp['pendingPayment'] = $this->getStatusDateUser($request['startDate'],$request['endDate'],$user->id,'Payment Pending');
            $temp['onHold'] = $this->getStatusDateUser($request['startDate'],$request['endDate'],$user->id,'On Hold');
            $temp['canceled'] = $this->getStatusDateUser($request['startDate'],$request['endDate'],$user->id,'Canceled');
            $temp['invoiced'] = $this->getStatusDateUser($request['startDate'],$request['endDate'],$user->id,'Invoiced');
            $temp['stockOut'] = $this->getStatusDateUser($request['startDate'],$request['endDate'],$user->id,'Stock Out');
            $temp['delivered'] = $this->getStatusDateUser($request['startDate'],$request['endDate'],$user->id,'Delivered');
            $temp['paid'] = $this->getStatusDateUser($request['startDate'],$request['endDate'],$user->id,'Paid');
            $temp['paidAmount'] = $this->getStatusDateUserAmount($request['startDate'],$request['endDate'],$user->id,'Paid');
            $temp['return'] = $this->getStatusDateUser($request['startDate'],$request['endDate'],$user->id,'Return');
            array_push($response,$temp);
        }
        $result['data'] = $response;
        return json_encode($result);
    }

    public function getStatusDateUser($startDate,$endDate,$userID,$status)
    {
        $orders  = DB::table('orders')
            ->select('orders.*','couriers.courierName')
            ->leftJoin('couriers', 'orders.courier_id', '=', 'couriers.id');
        $orders = $orders->where('orders.user_id','=',$userID);

        if($startDate != '' && $endDate != ''){
            $orders = $orders->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59']);
        }
        if(!empty($status)){
            $orders = $orders->Where('orders.status','=',$status);
        }
        return $orders->get()->count();
    }

    public function getStatusDateUserAmount($startDate,$endDate,$userID,$status)
    {
        $orders  = DB::table('orders')
            ->select('orders.*','couriers.courierName')
            ->leftJoin('couriers', 'orders.courier_id', '=', 'couriers.id');
        $orders = $orders->where('orders.user_id','=',$userID);

        if($startDate != '' && $endDate != ''){
            $orders = $orders->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59']);
        }
        if(!empty($status)){
            $orders = $orders->Where('orders.status','=',$status);
        }
        return $orders->get()->sum('subTotal');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getOrdersOnDateCourierUser(Request $request)
    {
        $orders  = DB::table('orders')
            ->select('orders.*', 'customers.customerName', 'customers.customerPhone', 'customers.customerAddress', 'couriers.courierName', 'cities.cityName', 'zones.zoneName', 'users.name')
            ->join('customers', 'orders.id', '=', 'customers.order_id')
            ->leftJoin('couriers', 'orders.courier_id', '=', 'couriers.id')
            ->leftJoin('cities', 'orders.city_id', '=', 'cities.id')
            ->leftJoin('zones', 'orders.zone_id', '=', 'zones.id')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id');
        if($request['date'] != ''){
            $orders = $orders->where('orders.orderDate','like',$request['date']);
        }
        if($request['courierID'] != ''){
            $orders = $orders->where('orders.courier_id','=',$request['courierID']);
        }
        if($request['orderStatus'] != 'All'){
            $orders = $orders->where('orders.status','like',$request['orderStatus']);
        }
        if($request['userID'] != ''){
            $orders = $orders->where('orders.user_id','=',$request['userID']);
        }
        $orders = $orders->latest()->get();
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
    }

    public function users(Request $request)
    {
        if(isset($request['q'])){
            $users = User::query()->where('name','like','%'.$request['q'].'%')->get();
        }else{
            $users = User::all();
        }
        $user = array();
        foreach ($users as $item) {
            $user[] = array(
                "id" => $item['id'],
                "text" => $item['name']
            );
        }
        return json_encode($user);
    }

}
