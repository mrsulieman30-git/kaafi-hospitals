<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            if (Schema::hasColumn('blog_posts', 'image')) {
                $table->renameColumn('image', 'featured_image');
            }
            $table->string('featured_image_url', 2048)->nullable()->after('featured_image');
        });
    }

    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->renameColumn('featured_image', 'image');
            $table->dropColumn('featured_image_url');
        });
    }
};
