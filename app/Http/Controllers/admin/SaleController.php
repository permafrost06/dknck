<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
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
            'item_id' => 'required|numeric',
            'quantity' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
        ]);

        $item = Item::find($data['item_id']);


        if (!$item) {
            return $this->backToForm('The selected ID is invalid!', 'error');
        }
        if ($item->quantity < $data['quantity']) {
            return $this->backToForm('Not enough quantity!', 'error');
        }

        
        if ($sale) {

            if ($sale->item_id != $data['item_id']) {
                return $this->backToForm('Product id cannot be updated!', 'error');
            }

            $item->sold += $data['quantity'] - $sale->quantity;
            $item->quantity -= $data['quantity'];
            $item->quantity += $sale->quantity;

            $item->profit += ($data['quantity'] - $sale->quantity) * ($data['sale_price'] - $item->unit_price_buying);

            $sale->update($data);
            $item->save();
            return $this->backToForm('Sale updated successfully!');
        } else {
            $item->sold += $data['quantity'];
            $item->quantity-=$data['quantity'];
            $item->profit += $data['quantity'] * ($data['sale_price'] - $item->unit_price_buying);

            Sale::create($data);
            $item->save();
            return $this->backToForm('Sale added successfully!');
        }
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

        $q = Sale::query();


        if ($search) {
            $search = '%' . $search . '%';
            $q->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', $search);
                $q->orWhere('vendor', 'LIKE', $search);
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
