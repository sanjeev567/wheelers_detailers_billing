<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyInvoicesTableV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('customer_name');
            $table->string('customer_mobile')->nullable();
            $table->string('customer_email')->nullable();

            $table->string('seller_name');
            $table->string('web_link')->nullable();
            $table->string('seller_phone1')->nullable();
            $table->string('seller_phone2')->nullable();
            $table->string('seller_address_line1');
            $table->string('seller_address_line2')->nullable();
            $table->string('seller_address_line3')->nullable();

            $table->string('gs_tin');

            $table->decimal('total_without_tax');
            $table->decimal('total_tax')->default(0);
            $table->decimal('total_discount')->default(0);

            $table->date('due_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('customer_name');
            $table->dropColumn('customer_mobile');
            $table->dropColumn('customer_email');

            $table->dropColumn('seller_name');
            $table->dropColumn('web_link');
            $table->dropColumn('seller_phone1');
            $table->dropColumn('seller_phone2');
            $table->dropColumn('seller_address_line1');
            $table->dropColumn('seller_address_line2');
            $table->dropColumn('seller_address_line3');

            $table->dropColumn('gs_tin');

            $table->dropColumn('total_tax');
            $table->dropColumn('total_discount');
            $table->dropColumn('total_without_tax');

            $table->dropColumn('due_date');
        });
    }
}
