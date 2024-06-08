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
        Schema::create('generate_qr', function (Blueprint $table) {
            $table->id();
            $table->string('serficate_number');
            $table->string('name');
            $table->string('jenis_pelatian');
            $table->timestamp('date_terbit')->nullable();
            $table->string('name_penandatangan');
            $table->text('digital_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generate_qr');
    }
};
