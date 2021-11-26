<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('transaction_id');
            $table->decimal('amount',10,2);
            $table->decimal('discount',10,2)->default(0);
            $table->string('method')->nullable();
            $table->tinyInteger('type')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->json('payload');
            
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
        Schema::dropIfExists('transactions');
    }
}
