<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        $customers = Customer::count();
        $deposits =DB::table('sales')->where('created_at','>=',Carbon::today())->count();
		$lv =DB::select("select (sum(lv)) as lv from sales");
        $customerDueBalance =DB::select("select (sum(goods_of_issues)-sum(received_money)) as customerDue from sales");
        $vendorDueBalance =DB::select("select (sum(goods_of_issues)-sum(paid_money)) as vendorsDue from purchases");

        return view('admin.index',[
            'totalCustomers'=>$customers,
            'deposits'=>$deposits,
            'lv'=>$lv[0]->lv,
            'customersDue'=>$customerDueBalance[0]->customerDue,
            'vendorsDue'=>$vendorDueBalance[0]->vendorsDue
        ]);
    }

    public function ThousandMillion($price)
    {

        $thousands = $price % 1000000;

        $millions = ($price - $thousands)/1000000;

        $thousands = $thousands / 1000;
        if ($price>=1000000){
            return number_format($millions,2)." M";
        }
        else return number_format($thousands,2) .' K';
    }
}
