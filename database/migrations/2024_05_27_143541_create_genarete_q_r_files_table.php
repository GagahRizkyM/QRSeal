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
        Schema::create('genarete_q_r_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('generate_qr_id')->constrained('generate_qr');
            $table->string('name');
            $table->string('path')->nullable();
            $table->float('size')->nullable();
            $table->string('ext')->nullable();
            $table->string('type')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genarete_q_r_files');
    }
};
