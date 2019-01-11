<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImportHeaderFK extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('import_headers', function (Blueprint $table) {
            $table->foreign('file_id')->references('id')->on('import_files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('import_headers', function (Blueprint $table) {
            $table->dropForeign(['file_id']);
        });
    }
}
