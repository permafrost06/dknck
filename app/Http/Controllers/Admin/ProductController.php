<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function stock(Request $request, string|int $id = '')
    {
        return view('admin.products.stock');
    }

    public function form(Request $request, string|int $id = '')
    {
        $product = null;

        if (is_numeric($id)) {
            $product = Product::findOrFail($id);
        }

        return view('admin.products.form', compact('product'));
    }

    public function store(Request $request, int $id = 0)
    {
        $product = null;
        if ($id) {
            $product = Product::findOrFail($id);
        }

        $data = $request->validate([
            'name' => 'nullable|string',
            'vendor' => 'required|string',
            'unit_price_buying' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'date' => 'required|date_format:Y-m-d',
            'remarks' => 'nullable|string',
        ]);

        $print_layout = Setting::where('name', 'print_layout')->first()?->value;
        if (!$print_layout) {
            return $this->backToForm('Please add a print layout first!', 'error');
        }

        if ($product) {
            $product->update($data);
            $msg = 'Product updated successfully!';
        } else {
            $product = Product::create($data);
            $msg = 'Product added successfully!';
        }

        foreach ($product->getAttributes() as $key => $value) {
            $print_layout = str_replace("::" . strtoupper($key) . "::", $value, $print_layout);
        }

        return $this->backToForm($msg)->with('print_layout', $print_layout);
    }


    public function api(Request $req)
    {
        $start = (int) $req->get('start', 0);
        $limit = (int) $req->get('limit', 10);
        $order_by = match ($req->get('order_by')) {
            'name' => 'name',
            'date' => 'date',
            'vendor' => 'vendor',
            'price' => 'unit_price_buying',
            'quantity' => 'quantity',
            'sold' => 'sold',
            'profit' => 'profit',
            default => 'id'
        };

        $order = 'DESC';
        if ($req->get('order') === 'asc') {
            $order = 'asc';
        }

        $search = $req->get('search', '');

        $q = Product::query();


        if ($search) {
            $search = '%' . $search . '%';
            $q->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', $search);
                $q->orWhere('vendor', 'LIKE', $search);
            });
        }

        if ($req->get('stock')) {
            $q->where('quantity', '>', 0);
        }

        return [
            'count' => $q->count(),
            'data' => $q->orderBy($order_by, $order)->offset($start)->limit($limit)->get()
        ];

    }

    public function infoApi(Request $req, int $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return [
                "product" => null
            ];
        }
        return [
            "product" => $product
        ];
    }

    public function delete(int $id)
    {
        if (Product::destroy($id)) {
            return ['message' => 'Deposit deleted successfully'];
        }
        return response(['message' => 'Unable to delete the deposit!'], 422);
    }
}
