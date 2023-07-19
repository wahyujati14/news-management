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
        Schema::create('comment', function (Blueprint $table) {
            $table->id();
            $table->text('keterangan');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by');
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment');
    }
};
