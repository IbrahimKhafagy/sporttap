<?php


namespace App\Http\Controllers\admin\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Show the view for customers.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('apps-ecommerce-customers');
    }
}
