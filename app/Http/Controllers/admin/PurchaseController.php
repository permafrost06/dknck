<?php

namespace App\Http\Controllers\admin;

use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function form(Request $request, string | int $id = '')
    {
        $purchase = null;

        if (is_numeric($id)) {
            $purchase = Purchase::findOrFail($id);
        }

        $vendors = Vendor::all();

        return view('admin.purchase.form', compact('purchase', 'vendors'));
    }
    public function index(Request $request, int $id = 0)
    {
        $vendor = null;
        $details = null;
        $total_due = 0;

        if ($id) {
            $vendor = Vendor::findOrFail($id);
            $details = Purchase::select(
                DB::raw("
                    SUM(goods_of_issues) AS goods_of_issues, SUM(paid_money) AS paid_money, SUM(balance_due) AS balance_due
                ")
            )->where('vendor_id', $id)->firstOrFail();

            $total_due = $details->goods_of_issues - $details->paid_money;
        }

        return view('admin.purchase.index', compact('details', 'total_due', 'vendor'));
    }

    
    public function api(Request $req, int | string $id = '')
    {
        $start = (int) $req->get('start', 0);
        $limit = (int) $req->get('limit', 10);
        $order_by = match ($req->get('order_by')) {
            'memo_number' => 'memo_number',
            'date' => 'date',
            'goods_of_issues' => 'goods_of_issues',
            'paid_money' => 'paid_money',
            'balance_due' => 'balance_due',
            // 'vendor' => 'vendor.name',
            default => 'id'
        };

        $order = 'DESC';
        if ($req->get('order') === 'asc') {
            $order = 'asc';
        }

        $search = $req->get('search', '');

        $q = Purchase::query();

        if ($id) {
            $q->where('vendor_id', $id);
        } else {
            $q->with('vendor');
        }

        if ($search) {
            $search = '%' . $search . '%';
            $q->where(function ($q) use ($search, $id) {
                $q->where('memo_number', 'LIKE', $search);
                $q->orWhere('comment', 'LIKE', $search);
                if (!$id) {
                    $q->orWhereHas('vendor', function($q) use ($search){
                        $q->Where('name', 'LIKE', $search);
                    });
                }
            });
        }

        return [
            'count' => $q->count(),
            'data' => $q->orderBy($order_by, $order)->offset($start)->limit($limit)->get()
        ];

    }

    public function generatePDF(Request $request, int $id = 0)
    {
        $ball=$goodsOfIssue=$paidMoney=$dueBalance=0;
        $q = DB::table('purchases')
            ->select('purchases.*','vendors.id as vendors_id','vendors.name','vendors.limit')
            ->leftJoin('vendors','purchases.vendor_id','=','vendors.id');

        if( $id) {
            $q->where('vendor_id',$request->id);
        }
        $purchases = $q->get();
        // dd($purchases);
        if (isset($purchases)) {
            foreach ($purchases as $purchase) {
                $ball+=(int)$purchase->ball;
                $goodsOfIssue += (int)$purchase->goods_of_issues;
                $paidMoney += (int)$purchase->paid_money;
                $dueBalance += (int)$purchase->balance_due;
            }
        }
        $totalDue = ($goodsOfIssue-$paidMoney);
        $pdf = Pdf::loadView('admin.purchase.pdf', [
            'purchases'=>$purchases,
            'ball'=>$ball,
            'goodsOfIssues'=>$goodsOfIssue,
            'paidMoney'=>$paidMoney,
            'dueBalance'=>$dueBalance,
            'totalDue'=>$totalDue
        ]);

        return $pdf->download('purchase.pdf');
    }

    public function store(Request $request, int $id = 0)
    {
        $purchase = null;
        if ($id) {
            $purchase = Purchase::findOrFail($id);
        }

        $data = $request->validate([
            'vendor_id' => 'required|numeric|exists:vendors,id',
            'date' => 'required|date_format:Y-m-d',
            'memo_number' => 'nullable|string',
            'quantity' => 'required|string',
            'mark' => 'required|string',
            'ball' => 'required|string',
            'goods_of_issues' => 'required|string',
            'paid_money' => 'required|numeric|min:0',
            'balance_due' => 'nullable|numeric|min:0',
            'comment' => 'nullable|string',
        ]);

        if ($purchase) {
            $purchase->update($data);
            return $this->backToForm('Purchase updated successfully!');
        } else {
            Purchase::create($data);
            return $this->backToForm('Purchase added successfully!');
        }
    }

    public function deleteMultiple(Request $request){
        $delete = DB::table('purchases')->whereIn('id', $request->itemArray)->delete();
        return $delete?1:0;
    }


    public function delete(int $id)
    {
        if (Purchase::destroy($id)){
            return ['message'=>'Deposit deleted successfully'];
        }
        return response(['message' => 'Unable to delete the deposit!'], 422);
    }
}
