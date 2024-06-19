<?php

// database/migrations/date_create_telas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelasTable extends Migration
{
    public function up()
    {
        Schema::create('telas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente'); // Chave estrangeira para o Cliente
            $table->unsignedBigInteger('conta'); // Chave estrangeira para a Conta
            $table->string('nome'); // Nome da tela
            $table->string('pin', 4); // Nome da tela
            
            $table->foreign('cliente')
            ->references('id')
            ->on('clientes')
            ->onDelete('cascade');
            
            $table->foreign('conta')
            ->references('id')
            ->on('contas')
            ->onDelete('cascade');
            
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('telas');
    }
}
