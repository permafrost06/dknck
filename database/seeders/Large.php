<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Sales;
use App\Models\Stock;
use App\Models\StockItem;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class Large extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::factory()->count(100)->has(
            Sales::factory()->count(50), 'sales'
        )->create();

        Vendor::factory()->count(100)->has(
            Purchase::factory()->count(50), 'purchases'
        )->create();

        StockItem::factory()->count(100)->has(
            Stock::factory()->count(20)->state(new Sequence(
                ['type' => 'in'],
                ['type' => 'out']
            )), 'logs'
        )->create();
    }
}
