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

        //Roles Table
        Schema::create('roles', function (Blueprint $table) {
            $table->id('role_id'); // Primary Key
            $table->string('role_name')->unique(); // Role name should be unique
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id'); // Primary Key
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->unsignedBigInteger('role_id');

            $table->foreign('role_id')->references('role_id')->on('roles')->cascadeOnDelete();
        });

        // Logs Table
        Schema::create('logs', function (Blueprint $table) {
            $table->id('log_id'); // Primary Key
            $table->unsignedBigInteger('user_id');
            $table->string('current_user');
            $table->string('action_type');
            $table->string('table_name');
            $table->timestamp('date')->default(now());

            $table->foreign('user_id')->references('user_id')->on('users')->cascadeOnDelete();
        });


        // Blogs Table
        Schema::create('blogs', function (Blueprint $table) {
            $table->id('blog_id'); // Primary Key
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->text('content');
            $table->timestamp('date')->default(now());
            $table->foreign('user_id')->references('user_id')->on('users')->cascadeOnDelete();
            $table->timestamps();
            // Foreign Key to users
        });

        // Categories Table
        Schema::create('categories', function (Blueprint $table) {
            $table->id('category_id'); // Primary Key
            $table->string('category_name')->unique();
            $table->timestamps(); // Category name should be unique
        });

        // Blog_Category Pivot Table
        Schema::create('blog_category', function (Blueprint $table) {
            $table->foreignId('blog_id')->constrained('blogs', 'blog_id')->cascadeOnDelete(); // Use 'blog_id' explicitly
            $table->foreignId('category_id')->constrained('categories', 'category_id')->cascadeOnDelete(); // Foreign Key to categories
            $table->primary(['blog_id', 'category_id']); // Composite Primary Key
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_category');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('blogs');
        Schema::dropIfExists('logs');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('cache');
    }
};
