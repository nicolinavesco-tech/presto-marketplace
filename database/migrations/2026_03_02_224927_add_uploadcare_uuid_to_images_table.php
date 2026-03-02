<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->string('uploadcare_uuid')->nullable()->after('path');
            // se hai public_id Cloudinary, puoi lasciarlo per compatibilità temporanea
            // poi rimuoverlo quando sei sicuro
        });
    }

    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('uploadcare_uuid');
        });
    }
};