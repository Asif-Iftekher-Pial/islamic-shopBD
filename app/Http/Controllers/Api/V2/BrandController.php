<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\BrandCollection;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        return new BrandCollection(Brand::all());
    }

    public function top()
    {
        return new BrandCollection(Brand::where('top', 1)->get());
    }
}
