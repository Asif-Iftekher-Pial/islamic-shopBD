<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\User;
use App\Order;
use App\Coupon;
use App\Address;
use App\Category;
use App\CouponUsage;
use App\Transaction;
use App\BusinessSetting;
use App\CommissionHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\ClubPointController;
use App\Http\Controllers\ShurjoPayController;
use App\Http\Controllers\PublicSslCommerzPaymentController;

class CheckoutController extends Controller
{

    public function __construct()
    {
        //
    }

    //check the selected payment gateway and redirect to that controller accordingly
    public function checkout(Request $request)
    {
        if ($request->payment_option != null) {

            $orderController = new OrderController;
            $orderController->store($request);

            $request->session()->put('payment_type', 'cart_payment');

            if ($request->session()->get('order_id') != null) {
                if ($request->payment_type && $request->payment_type == 'partial') {
                    if ($request->payment_option == 'sslcommerz') {
                        $sslcommerz = new PublicSslCommerzPaymentController;
                        return $sslcommerz->index($request, $request->amount);
                    } else if ($request->payment_option == 'shurjopay') {
                        $shurjopay = new ShurjoPayController;
                        return $shurjopay->index($request, $request->amount);
                    } else if ($request->payment_option == 'nagad') {
                        $nagad = new NagadController;
                        return $nagad->getSession($request->amount);
                    } else if ($request->payment_option == 'bkash') {
                        $bkash = new BkashController;
                        return $bkash->pay($request->amount);
                    } else {
                        return redirect()->back();
                    }
                } else {
                    if ($request->payment_option == 'sslcommerz') {
                        $order = Order::findOrFail($request->session()->get('order_id'));
                        $sslcommerz = new PublicSslCommerzPaymentController;
                        return $sslcommerz->index($request, $order->grand_total);
                    } else if ($request->payment_option == 'shurjopay') {
                        $order = Order::findOrFail($request->session()->get('order_id'));
                        $shurjopay = new ShurjoPayController;
                        return $shurjopay->index($request, $order->grand_total);
                    } else if ($request->payment_option == 'nagad') {
                        $order = Order::findOrFail($request->session()->get('order_id'));
                        $nagad = new NagadController;
                        return $nagad->getSession($order->grand_total);
                    } else if ($request->payment_option == 'bkash') {
                        $order = Order::findOrFail($request->session()->get('order_id'));
                        $bkash = new BkashController;
                        return $bkash->pay($order->grand_total);
                    } elseif ($request->payment_option == 'cash_on_delivery') {
                        $request->session()->put('cart', Session::get('cart')->where('owner_id', '!=', Session::get('owner_id')));
                        $request->session()->forget('owner_id');
                        $request->session()->forget('delivery_info');
                        $request->session()->forget('coupon_id');
                        $request->session()->forget('coupon_discount');
                        $request->session()->forget('club_point');
    
                        flash(translate("Your order has been placed successfully"))->success();
                        return redirect()->route('order_confirmed');
                    } elseif ($request->payment_option == 'wallet') {
                        $user = Auth::user();
                        $order = Order::findOrFail($request->session()->get('order_id'));
                        if ($user->balance >= $order->grand_total) {
                            $user->balance -= $order->grand_total;
                            $user->save();
                            return $this->checkout_done($request->session()->get('order_id'), null);
                        }
                    } else {
                        $order = Order::findOrFail($request->session()->get('order_id'));
                        $order->manual_payment = 1;
                        $order->save();
    
                        $request->session()->put('cart', Session::get('cart')->where('owner_id', '!=', Session::get('owner_id')));
                        $request->session()->forget('owner_id');
                        $request->session()->forget('delivery_info');
                        $request->session()->forget('coupon_id');
                        $request->session()->forget('coupon_discount');
                        $request->session()->forget('club_point');
    
                        flash(translate('Your order has been placed successfully. Please submit payment information from purchase history'))->success();
                        return redirect()->route('order_confirmed');
                    }
                }
                
            }
        } else {
            flash(translate('Select Payment Option.'))->warning();
            return back();
        }
    }

