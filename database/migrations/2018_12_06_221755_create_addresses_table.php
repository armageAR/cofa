<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('street', 60)->nullable()->comment("Street");
            $table->string('number', 20)->nullable()->comment("House Number");
            $table->string('apartment', 20)->nullable();
            $table->string('city', 60)->nullable();
            $table->string('state', 60)->nullable();
            $table->string('zip', 10)->nullable()->comment("Postal Code");
            $table->string('countryCode', 2)->nullable()->default('ar');

            $table->enum('type', config('cofa.address.type'))->nullable();

            $table->string('note')->nullable();

            $table->nullableMorphs('addressable');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
