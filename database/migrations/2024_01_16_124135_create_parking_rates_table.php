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
        Schema::create('parking_rates', function (Blueprint $table) {
            $table->id();
            $table->integer('zone')->default(0);
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->integer('vehicle_type')->default(0);
            $table->float('fix_rate')->default(0);
            $table->float('hourly_rate')->default(0);
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
        Schema::dropIfExists('parking_rates');
    }
};
