<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parkings', function (Blueprint $table) {
            $table->id();
            $table->integer('parking_id')->default(0);
            $table->integer('zone')->default(0);
            $table->integer('type')->default(0);
            $table->integer('floor')->default(0);
            $table->integer('slot')->default(0);
            $table->string('vehicle_number')->nullable();
            $table->string('name')->nullable();
            $table->string('phone_number')->nullable();
            $table->date('entry_date')->nullable();
            $table->time('entry_time')->nullable();
            $table->date('exit_date')->nullable();
            $table->time('exit_time')->nullable();
            $table->float('total_duration')->default(0);
            $table->float('amount')->default(0);
            $table->integer('payment_status')->default(0);
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('parkings');
    }
};
