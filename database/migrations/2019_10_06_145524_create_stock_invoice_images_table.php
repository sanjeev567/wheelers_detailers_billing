<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockInvoiceImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_invoice_images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('stock_invoice_id');
            $table->string('image');
            $table->string('description')->nullable();
            $table->integer('created_by')->unsigned()->nullable();

            $table->foreign('stock_invoice_id')->references('id')->on('stock_invoices');
            $table->foreign('created_by')->references('id')->on('users');

            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(\DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_invoice_images');
    }
}
