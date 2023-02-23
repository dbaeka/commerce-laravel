<?php

namespace App\Http\Controllers;

/**
 * @class CheckoutController
 */
class CheckoutController extends Controller
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('checkout.index');
    }
}