    //redirects to this method after a successfull checkout
    public function checkout_done($order_id, $payment, $amount = null, $gateway = null)
    {
        $order = Order::findOrFail($order_id);
        $transaction = new Transaction;
        $transaction->order_id  = $order->id;
        $transaction->amount  = $amount;
        $transaction->payment_type  = $gateway;
        $transaction->save();

        $order->payment_status = $order->grand_total <= $amount ? 'paid' : 'partial';
        $order->payment_details = $payment;
        $order->save();

        if ($order->grand_total <= $amount) {
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
    //                    $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->price * (100 - $commission_percentage)) / 100 + $orderDetail->tax + $orderDetail->shipping_cost;
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
                
    //            if (BusinessSetting::where('type', 'category_wise_commission')->first()->value != 1) {
    //                $commission_percentage = BusinessSetting::where('type', 'vendor_commission')->first()->value;
    //                foreach ($order->orderDetails as $key => $orderDetail) {
    //                    
    //                    if ($orderDetail->product->user->user_type == 'seller') {
    //                        $seller = $orderDetail->product->user->seller;
    //                        $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->price * (100 - $commission_percentage)) / 100 + $orderDetail->tax + $orderDetail->shipping_cost;
    //                        $seller->save();
    //                    }
    //                }
    //            } else {
    //                foreach ($order->orderDetails as $key => $orderDetail) {
    //                    $orderDetail->payment_status = 'paid';
    //                    $orderDetail->save();
    //                    if ($orderDetail->product->user->user_type == 'seller') {
    //                        $commission_percentage = $orderDetail->product->category->commision_rate;
    //                        $seller = $orderDetail->product->user->seller;
    //                        $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->price * (100 - $commission_percentage)) / 100 + $orderDetail->tax + $orderDetail->shipping_cost;
    //                        $seller->save();
    //                    }
    //                }
    //            }
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


        flash(translate('Payment completed'))->success();
        return view('frontend.order_confirmed', compact('order'));
    }

    public function get_shipping_info(Request $request)
    {
        if (Session::has('cart') && count(Session::get('cart')) > 0) {
            $categories = Category::all();
            return view('frontend.shipping_info', compact('categories'));
        }
        flash(translate('Your cart is empty'))->success();
        return back();
    }

    public function store_shipping_info(Request $request)
    {
        if (Auth::check()) {
            if ($request->address_id == null) {
                flash(translate("Please add shipping address"))->warning();
                return back();
            }
            $address = Address::findOrFail($request->address_id);
            $data['name'] = Auth::user()->name;
            $data['email'] = Auth::user()->email;
            $data['address'] = $address->address;
            $data['country'] = $address->country;
            $data['city'] = $address->city;
            $data['ccity'] = $address->ccity;
            $data['postal_code'] = $address->postal_code;
            $data['phone'] = $address->phone;
            $data['checkout_type'] = $request->checkout_type;
        } else {
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['address'] = $request->address;
            $data['country'] = $request->country;
            $data['city'] = $request->city;
            $data['ccity'] = $request->ccity;
            $data['postal_code'] = $request->postal_code;
            $data['phone'] = $request->phone;
            $data['checkout_type'] = $request->checkout_type;
        }

        $shipping_info = $data;
        $request->session()->put('shipping_info', $shipping_info);

        $subtotal = 0;
        $tax = 0;
        $shipping = 0;
        foreach (Session::get('cart') as $key => $cartItem) {
            $subtotal += $cartItem['price'] * $cartItem['quantity'];
            $tax += $cartItem['tax'] * $cartItem['quantity'];
            
            if(isset($cartItem['shipping']) && is_array(json_decode($cartItem['shipping'], true))) {
                foreach(json_decode($cartItem['shipping'], true) as $shipping_region => $val) {
                    if($shipping_info['city'] == $shipping_region) {
                        $shipping += (double)($val) * $cartItem['quantity'];
                    }
                }
            } else {
                if (!$cartItem['shipping']) {
                    $shipping += 0;
                }
//                $shipping += $cartItem['shipping'] * $cartItem['quantity'];

            }
        }

        $total = $subtotal + $tax + $shipping;

        if (Session::has('coupon_discount')) {
            $total -= Session::get('coupon_discount');
        }

        return view('frontend.delivery_info');
        // return view('frontend.payment_select', compact('total'));
    }

    public function store_delivery_info(Request $request)
    {
        // clone from store_shipping_info
        if (Auth::check()) {
            if ($request->address_id == null) {
                flash(translate("Please add shipping address"))->warning();
                return back();
            }
            $address = Address::findOrFail($request->address_id);
            $data['name'] = Auth::user()->name;
            $data['email'] = Auth::user()->email;
            $data['address'] = $address->address;
            $data['country'] = $address->country;
            $data['city'] = $address->city;
            $data['ccity'] = $address->ccity;
            $data['postal_code'] = $address->postal_code;
            $data['phone'] = $address->phone;
            $data['checkout_type'] = $request->checkout_type;
        } else {
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['address'] = $request->address;
            $data['country'] = $request->country;
            $data['city'] = $request->city;
            $data['postal_code'] = $request->postal_code;
            $data['phone'] = $request->phone;
            $data['checkout_type'] = $request->checkout_type;
        }

        $shipping_info = $data;
        $request->session()->put('shipping_info', $shipping_info);

        $request->session()->put('owner_id', $request->owner_id);

        if (Session::has('cart') && count(Session::get('cart')) > 0) {
            $cart = $request->session()->get('cart', collect([]));
            $cart = $cart->map(function ($object, $key) use ($request) {
                if (\App\Product::find($object['id'])->user_id == $request->owner_id) {
                    if ($request['shipping_type_' . $request->owner_id] == 'pickup_point') {
                        $object['shipping_type'] = 'pickup_point';
                        $object['pickup_point'] = $request['pickup_point_id_' . $request->owner_id];
                    } else {
                        $object['shipping_type'] = 'home_delivery';
                    }
                }
                return $object;
            });

            $request->session()->put('cart', $cart);

            $cart = $cart->map(function ($object, $key) use ($request) {
                if (\App\Product::find($object['id'])->user_id == $request->owner_id) {
                    if ($object['shipping_type'] == 'home_delivery') {
                        $object['shipping'] = getShippingCost($key);
                    }
                    else {
                        $object['shipping'] = 0;
                    }
                } else {
                    $object['shipping'] = 0;
                }
                return $object;
            });

            $request->session()->put('cart', $cart);
            // $shipping_info = $request->session()->get('shipping_info');
            $subtotal = 0;
            $tax = 0;
            $shipping = 0;
            
            foreach (Session::get('cart') as $key => $cartItem) {
                $subtotal += $cartItem['price'] * $cartItem['quantity'];
                $tax += $cartItem['tax'] * $cartItem['quantity'];
                if(isset($cartItem['shipping']) && is_array(json_decode($cartItem['shipping'], true))) {
                    foreach(json_decode($cartItem['shipping'], true) as $shipping_region => $val) {
                        if($shipping_info['city'] == $shipping_region) {
                            $shipping += (double)($val) * $cartItem['quantity'];
                        }
                    }
                } else {
                    if (!$cartItem['shipping']) {
                        $shipping += 0;
                    }
                }
                
            }

            $total = $subtotal + $tax + $shipping;

            if (Session::has('coupon_discount')) {
                $total -= Session::get('coupon_discount');
            }

            return view('frontend.payment_select', compact('total', 'shipping_info'));
        } else {
            flash(translate('Your Cart was empty'))->warning();
            return redirect()->route('home');
        }
    }

    public function get_payment_info(Request $request)
    {
        $subtotal = 0;
        $tax = 0;
        $shipping = 0;
        $shipping_info = $request->session()->get('shipping_info');
        foreach (Session::get('cart') as $key => $cartItem) {
            $subtotal += $cartItem['price'] * $cartItem['quantity'];
            $tax += $cartItem['tax'] * $cartItem['quantity'];
            if(isset($cartItem['shipping']) && is_array(json_decode($cartItem['shipping'], true))) {
                foreach(json_decode($cartItem['shipping'], true) as $shipping_region => $val) {
                    if($shipping_info['city'] == $shipping_region) {
                        $shipping += (double)($val) * $cartItem['quantity'];
                    }
                }
            } else {
                if (!$cartItem['shipping']) {
                    $shipping += 0;
                }
            }
        }

        $total = $subtotal + $tax + $shipping;

        if(Session::has('club_point')) {
            $total -= Session::get('club_point');
        }

        if (Session::has('coupon_discount')) {
            $total -= Session::get('coupon_discount');
        }

        return view('frontend.payment_select', compact('total', 'shipping_info', 'subtotal', 'shipping', 'tax'));
    }

    public function apply_coupon_code(Request $request)
    {
        //dd($request->all());
        $coupon = Coupon::where('code', $request->code)->first();

        if ($coupon != null) {
            if (strtotime(date('d-m-Y')) >= $coupon->start_date && strtotime(date('d-m-Y')) <= $coupon->end_date) {
                if (CouponUsage::where('user_id', Auth::user()->id)->where('coupon_id', $coupon->id)->first() == null) {
                    $coupon_details = json_decode($coupon->details);

                    if ($coupon->type == 'cart_base') {
                        $subtotal = 0;
                        $tax = 0;
                        $shipping = 0;
                        foreach (Session::get('cart') as $key => $cartItem) {
                            $subtotal += $cartItem['price'] * $cartItem['quantity'];
                            $tax += $cartItem['tax'] * $cartItem['quantity'];
                            $shipping += $cartItem['shipping'] * $cartItem['quantity'];
                        }
                        $sum = $subtotal + $tax + $shipping;

                        if ($sum >= $coupon_details->min_buy) {
                            if ($coupon->discount_type == 'percent') {
                                $coupon_discount = ($sum * $coupon->discount) / 100;
                                if ($coupon_discount > $coupon_details->max_discount) {
                                    $coupon_discount = $coupon_details->max_discount;
                                }
                            } elseif ($coupon->discount_type == 'amount') {
                                $coupon_discount = $coupon->discount;
                            }
                            $request->session()->put('coupon_id', $coupon->id);
                            $request->session()->put('coupon_discount', $coupon_discount);
                            flash(translate('Coupon has been applied'))->success();
                        }
                    } elseif ($coupon->type == 'product_base') {
                        $coupon_discount = 0;
                        foreach (Session::get('cart') as $key => $cartItem) {
                            foreach ($coupon_details as $key => $coupon_detail) {
                                if ($coupon_detail->product_id == $cartItem['id']) {
                                    if ($coupon->discount_type == 'percent') {
                                        $coupon_discount += $cartItem['price'] * $coupon->discount / 100;
                                    } elseif ($coupon->discount_type == 'amount') {
                                        $coupon_discount += $coupon->discount;
                                    }
                                }
                            }
                        }
                        $request->session()->put('coupon_id', $coupon->id);
                        $request->session()->put('coupon_discount', $coupon_discount);
                        flash(translate('Coupon has been applied'))->success();
                    }
                } else {
                    flash(translate('You already used this coupon!'))->warning();
                }
            } else {
                flash(translate('Coupon expired!'))->warning();
            }
        } else {
            flash(translate('Invalid coupon!'))->warning();
        }
        return back();
    }

    public function remove_coupon_code(Request $request)
    {
        $request->session()->forget('coupon_id');
        $request->session()->forget('coupon_discount');
        return back();
    }
    
    public function apply_club_point(Request $request) {
        if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && 
                \App\Addon::where('unique_identifier', 'club_point')->first()->activated){
            
            $point = $request->point;
            
//            if(Auth::user()->club_point->points >= $point) {
            if(Auth::user()->point_balance >= $point) {
                $request->session()->put('club_point', $point);
                flash(translate('Point has been redeemed'))->success();
            }
            else {
                flash(translate('Invalid point!'))->warning();
            }
        }
        return back();
    }
    
    public function remove_club_point(Request $request) {
        $request->session()->forget('club_point');
        return back();
    }

    public function order_confirmed()
    {
        $order = Order::findOrFail(Session::get('order_id'));
        return view('frontend.order_confirmed', compact('order'));
    }
}
