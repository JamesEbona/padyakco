<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;


class CartController extends Controller
{

    public function index()
    {
        return view('home.cart');
    }

    public function store()
    {
        return view('home.cart');
    }

}

//CART SESSION: 