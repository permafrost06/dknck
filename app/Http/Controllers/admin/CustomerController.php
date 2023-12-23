<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        return view('admin.customers.index');
    }

    public function api(Request $req)
    {
        $start = (int) $req->get('start', 0);
        $limit = (int) $req->get('limit', 10);
        $order_by = match($req->get('order_by')){
            'name' => 'name',
            'address' => 'address',
            // 'balance' => 'balance_due',
            default => 'id'
        };

        $order = 'DESC';
        if ($req->get('order') === 'asc') {
            $order = 'asc';
        }

        $search = $req->get('search', '');

        $q = Customer::withSum('sales', 'goods_of_issues')
            ->withSum('sales', 'received_money');

        if ($search) {
            $q->where('name', 'LIKE', '%'.$search.'%');
            $q->orWhere('address', 'LIKE', '%'.$search.'%');
        }

        return [
            'count' => $q->count(),
            'data' => $q->orderBy($order_by, $order)->offset($start)->limit($limit)->get()
        ];
    }

    public function form(string|int $id = '')
    {
        $customer = null;

        if (is_numeric($id)) {
            $customer = Customer::findOrFail($id);
        }

        return view('admin.customers.form', compact('customer'));
    }

    public function store(Request $request, int $id = 0)
    {

        $customer = null;

        if ($id) {
            $customer = Customer::findOrFail($id);
        }

        $data = $request->validate([
            'customers_id' => 'required|string',
            'name' => 'required|string|min:3',
            'address' => 'required|string|min:3',
            'limit' => 'required|numeric|min:0',
            'type' => 'required|string'
        ]);

        if ($customer) {
            $customer->update($data);
            return $this->backToForm('Customer updated successfully!');
        } else {
            Customer::create($data);
            return $this->backToForm('Customer added successfully!');
        }
    }

    public function delete(Request $request, int $id)
    {
        if (Customer::destroy($id)) {
            return ['message' => 'Customer deleted successfully'];
        }
        return response(['message' => 'Unable to delete customer!'], 422);
    }
}