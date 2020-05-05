<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('user.dashboard');
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
        $user_id = Auth::id();
        $response['all'] = DB::table('orders')->where('orders.user_id','=',$user_id)->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['processing'] = DB::table('orders')->where('status','like','Processing')->where('orders.user_id','=',$user_id)->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['pendingPayment'] = DB::table('orders')->where('status','like','Payment Pending')->where('orders.user_id','=',$user_id)->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['onHold'] = DB::table('orders')->where('status','like','On Hold')->where('orders.user_id','=',$user_id)->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['canceled'] = DB::table('orders')->where('status','like','Canceled')->where('orders.user_id','=',$user_id)->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['completed'] = DB::table('orders')->where('status','like','Completed')->where('orders.user_id','=',$user_id)->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['pendingInvoiced'] = DB::table('orders')->where('status','like','Completed')->where('orders.user_id','=',$user_id)->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->orWhere('orders.status', 'like', 'Pending Invoiced')->count();
        $response['invoiced'] = DB::table('orders')->where('status','like','Invoiced')->where('orders.user_id','=',$user_id)->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['stockOut'] =  DB::table('orders')->where('status','like','Stock Out')->where('orders.user_id','=',$user_id)->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['delivered'] = DB::table('orders')->where('status','like','Delivered')->where('orders.user_id','=',$user_id)->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['customerConfirm'] =  DB::table('orders')->where('status','like','Customer Confirm')->where('orders.user_id','=',$user_id)->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['paid'] = DB::table('orders')->where('status','like','Paid')->where('orders.user_id','=',$user_id)->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['return'] = DB::table('orders')->where('status','like','Return')->where('orders.user_id','=',$user_id)->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['lost'] = DB::table('orders')->where('status','like','Lost')->where('orders.user_id','=',$user_id)->whereBetween('orders.orderDate', [$startDate.' 00:00:00',$endDate.' 23:59:59'])->count();
        $response['status'] = 'success';
        return json_encode($response);

    }

}
