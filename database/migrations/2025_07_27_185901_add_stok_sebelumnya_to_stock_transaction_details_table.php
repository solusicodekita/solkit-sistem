<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStokSebelumnyaToStockTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_transaction_details', function (Blueprint $table) {
            $table->decimal('stok_sebelumnya', 15, 2)->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_transaction_details', function (Blueprint $table) {
            $table->dropColumn('stok_sebelumnya');
        });
    }
}
