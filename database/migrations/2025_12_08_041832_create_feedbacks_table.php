<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::create('feedbacks', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('nip');
        $table->foreignId('unit_id')->constrained()->onDelete('cascade');
        $table->foreignId('inovasi_id')->constrained()->onDelete('cascade');
        $table->integer('lama_implementasi'); // dalam bulan
        
        // Rating fields (1-5 stars)
        $table->integer('rating_kemudahan')->default(0);
        $table->integer('rating_kesesuaian')->default(0);
        $table->integer('rating_keandalan')->default(0);
        
        $table->text('feedback')->nullable();
        $table->text('saran')->nullable();
        
        $table->timestamps();
    });
}
    
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
