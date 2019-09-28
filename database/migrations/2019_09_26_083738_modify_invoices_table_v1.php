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
            $table->string('customer_address')->nullable();

            $table->string('seller_name');
            $table->string('web_link')->nullable();
            $table->string('seller_phone1')->nullable();
            $table->string('seller_phone2')->nullable();
            $table->string('seller_address_line1');
            $table->string('seller_address_line2')->nullable();
            $table->string('seller_address_line3')->nullable();

            $table->string('seller_gstin');
            $table->string('seller_pan')->nullable();
            $table->string('buyer_gstin')->nullable();

            $table->string('seller_bank')->nullable();
            $table->string('seller_branch')->nullable();
            $table->string('seller_ifsc')->nullable();
            $table->string('seller_account_number')->nullable();

            $table->decimal('total_without_tax')->default(0);
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
            $table->dropColumn('customer_address');

            $table->dropColumn('seller_name');
            $table->dropColumn('web_link');
            $table->dropColumn('seller_phone1');
            $table->dropColumn('seller_phone2');
            $table->dropColumn('seller_address_line1');
            $table->dropColumn('seller_address_line2');
            $table->dropColumn('seller_address_line3');

            $table->dropColumn('seller_gstin');
            $table->dropColumn('seller_pan');
            $table->dropColumn('buyer_gstin');

            $table->dropColumn('seller_bank');
            $table->dropColumn('seller_branch');
            $table->dropColumn('seller_ifsc');
            $table->dropColumn('seller_account_number');

            $table->dropColumn('total_tax');
            $table->dropColumn('total_discount');
            $table->dropColumn('total_without_tax');

            $table->dropColumn('due_date');
        });
    }
}
