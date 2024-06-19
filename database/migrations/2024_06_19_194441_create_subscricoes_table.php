<?php

// database/migrations/date_create_subscricoes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscricoesTable extends Migration
{
    public function up()
    {
        Schema::create('subscricoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id'); // Chave estrangeira para o Cliente
            $table->unsignedBigInteger('conta_id'); // Chave estrangeira para a Conta
            $table->string('plano'); // Plano de assinatura (por exemplo, gratuito, básico, premium)
            $table->decimal('valor', 8, 2); // Valor da assinatura
            $table->date('data_inicio'); // Data de início da assinatura
            $table->date('data_fim'); // Data de término da assinatura
            $table->boolean('ativo')->default(true); // Indica se a assinatura está ativa
            $table->timestamps();

            $table->foreign('cliente_id')
                ->references('id')
                ->on('clientes')
                ->onDelete('cascade');

            $table->foreign('conta_id')
                ->references('id')
                ->on('contas')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscricoes');
    }
}
