<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesBodiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_bodies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('filesHeader_id');
            $table->string('invoiceNumber', 20);
            $table->string('invoiceType', 20);
            $table->date('invoiceDate');
            $table->string('accountNumber', 20);
            $table->string('lineNumber', 20);
            $table->string('itemDetail', 20)->nullable();
            $table->string('itemDescription', 40);
            $table->date('startDate')->nullable();
            $table->date('endDate')->nullable();
            $table->float('amountNoVat', 10, 2);
            $table->float('vatAmount', 8, 2);
            $table->decimal('vatPercent', 8, 2);
            $table->float('totalAmount', 10, 2);
            $table->timestamps();

            $table->foreign('filesHeader_id')->references('id')->on('files_headers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files_bodies');
    }
}
