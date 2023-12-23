<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{

    public function logs(?string $item = null)
    {
        return view('admin.stocks.logs', compact('item'));
    }

    public function logs_api(Request $req, ?string $item = null){
        $query = Stock::selectRaw('*, (unit_cost * quantity + adjustment) AS total_cost');
        if(!is_null($item)){
            $query->where('item_code', $item);
        }

        $limit = (int)$req->query('limit', 10);
        $start = (int)$req->query('start', 0);
        $order_by = match ($req->get('order_by')) {
            'item_code' => 'item_code',
            'brand' => 'brand',
            'quantity' => 'quantity',
            'unit_cost' => 'unit_cost',
            'adjustment' => 'adjustment',
            'merchant_name' => 'merchant_name',
            'carrier_name' => 'carrier_name',
            'date_time' => 'date_time',
            'border' => 'border',
            'total_cost' => DB::raw('unit_cost * quantity + adjustment'),
            default => 'id'
        };

        $order = 'DESC';
        if ($req->get('order') === 'asc') {
            $order = 'asc';
        }

        $search = $req->get('search', '');

        if($search){
            $search = "%$search%";
            $query->where(function($q) use ($search){
                $q->where('item_code', 'LIKE', $search);
                $q->orWhere('brand', 'LIKE', $search);
                $q->orWhere('merchant_name', 'LIKE', $search);
                $q->orWhere('carrier_name', 'LIKE', $search);
                $q->orWhere('border', 'LIKE', $search);
                $q->orWhere('remarks', 'LIKE', $search);
            });
        }

        return [
            'count' => $query->count(),
            'data' => $query->orderBy($order_by, $order)->offset($start)->limit($limit)->get()
        ];
    }

    public function form(Request $req, ?string $stock = null)
    {
        $cols = 'item_code, brand, merchant_name, merchant_contact, carrier_name, carrier_contact, border';
        $suggetions = Stock::with('item')->selectRaw($cols)
            ->groupByRaw($cols)->get();
        if(is_numeric($stock)){
            $stock = Stock::findOrFail($stock);
        }else{
            $stock= null;
        }

        $data = compact('stock');

        $uniques = [];
        $colsArr = explode(', ',  $cols);
        foreach($colsArr as $k){
            $uniques[$k] = [];
        }

        foreach ($suggetions as $stock) {
            foreach($stock->getAttributes() as $k=>$v){
                if(!isset($uniques[$k][$v])){
                    $uniques[$k][$v] = true;
                }
            }
        }

        foreach ($colsArr as $col) {
            $data[$col.'s'] = array_keys($uniques[$col]);
        }
        

        return view('admin.stocks.form', $data);
    }

    public function store(Request $req, ?string $stock = null)
    {

        if($req->has('date_time')){
            $req->merge([
                'date_time' => str_replace('T', ' ', $req->get('date_time').':00')
            ]);
        }

        $data = $req->validate([
            'type' => 'required|in:in,out',
            'item_code' => 'required|string',
            'date_time' => 'required|date_format:Y-m-d H:i:s',
            'brand' => 'required|string',
            'quantity' => 'required|numeric|min:1',
            'unit_cost' => 'required|numeric|min:0',
            'adjustment' => 'required|numeric',
            'merchant_name' => 'nullable|string',
            'merchant_contact' => 'nullable|string',
            'carrier_name' => 'nullable|string',
            'carrier_contact' => 'nullable|string',
            'border' => 'nullable|string',
            'remarks' => 'nullable|string',
            'attachment' => 'mimes:jpeg,png,pdf'
        ]);

        if($data['type'] == 'out'){
            $available = Stock::where('item_code', $data['item_code'])->sum(DB::raw('IF(type=\'in\', quantity, -quantity)'));
            if($available < $data['quantity']){
                $vr = Validator::make([], [
                    'quantity' => 'required'
                ], [
                    'quantity' => "Out quantity ({$data['quantity']}) cannot be higher than available quantity ($available) for Item Code {$data['item_code']}"
                ]);
                $vr->validate();
            }
        }

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

        if(is_numeric($stock)){
            $stock = Stock::findOrFail($stock);
            if(isset($data['attachment']) && $stock->attachment){
                Storage::delete(substr($stock->attachment, 9));
            }
            $stock->update($data);
            return $this->backToForm('Stock updated successfully!');
        }else{
            Stock::create($data);
            return $this->backToForm('Stock added successfully!');
        }
    }

    public function destroy(Stock $stock)
    {
        if($stock->attachment){
            Storage::delete(substr($stock->attachment, 9));
        }
        $stock->delete();
        return ['message' => 'Stock deleted successfully!'];
    }
}
