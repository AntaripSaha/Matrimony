<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use Redirect;
use App\Order;
use App\Seller;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Input;
use App\CustomerPackage;
use App\SellerPackage;
use App\Http\Controllers\CustomerPackageController;
use Auth;

class RazorpayController extends Controller
{
    public function pay($request)
    {
        if(Session::has('payment_type')){
            if (Session::get('payment_type') == 'package_payment') {
                return view('frontend.payment_gateway.razorpay');
            }
        }
    }

    public function payment(Request $request)
    {
        //Input items of form
        $input = $request->all();
        //get API Configuration
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        //Fetch payment information by razorpay_payment_id
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            $payment_detalis = null;
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));
                $payment_detalis = json_encode(array('id' => $response['id'],'method' => $response['method'],'amount' => $response['amount'],'currency' => $response['currency']));
            } catch (\Exception $e) {
                return  $e->getMessage();
                \Session::put('error',$e->getMessage());
                return redirect()->back();
            }

            // Do something here for store payment details in database...
            if(Session::has('payment_type')){
                if (Session::get('payment_type') == 'package_payment') {
                    $packagePaymentController = new PackagePaymentController;
                    return $packagePaymentController->package_payment_done(Session::get('payment_data'), $payment_detalis);
                }
            }
        }
    }
}
