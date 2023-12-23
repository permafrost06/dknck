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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();

            $table->enum('type', ['in', 'out']);
            $table->string('brand');
            $table->string('item_code');
            $table->unsignedInteger('quantity');

            $table->unsignedInteger('unit_cost');
            $table->integer('adjustment');

            $table->string('merchant_name')->nullable();
            $table->string('merchant_contact')->nullable();
            $table->string('carrier_name')->nullable();
            $table->string('carrier_contact')->nullable();
            $table->string('border')->nullable();
            
            $table->text('remarks')->nullable();
            $table->tinyText('attachment')->nullable();
            $table->dateTime('date_time');

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
        Schema::dropIfExists('stocks');
    }
};
