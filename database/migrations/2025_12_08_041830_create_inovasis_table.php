<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('inovasis', function (Blueprint $table) {
        $table->id();
        $table->string('nama_inovasi');
        $table->text('deskripsi')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('inovasis');
    }
};
