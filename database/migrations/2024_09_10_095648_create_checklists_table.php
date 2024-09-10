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
        Schema::create('checklists', function (Blueprint $table) {
            $table->id();
            $table->string('checklist_name',50);
            $table->unsignedBigInteger('id_user')->nullable();
            $table->timestamps();
            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->onDelete('cascade'); //
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklists');
    }
};
