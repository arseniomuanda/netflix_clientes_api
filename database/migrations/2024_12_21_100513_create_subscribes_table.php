<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscribes', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('client');
            $table->foreign('client')->references('id')->on('clients');

            $table->uuid('service');
            $table->foreign('service')->references('id')->on('services');

            $table->uuid('screen')->nullable();
            $table->foreign('screen')->references('id')->on('screens');

            $table->date('start');
            $table->date('end');

            $table->uuid('created_by');
            $table->foreign('created_by')->references('id')->on('users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscribes');
    }
};
