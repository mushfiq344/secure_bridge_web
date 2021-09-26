<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('created_by')->unsigned();
            $table->string('title');
            $table->text('subtitle', 500)->nullable();
            $table->text('description', 10000)->nullable();
            $table->date('opportunity_date')->nullable();
            $table->integer('duration')->nullable();
            $table->text('reward', 500)->nullable();
            $table->integer('type')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('icon_image')->nullable();
            $table->boolean('is_active')->default(false);
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
        Schema::dropIfExists('opportunities');
    }
}