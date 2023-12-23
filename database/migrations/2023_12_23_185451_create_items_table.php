<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            $table->tinyText('name')->nullable();
            $table->tinyText('vendor');
            $table->unsignedDouble('unit_price_buying');
            $table->unsignedBigInteger('quantity');
            $table->unsignedBigInteger('sold')->default(0);
            $table->unsignedBigInteger('profit')->default(0);
            $table->date('date');
            $table->text('remarks');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
};
