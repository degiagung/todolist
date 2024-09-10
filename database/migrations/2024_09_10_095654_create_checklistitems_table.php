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
        Schema::create('checklistitems', function (Blueprint $table) {
            $table->id();
            $table->string('checklistitem_name',50);
            $table->string('status',50)->nullable();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->unsignedBigInteger('id_checklist')->nullable();
            $table->timestamps();
            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->onDelete('cascade'); //
            $table->foreign('id_checklist')
                ->references('id')
                ->on('checklists')
                ->onDelete('cascade'); //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklistitems');
    }
};
