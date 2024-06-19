<?php

// database/migrations/date_create_pagamentos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagamentosTable extends Migration
{
    public function up()
    {
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente');
            $table->double('valor', 10, 2);
            $table->date('data_pagamento');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cliente')
                ->references('id')
                ->on('clientes')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagamentos');
    }
}
