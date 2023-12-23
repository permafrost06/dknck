<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\StockItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StockItemController extends Controller
{
    public function items_api(Request $req)
    {
        $query = Stock::with('item')->selectRaw("
            item_code,
            SUM(IF(type='in', quantity, -quantity)) AS in_stock,
            SUM(IF(type='in', quantity, 0)) AS total_in,
            SUM(IF(type='out', quantity, 0)) AS total_out,
            (
                SUM(IF(type='out', quantity * unit_cost + adjustment, 0))
                -
                SUM(IF(type='in', quantity * unit_cost + adjustment, 0))
            ) AS profit
        ")->groupBy('item_code');
        

        $limit = (int)$req->query('limit', 10);
        $start = (int)$req->query('start', 0);
        $key = $req->query('search', '');
        if(strlen($key) > 1){
            $query->where('item_code', 'LIKE', "%$key%");
            $query->orWhereHas('item', fn($q)=>$q->where('remarks', 'LIKE', "%$key%"));
        }

        $order_by = match ($req->get('order_by')) {
            'total_in' => 'total_in',
            'total_out' => 'total_out',
            'in_stock' => 'in_stock',
            'profit' => 'profit',
            default => 'item_code'
        };

        $order = 'DESC';
        if ($req->get('order') === 'asc') {
            $order = 'asc';
        }
        return [
            'count' => $query->count(),
            'data' => $query->orderBy($order_by, $order)->limit($limit)->offset($start)->get()
        ];
    }


    public function index()
    {
        return view('admin.stocks.status');
    }

    public function store(Request $req)
    {

        $data = $req->validate([
            'item_code' => 'required|string',
            'remarks' => 'nullable|string',
            'attachment' => 'mimes:jpeg,png,pdf'
        ]);

        $item = StockItem::where('item_code', $data['item_code'])->first();

        if(isset($data['attachment'])){
            $attachment = $data['attachment'];
            $dir = "uploads/attachment";
            $public = config('filesystems.disks.public.root');
            if(!file_exists("$public/$dir") && !Storage::disk('public')->makeDirectory($dir)){
                throw new \Exception("Unable to create directory: $public/$dir");
            }
            
            $name = 'attachment_'.time().".{$attachment->extension()}";
            $attachment->storePubliclyAs('public/'.$dir, $name);
            $data['attachment'] = "/storage/$dir/$name";
        }

        if(!is_null($item)){
            if(isset($data['attachment']) && $item->attachment){
                Storage::delete(substr($item->attachment, 9));
            }
            $item->update($data);
            return $this->backToForm('Info updated successfully!');
        }else{
            StockItem::create($data);
            return $this->backToForm('Info added successfully!');
        }
    }

}
