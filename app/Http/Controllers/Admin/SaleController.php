<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{

    public function index() {
        return view('admin.sales.list');
    }
    public function form(Request $request, string|int $id = '')
    {
        $sale = null;

        if (is_numeric($id)) {
            $sale = Sale::findOrFail($id);
        }

        return view('admin.sales.form', compact('sale'));
    }

    public function store(Request $request, int $id = 0)
    {
        $sale = null;
        if ($id) {
            $sale = Sale::findOrFail($id);
        }


        $data = $request->validate([
            'product_id' => 'required|string',
            'quantity' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'date' => 'required|date_format:Y-m-d',
        ]);

        $data['product_id'] = preg_replace('/([^0-9]+)/', '', $data['product_id']);

        $product = Product::find($data['product_id']);


        if (!$product) {
            return $this->backToForm('The selected ID is invalid!', 'error');
        }
        if ($product->quantity < $data['quantity']) {
            return $this->backToForm('Not enough quantity!', 'error');
        }

        
        if ($sale) {

            if ($sale->product_id != $data['product_id']) {
                return $this->backToForm('Product id cannot be updated!', 'error');
            }

            $product->sold += $data['quantity'] - $sale->quantity;
            $product->quantity -= $data['quantity'];
            $product->quantity += $sale->quantity;

            $product->profit += ($data['quantity'] - $sale->quantity) * ($data['sale_price'] - $product->unit_price_buying);

            $sale->update($data);
            $product->save();
            return $this->backToForm('Sale updated successfully!');
        } else {
            $product->sold += $data['quantity'];
            $product->quantity-=$data['quantity'];
            $product->profit += $data['quantity'] * ($data['sale_price'] - $product->unit_price_buying);

            Sale::create($data);
            $product->save();
            return $this->backToForm('Sale added successfully!');
        }
    }

    
    public function api(Request $req)
    {
        $start = (int) $req->get('start', 0);
        $limit = (int) $req->get('limit', 10);
        $order_by = match ($req->get('order_by')) {
            // 'name' => 'products.name',
            // 'date' => 'products.date',
            // 'vendor' => 'products.vendor',
            // 'price' => 'products.unit_price_buying',
            // 'sold' => 'products.sold',
            'quantity' => 'quantity',
            'sale_price' => 'sale_price',
            'profit' => 'products.profit',
            default => 'id'
        };

        $order = 'DESC';
        if ($req->get('order') === 'asc') {
            $order = 'asc';
        }

        $search = $req->get('search', '');

        $q = Sale::with('product');


        if ($search) {
            $search = '%' . $search . '%';
            $q->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'LIKE', $search);
                $q->orWhere('vendor', 'LIKE', $search);
                $q->orWhere('remarks', 'LIKE', $search);
            });
        }

        return [
            'count' => $q->count(),
            'data' => $q->orderBy($order_by, $order)->offset($start)->limit($limit)->get()
        ];

    }

    public function delete(int $id)
    {
        if (Sale::destroy($id)){
            return ['message'=>'Deposit deleted successfully'];
        }
        return response(['message' => 'Unable to delete the deposit!'], 422);
    }
}
