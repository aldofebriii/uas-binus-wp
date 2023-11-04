<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Setup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valas', function(Blueprint $table) {
            $table->id();
            $table->string('nama_valas');
            $table->string('nilai_jual');
            $table->string('nilai_beli');
            $table->date('tanggal_rate');
        });
        
        Schema::create('membership', function(Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->double('diskon');
            $table->double('min_profit');
        });

        Schema::create('customers', function(Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('alamat');
            $table->foreignId('tipe_member')->constrained(
                table: 'membership',
                column: 'id'
            );
        });

        Schema::create('transaksi', function(Blueprint $table) {
            $table->id();
            $table->string('nomor');
            //Join pada customer id akan ngepopulate data nama_customer
            $table->foreignId('customer_id')->constrained(table: 'customers');
            //Untuk discount tidak menggunakan customer_id dikrenakan pada transaksi masih bisa menggunakan memberbip yang lama
            $table->double('diskon');
        });

        Schema::create('detail_transaksi', function(Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained(table: 'transaksi')->onDelete('cascade');
            $table->string('nama_valas');
            $table->double('rate');
            $table->integer('qty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('valas');
        Schema::dropIfExists('membership');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('transaksi');
        Schema::dropIfExists('detail_transaksi');
    }
}
