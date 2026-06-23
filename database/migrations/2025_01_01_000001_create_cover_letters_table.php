<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cover_letters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // nullable karena bisa dari input manual (tanpa pilih job_listing)
            $table->foreignId('job_listing_id')->nullable()->constrained()->onDelete('set null');
            $table->string('job_title');
            $table->string('company_name');
            $table->longText('content');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cover_letters');
    }
};
