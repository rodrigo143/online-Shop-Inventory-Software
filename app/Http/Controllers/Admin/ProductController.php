<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderProducts;
use App\Product;
use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return false|string
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'productName' => 'required',
            'productPrice' => 'required',
            'productUrl' => 'required',
            'productCode' => 'required'
        ]);

        $product = new Product();
        $product->productName = $request['productName'];
        $product->productPrice = $request['productPrice'];
        $product->productImage = $request['productUrl'];
        $product->productCode = $request['productCode'];
        $result = $product->save();
        if ($result) {
            $response['status'] = 'success';
            $response['message'] = 'Successfully Add Product';

        } else {
            $response['status'] = 'failed';
            $response['message'] = 'Unsuccessful to Add Product';
        }
        return json_encode($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product['data'] = Product::latest()->get();
        return $product;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return false|string
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return json_encode($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return false|string
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'productName' => 'required',
            'productPrice' => 'required',
            'productUrl' => 'required',
            'productCode' => 'required'
        ]);

        $product = Product::find($id);
        $product->productName = $request['productName'];
        $product->productPrice = $request['productPrice'];
        $product->productImage = $request['productUrl'];
        $product->productCode = $request['productCode'];
        $result = $product->save();
        if ($result) {
            $response['status'] = 'success';
            $response['message'] = 'Successfully Add Product';

        } else {
            $response['status'] = 'failed';
            $response['message'] = 'Unsuccessful to Add Product';
        }
        return json_encode($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return false|string
     */
    public function destroy($id)
    {
        $result = Product::find($id)->delete();
        if($result){
            $response['status'] = 'success';
            $response['message'] = 'Successfully Delete Product';
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Unsuccessful to Delete Product';
        }
        return json_encode($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return false|string
     */
    public function image(Request $request)
    {

        $image = $request['productImage'];
        if (isset($image)) {
            if (!Storage::disk('public')->exists('product')) {
                Storage::disk('public')->makeDirectory('product');
            }
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $result = $request->productImage->move(public_path('product'), $imageName);
            if ($result) {
                $response['status'] = 'success';
                $response['message'] = 'Successful to upload image';
                $response['url'] = $imageName;

            } else {
                $response['status'] = 'failed';
                $response['message'] = 'Unsuccessful to upload Product';
            }

        }else {
            $response['status'] = 'failed';
            $response['message'] = 'Unsuccessful to upload Product';
        }
        return json_encode($response);
    }
    public function status(Request $request)
    {
        $product = Product::find($request['id']);
        $product->status = $request['status'];
        $result = $product->save();
        if($result){
            $response['status'] = 'success';
            $response['message'] = 'Successfully Update Status to '.$request['status'];
        }else{
            $response['status'] = 'failed';
            $response['message'] = 'Unsuccessful to update Status '.$request['status'];
        }
        return json_encode($response);
    }

    public function productSync(Request $request)
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




}
