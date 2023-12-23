<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vendor;

class VendorController extends Controller
{
    public function index()
    {
        return view('admin.vendors.index');
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

        $q = Vendor::withSum('purchases', 'goods_of_issues')
            ->withSum('purchases', 'paid_money');

        if ($search) {
            $q->where('name', 'LIKE', '%'.$search.'%');
            $q->orWhere('address', 'LIKE', '%'.$search.'%');
        }

        return [
            'count' => $q->count(),
            'data' => $q->orderBy($order_by, $order)->offset($start)->limit($limit)->get()
        ];
    }

    public function form(string | int $id)
    {
        $vendor  = null;
        if (is_numeric($id)) {
            $vendor = Vendor::findOrfail($id);
        }

        return view('admin.vendors.form', compact('vendor'));
    }
   
    public function store(Request $request, int $id = 0)
    {
        $vendor = null;

        if ($id) {
            $vendor = Vendor::findOrFail($id);
        }

        $data = $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'limit' => 'required|string',
            'type' => 'nullable|string'
        ]);

        if ($vendor) {
            $vendor->update($data);
            return $this->backToForm('Vendor updated successfully!');
        } else {
            Vendor::create($data);
            return $this->backToForm('Vendor added successfully!');
        }
    }

    public function delete(Request $request, int $id)
    {
        if (Vendor::destroy($id)){
            return ['message'=>'Vendor deleted successfully'];
        }
        return response(['message' => 'Unable to delete vendor!'], 422);
    }
}
