<?php

// database/migrations/date_create_despesas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDespesasTable extends Migration
{
    public function up()
    {
        Schema::create('despesas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conta'); // Chave estrangeira para a Conta
            $table->string('descricao'); // Descrição da despesa
            $table->double('valor', 10, 2); // Valor da despesa
            
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
        Schema::dropIfExists('despesas');
    }
}

