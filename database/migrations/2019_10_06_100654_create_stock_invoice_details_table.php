<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_invoice_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('stock_invoice_id');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('item_id');
            $table->integer('quantity');
            $table->decimal('item_cost');
            $table->decimal('discount')->default(0);

            $table->string('item_name');
            $table->string('item_description')->nullable();
            $table->string('item_cost_without_tax')->nullable();

            $table->decimal('tax_percent')->default(0);
            $table->decimal('tax_value')->default(0);

            $table->unsignedInteger('created_by')->nullable();
            $table->softDeletes();
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(\DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('stock_invoice_id')->references('id')->on('stock_invoices');
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
        Schema::dropIfExists('stock_invoice_details');
    }
}
