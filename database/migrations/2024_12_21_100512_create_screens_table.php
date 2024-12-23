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
        Schema::create('screens', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name', 20);
            $table->string('pin', 4);

            $table->uuid('account');
            $table->foreign('account')->references('id')->on('accounts');

            $table->uuid('client');
            $table->foreign('client')->references('id')->on('clients');

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
        Schema::dropIfExists('screens');
    }
};
