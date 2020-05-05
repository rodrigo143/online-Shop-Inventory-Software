<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function getData(Request $request)
    {
        $date = explode(' to ',$request['date']);
        $startDate = $date[0];
        if(isset($date[1])){
            $endDate = $date[1];
        }else{
            $endDate = $date[0];
        }
        $response['revenue'] = DB::table("orders")->where('orders.status','like','Paid')->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->get()->sum("subTotal");
        $response['allOrders'] = DB::table('orders')->count();
        $response['all'] = DB::table('orders')->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['processing'] = DB::table('orders')->where('status','like','Processing')->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['pendingPayment'] = DB::table('orders')->where('status','like','Payment Pending')->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['onHold'] = DB::table('orders')->where('status','like','On Hold')->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['canceled'] = DB::table('orders')->where('status','like','Canceled')->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['completed'] = DB::table('orders')->where('status','like','Completed')->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['pendingInvoiced'] = DB::table('orders')->where('status','like','Completed')->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->orWhere('orders.status', 'like', 'Pending Invoiced')->count();
        $response['invoiced'] = DB::table('orders')->where('status','like','Invoiced')->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['stockOut'] =  DB::table('orders')->where('status','like','Stock Out')->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['delivered'] = DB::table('orders')->where('status','like','Delivered')->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['customerConfirm'] =  DB::table('orders')->where('status','like','Customer Confirm')->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['paid'] = DB::table('orders')->where('status','like','Paid')->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['return'] = DB::table('orders')->where('status','like','Return')->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['lost'] = DB::table('orders')->where('status','like','Lost')->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['store'] =  DB::table("stores")->get()->count();
        $response['user'] = DB::table("users")->where('role_id','=','2')->get()->count();
        $response['status'] = 'success';
         return json_encode($response);

    }

}
