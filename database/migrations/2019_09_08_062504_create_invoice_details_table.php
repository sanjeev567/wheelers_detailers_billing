<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('item_id');
            $table->integer('quantity');
            $table->decimal('item_cost');
            $table->decimal('discount')->default(0);

            $table->unsignedInteger('created_by')->nullable();
            $table->softDeletes();
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(\DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_details');
    }
}
