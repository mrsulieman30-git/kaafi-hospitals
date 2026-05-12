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
        Schema::table('blog_posts', function (Blueprint $table) {
            if (!Schema::hasColumn('blog_posts', 'type')) {
                $table->string('type')->default('post')->after('id');
                $table->string('old_price')->nullable();
                $table->string('new_price')->nullable();
                $table->boolean('has_appointment_btn')->default(false);
                $table->integer('views')->default(0);
                $table->integer('likes')->default(0);
                $table->unsignedBigInteger('linked_doctor_id')->nullable();
                $table->timestamp('offer_end_date')->nullable();
            }
        });

        if (!Schema::hasTable('site_stats')) {
            Schema::create('site_stats', function (Blueprint $table) {
                $table->id();
                $table->string('session_id')->unique();
                $table->integer('hits')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn(['type', 'old_price', 'new_price', 'has_appointment_btn', 'views', 'likes', 'linked_doctor_id', 'offer_end_date']);
        });
        Schema::dropIfExists('site_stats');
    }
};
