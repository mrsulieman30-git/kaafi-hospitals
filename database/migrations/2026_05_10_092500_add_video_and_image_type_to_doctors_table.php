<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('doctors', function (Blueprint $table) {
            if (!Schema::hasColumn('doctors', 'youtube_video_url')) {
                $table->string('youtube_video_url', 2048)->nullable()->after('phone');
            }
            if (!Schema::hasColumn('doctors', 'image_type')) {
                $table->string('image_type')->nullable()->default('upload')->after('image_url');
            }
        });
    }
    public function down(): void {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn(['youtube_video_url', 'image_type']);
        });
    }
};
