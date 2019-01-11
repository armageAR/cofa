<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_headers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('custNumber', 201);
            $table->string('custName', 201);
            $table->date('invoiceDate');
            $table->unsignedInteger('file_id')->unique();
            $table->string('fileStatus', 20);
            $table->timestamps();



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('import_headers');
    }
}
