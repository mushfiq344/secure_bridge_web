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
            $table->string('slug')->unique();
            $table->text('subtitle', 500)->nullable();
            $table->text('description', 10000)->nullable();
            $table->date('opportunity_date')->nullable();
            $table->integer('duration')->nullable();
            $table->text('reward', 500)->nullable();
            $table->integer('type')->default(0);
            $table->string('cover_image')->nullable();
            $table->string('icon_image')->nullable();
            $table->string('location')->nullable();
            $table->boolean('is_active')->default(false);
            $table->tinyInteger('status')->default(0);
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
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