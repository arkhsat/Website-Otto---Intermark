<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfid_vehicles', function (Blueprint $table) {
            $table->id();
            $table->integer('zone')->default(0);
            $table->integer('type')->default(0);
            $table->integer('floor')->default(0);
            $table->integer('slot')->default(0);
            $table->string('vehicle_no')->nullable();
            $table->string('rfid_no')->nullable();
            $table->string('name')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('notes')->nullable();
            $table->integer('parent_id')->default(0);
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
        Schema::dropIfExists('rfid_vehicles');
    }
};
