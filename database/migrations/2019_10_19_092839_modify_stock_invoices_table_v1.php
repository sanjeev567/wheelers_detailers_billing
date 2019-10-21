<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyStockInvoicesTableV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_invoices', function (Blueprint $table) {
            $table->string('type')->default('invoice');
            $table->string('challan_number')->nullable();
            $table->string('invoice_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_invoices', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('challan_number');
        });
    }
}
