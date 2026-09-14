<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('sks');
            //Masalah 1: urutan migrate salah: karena file create_courses _table.php dibuat sebelum create_users_table.php, maka foreign key lecturer_id tidak bisa dibuat karena tabel users belum ada. Solusinya adalah mengubah urutan nama file migration agar create_users_table.php dijalankan terlebih dahulu.
            //Masalah 3: Pada tabel courses, foreign key lecturer_id menggunakan cascadeOnDelete(). Artinya, jika data dosen dihapus, course yang diajarkan dosen tersebut juga ikut terhapus. Jadi ubah cascadeOnDelete() menjadi restrictOnDelete() agar data course tidak ikut terhapus saat dosen dihapus.
            $table->foreignId('lecturer_id')->constrained('users')->restrictOnDelete();
            $table->enum('status', ['draft', 'active', 'archived'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
