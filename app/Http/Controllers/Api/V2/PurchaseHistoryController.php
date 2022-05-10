<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\PurchaseHistoryCollection;
use App\Models\Order;

class PurchaseHistoryController extends Controller
{
    public function index($id)
    {
        return new PurchaseHistoryCollection(Order::where('user_id', $id)->latest()->get());
    }
}
