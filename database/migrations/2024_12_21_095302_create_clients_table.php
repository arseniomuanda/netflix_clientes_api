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
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name', 100);
            $table->string('phone', 9);
            $table->string('photo', 255)->nullable();
            $table->string('whatsapp', 19)->nullable()->unique();
            $table->string('email', 150)->nullable()->unique();

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
        Schema::dropIfExists('clients');
    }
};
