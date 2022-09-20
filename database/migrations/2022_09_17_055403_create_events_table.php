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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('end_after_occurrences')->default(0);
            $table->enum('repeat_on',array_keys(config('event.repeat_on')));
            $table->enum('repeat_week',array_keys(config('event.repeat_weeks')))->nullable();
            $table->unsignedInteger('repeat_month',array_keys(config('event.repeat_months')))->nullable();
            $table->unsignedBigInteger('successfullyRunCount')->default(0);
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
        Schema::dropIfExists('events');
    }
};
