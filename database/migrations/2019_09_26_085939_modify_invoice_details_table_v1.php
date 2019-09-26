<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyInvoiceDetailsTableV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_details', function (Blueprint $table) {
            $table->string('item_name');
            $table->string('item_description')->nullable();

            $table->decimal('tax_percent')->default(0);
            $table->decimal('tax_value')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_details', function (Blueprint $table) {
            $table->dropColumn('item_name');
            $table->dropColumn('item_description');

            $table->dropColumn('tax_percent');
            $table->dropColumn('tax_value');
        });
    }
}
