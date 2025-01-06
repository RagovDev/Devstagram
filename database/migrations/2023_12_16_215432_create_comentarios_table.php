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
        Schema::create('comentarios', function (Blueprint $table) {
            // la funcion cascade se usa para que cuando una persona elimina su cuuenta, o elimine un post en el que yo he comentado, entonces tambien se eliminen los comentarios relacionados que yo hice. Esto se hace debido a que mis comentarios estan relacionados con llaves foraneas a los post y a las cuentas, entonces si no uso el cascade, saldra un error respecto a esas llaves.
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('comentario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
