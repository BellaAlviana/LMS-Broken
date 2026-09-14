<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('uploaded_by')->constrained('users')->restrictOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['file', 'link']);
            $table->string('file_path')->nullable();
            $table->string('original_name')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('external_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        //Masalah 5: Pada migration create_materials_table.php, method down() kosong sehingga tabel materials tidak memiliki perintah untuk dihapus ketika migration di-rollback. Solusinya adalah menambahkan kode Schema::dropIfExists('materials'); pada method down() untuk menghapus tabel materials saat migration di-rollback. Migration dapat di-rollback dengan benar dan tabel materials akan ikut dihapus.
        Schema::dropIfExists('materials');
    }
};
