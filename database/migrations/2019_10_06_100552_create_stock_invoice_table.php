<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger('seller_id');
            $table->string('invoice_number');
            $table->decimal('total');
            $table->integer('total_items');
            $table->string('customer_name');
            $table->string('customer_mobile')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('customer_state');

            $table->string('seller_name');
            $table->string('web_link')->nullable();
            $table->string('seller_phone1')->nullable();
            $table->string('seller_phone2')->nullable();
            $table->string('seller_address_line1');
            $table->string('seller_address_line2')->nullable();
            $table->string('seller_address_line3')->nullable();
            $table->string('seller_state', 10);

            $table->string('seller_gstin');
            $table->string('seller_pan')->nullable();
            $table->string('buyer_gstin')->nullable();

            $table->string('seller_bank')->nullable();
            $table->string('seller_branch')->nullable();
            $table->string('seller_ifsc')->nullable();
            $table->string('seller_account_number')->nullable();
            $table->string('seller_cin')->nullable();

            $table->decimal('total_without_tax')->default(0);
            $table->decimal('total_tax')->default(0);
            $table->decimal('total_discount')->default(0);

            $table->date('due_date')->nullable();
            $table->date('invoice_date')->nullable();

            $table->unsignedInteger('created_by')->nullable();
            $table->softDeletes();
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(\DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('seller_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_invoices');
    }
}
