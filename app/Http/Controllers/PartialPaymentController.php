<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AffiliateController;
use App\Order;
use App\Category;
use App\BusinessSetting;
use App\Coupon;
use App\CouponUsage;
use App\User;
use App\Wallet;
use Session;
use Auth;

class PartialPaymentController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show_payment_modal(Request $request)
    {
        $order = Order::find($request->order_id);
        if($order != null){
            return view('frontend.user.partial_payment_modal', compact('order'));
        }
        retrun;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submit_partial_payment(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $request->session()->put('payment_type', 'partial');
        $request->session()->put('order_id', $request->order_id);

        if ($request->payment_option == 'sslcommerz') {
            $sslcommerz = new PublicSslCommerzPaymentController;
            return $sslcommerz->index($request, $request->amount);
        } else if ($request->payment_option == 'nagad') {
            $nagad = new NagadController;
            return $nagad->getSession($request->amount);
        } else if ($request->payment_option == 'bkash') {
            $bkash = new BkashController;
            return $bkash->pay($request->amount);
        } else {
            return redirect()->back();
        }

        return redirect()->route('home');
    }

    public function partial_payment_done($order_id, $payment, $amount, $gateway = null)
    {
        $order = Order::findOrFail($order_id);
        $transaction = new Transaction;
        $transaction->order_id  = $order->id;
        $transaction->amount  = $amount;
        $transaction->payment_type  = $gateway;
        $transaction->save();

        $order->payment_status = $order->grand_total <= $order->transactions->sum('amount') ? 'paid' : 'partial';
        $order->payment_type = $gateway;
        $order->save();

        if ($order->grand_total < $order->transactions->sum('amount')) {
            $user = Auth::user();
            $user->balance += ($order->transactions->sum('amount') - $order->grand_total);
            $user->save();

            $wallet = new Wallet;
            $wallet->user_id = $user->id;
            $wallet->amount = $order->transactions->sum('amount') - $order->grand_total;
            $wallet->payment_method = 'Partial';
            $wallet->payment_details = 'Partial payment from order ID-'.$order->id;
            $wallet->save();
        }

        if ($order->payment_status == 'paid') {
            if (\App\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated) {
                $affiliateController = new AffiliateController;
                $affiliateController->processAffiliatePoints($order);
            }
    
            if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated) {
                if (Auth::check()) {
                    $clubpointController = new ClubPointController;
                    $clubpointController->processClubPoints($order);
                }
            }
            if (\App\Addon::where('unique_identifier', 'seller_subscription')->first() == null || 
                    !\App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated) {
                
                foreach ($order->orderDetails as $key => $orderDetail) {
                    $orderDetail->payment_status = 'paid';
                    $orderDetail->save();
                    $commission_percentage = 0;
                    
                    if (get_setting('category_wise_commission') != 1) {
                        $commission_percentage = get_setting('vendor_commission');
                    } else if ($orderDetail->product->user->user_type == 'seller') {
                        $commission_percentage = $orderDetail->product->category->commision_rate;
                    }
                    
                    if ($orderDetail->product->user->user_type == 'seller') {
                        $seller = $orderDetail->product->user->seller;
                        $admin_commission = ($orderDetail->price * $commission_percentage)/100;
                        
                        if (get_setting('product_manage_by_admin') == 1) {
                            $seller_earning = ($orderDetail->tax + $orderDetail->price) - $admin_commission;
                            $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->tax + $orderDetail->price) - $admin_commission;
                        } else {
                            $seller_earning = $orderDetail->tax + $orderDetail->shipping_cost + $orderDetail->price - $admin_commission;
                            $seller->admin_to_pay = $seller->admin_to_pay - $admin_commission;
                        }
    
                        $seller->save();
    
                        $commission_history = new CommissionHistory;
                        $commission_history->order_id = $order->id;
                        $commission_history->order_detail_id = $orderDetail->id;
                        $commission_history->seller_id = $orderDetail->seller_id;
                        $commission_history->admin_commission = $admin_commission;
                        $commission_history->seller_earning = $seller_earning;
    
                        $commission_history->save();
                    }
                    
                }
            } else {
                foreach ($order->orderDetails as $key => $orderDetail) {
                    $orderDetail->payment_status = 'paid';
                    $orderDetail->save();
                    if ($orderDetail->product->user->user_type == 'seller') {
                        $seller = $orderDetail->product->user->seller;
                        $seller->admin_to_pay = $seller->admin_to_pay + $orderDetail->price + $orderDetail->tax + $orderDetail->shipping_cost;
                        $seller->save();
                    }
                }
            }
    
            $order->commission_calculated = 1;
            $order->save();
        }

        if (Session::has('cart')) {
            Session::put('cart', Session::get('cart')->where('owner_id', '!=', Session::get('owner_id')));
        }
        Session::forget('owner_id');
        Session::forget('payment_type');
        Session::forget('delivery_info');
        Session::forget('coupon_id');
        Session::forget('coupon_discount');
        Session::forget('club_point');

        flash(translate('Partial Payment completed'))->success();
        return redirect('/purchase_history');
    }
}
