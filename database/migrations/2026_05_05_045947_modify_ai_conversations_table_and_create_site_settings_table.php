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
        Schema::table('ai_conversations', function (Blueprint $table) {
            $table->dropUnique(['session_id']);
        });

        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo_path')->nullable();
            $table->integer('logo_height')->default(40);
            $table->string('logo_position')->default('left');
            $table->string('hero_bg_path')->nullable();
            $table->integer('hero_bg_opacity')->default(10);
            $table->string('chatbot_avatar_path')->nullable();
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('site_settings')->insert([
            'id' => 1,
            'logo_height' => 40,
            'logo_position' => 'left',
            'hero_bg_opacity' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
        Schema::table('ai_conversations', function (Blueprint $table) {
            $table->unique('session_id');
        });
    }
};
