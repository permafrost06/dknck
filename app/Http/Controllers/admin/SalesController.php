<?php

namespace App\Http\Controllers\admin;

use App\Models\Customer;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sales;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{

    public function index(Request $request, int $id = 0)
    {
        $customer = null;
        $details = null;
        $total_due = 0;

        if ($id) {
            $customer = Customer::findOrFail($id);
            $details = Sales::select(
                DB::raw("
                    SUM(lv) AS lv, SUM(goods_of_issues) AS goods_of_issues, SUM(received_money) AS received_money, SUM(balance_due) AS balance_due
                ")
            )->where('customer_id', $id)->firstOrFail();

            $total_due = $details->goods_of_issues - $details->received_money;
        }

        return view('admin.sales.index', compact('details', 'total_due', 'customer'));
    }

    public function api(Request $req, int | string $id = '')
    {
        $start = (int) $req->get('start', 0);
        $limit = (int) $req->get('limit', 10);
        $order_by = match ($req->get('order_by')) {
            'memo_number' => 'memo_number',
            'date' => 'date',
            'goods_of_issues' => 'goods_of_issues',
            'lv' => 'lv',
            'received_money' => 'received_money',
            'balance_due' => 'balance_due',
            default => 'id'
        };

        $order = 'DESC';
        if ($req->get('order') === 'asc') {
            $order = 'asc';
        }

        $search = $req->get('search', '');

        $q = Sales::query();

        if ($id) {
            $q->where('customer_id', $id);
        } else {
            $q->with('customer');
        }

        if ($search) {
            $search = '%' . $search . '%';
            $q->where(function ($q) use ($search, $id) {
                $q->where('memo_number', 'LIKE', $search);
                $q->orWhere('comment', 'LIKE', $search);
                if (!$id) {
                    $q->orWhereHas('customer', function($q) use ($search){
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
        $lv = $goodsOfIssue = $receivedMoney = $dueBalance = 0;
        $q = DB::table('sales')
            ->leftJoin('customers', 'sales.customer_id', '=', 'customers.id');

        if ($id) {
            $q->where('customer_id', $id);
        }
        $customerDeposits = $q->get();
        //dd($customerDeposits);
        if (isset($customerDeposits)) {
            foreach ($customerDeposits as $customerDeposit) {

                $lv += $customerDeposit->lv;
                $goodsOfIssue += $customerDeposit->goods_of_issues;
                $receivedMoney += $customerDeposit->received_money;
                $dueBalance += $customerDeposit->balance_due;
            }
        }
        $totalDue = ($goodsOfIssue - $receivedMoney);
        $pdf = Pdf::loadView('admin.sales.pdf', [
            'customerDeposits' => $customerDeposits,
            'lv' => $lv,
            'goodsOfIssues' => $goodsOfIssue,
            'receivedMoney' => $receivedMoney,
            'dueBalance' => $dueBalance,
            'totalDue' => $totalDue
        ]);

        $date = (new DateTime)->format('d-m-Y');
        $pdf_name = "sales ledger {$customerDeposits[0]->name} $date";

        return $pdf->download($pdf_name);
    }


    public function form(string|int $id = '')
    {
        $sale = null;
        if (is_numeric($id)) {
            $sale = Sales::findOrFail($id);
        }
        $customers = Customer::all();
        return view('admin.sales.form', compact('sale', 'customers'));
    }


    public function store(Request $request, int $id = 0)
    {
        $sale = null;
        if ($id) {
            $sale = Sales::findOrFail($id);
        }

        $data = $request->validate([
            'customer_id' => 'required|numeric|exists:customers,id',
            'date' => 'required|date_format:Y-m-d',
            'memo_number' => 'required|string',
            // 'quantity' => 'required|string',
            'goods_of_issues' => 'required|string',
            'lv' => 'required|numeric|min:0',
            'received_money' => 'required|numeric|min:0',
            'balance_due' => 'required|numeric|min:0',
            'comment' => 'nullable|string',
        ]);

        if ($sale) {
            $sale->update($data);
            return $this->backToForm('Sale updated successfully!');
        } else {
            Sales::create($data);
            return $this->backToForm('Sale added successfully!');
        }
    }

    public function deleteMultiple(Request $request)
    {
        $delete = DB::table('sales')->whereIn('id', $request->itemArray)->delete();
        return $delete ? 1 : 0;
    }
    public function delete(Request $request, int $id)
    {
        if (Sales::destroy($id)) {
            return ['message' => 'Deposit deleted successfully'];
        }
        return response(['message' => 'Unable to delete sale!'], 422);
    }
}