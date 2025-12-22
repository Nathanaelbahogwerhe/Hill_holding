<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('filiale_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('agency_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
CREATE TABLE `departments` (
  `id` bigint unsigned PRIMARY KEY,
  `name` varchar(255),
  `filiale_id` bigint unsigned DEFAULT NULL,  -- ✅ Département rattaché à une Filiale
  `agency_id` bigint unsigned DEFAULT NULL,   -- ✅ Département rattaché à une Agence
  
  CONSTRAINT `departments_filiale_id_foreign` 
    FOREIGN KEY (`filiale_id`) REFERENCES `filiales` (`id`) ON DELETE SET NULL
)




