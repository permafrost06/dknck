<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function form(Request $request, string|int $id = '')
    {
        $item = null;

        if (is_numeric($id)) {
            $item = Item::findOrFail($id);
        }

        return view('admin.items.form', compact('item'));
    }

    public function store(Request $request, int $id = 0)
    {
        $item = null;
        if ($id) {
            $item = Item::findOrFail($id);
        }

        $data = $request->validate([
            'name' => 'nullable|string',
            'vendor' => 'required|string',
            'unit_price_buying' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'date' => 'required|date_format:Y-m-d',
            'remarks' => 'required|string',
        ]);

        if ($item) {
            $item->update($data);
            return $this->backToForm('Item updated successfully!');
        } else {
            Item::create($data);
            return $this->backToForm('Item added successfully!');
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

        $q = Item::query();


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
        if (Item::destroy($id)){
            return ['message'=>'Deposit deleted successfully'];
        }
        return response(['message' => 'Unable to delete the deposit!'], 422);
    }
}
