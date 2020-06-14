<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('loan_id');         
            $table->integer('number');
            $table->decimal('amount');
            $table->date('payment_date');
            $table->decimal('received_amount');
            $table->boolean('complet')->default(0);
            $table->timestamps();

            
            $table->foreign('client_id')
            ->references('id')
            ->on('clients');
            $table->foreign('loan_id')
            ->references('id')
            ->on('loans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
