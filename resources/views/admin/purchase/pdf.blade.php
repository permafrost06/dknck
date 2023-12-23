<!DOCTYPE html>

<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Purchase Ledger</title>
</head>

<body>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Sales Ledger</h3>
                </div>
                @if (count($purchases) > 0)
                    <div class="row">
                        <div class="col-md-6 col-md-offset-1">
                            <span>Customer Id: {{ $purchases[0]->vendor_id }}</span><br>
                            <span>Customer Name: {{ $purchases[0]->name }}</span>

                        </div>
                        <div class="col-md-4">
                            <span>Customer Limit: {{ $purchases[0]->limit }}</span>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-1">
                            <span>Total Ball: {{ $ball }}</span><br>
                        </div>
                        <div class="col-md-3">
                            <span>Total Paid Money: {{ $paidMoney }}</span>

                        </div>
                        <div class="col-md-3">
                            <span>Total Due Balance: {{ $totalDue }}</span>

                        </div>

                    </div>
                    <div class="row col-md-offset-1">
                        <span>Total Goods of Issues: {{ $goodsOfIssues }}</span>
                    </div>
                @endif
                <!-- /.box-header -->
                <!-- form start -->
                @if (Session::has('message'))
                    <div class="col-md-6 col-md-offset-2"id="successMessage">
                        <span> {{ Session::get('message') }}</span>
                    </div>
                @endif
                <!-- /.box-body -->
                <div class="box-footer">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Sln</th>
                                <th>Date</th>
                                <th>Memo Number</th>
                                <th>Goods of Issues</th>
                                <th>Paid money</th>
                                <th>Balance(Due)</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($purchases))
                                @foreach ($purchases as $k => $purchase)
                                    <tr>
                                        <td>{{ ++$k }}</td>
                                        <td>{{ $purchase->date }}</td>
                                        <td>{{ $purchase->memo_number }}</td>
                                        <td> {{ $purchase->goods_of_issues }}</td>
                                        <td> {{ $purchase->paid_money }}</td>
                                        <td> {{ $purchase->goods_of_issues - $purchase->paid_money }}</td>
                                        <td> {{ $purchase->comment }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
