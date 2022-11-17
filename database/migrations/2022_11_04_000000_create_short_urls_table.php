<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('short_urls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable()->comment('建立者');
            $table->string('keyword')->unique()->comment('短網址關鍵詞');
            $table->longText('url')->comment('轉址目標');
            $table->json('meta')->nullable()->comment('轉址 META');
            $table->boolean('enabled')->default(true)->comment('啟用狀態');
            $table->string('password')->nullable()->comment('轉址加密');
            $table->string('remark')->nullable()->comment('備註說明');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });

        Schema::create('short_url_visits', function (Blueprint $table) {
            $table->unsignedBigInteger('url_id');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();

            $table->foreign('url_id')
                  ->references('id')
                  ->on('short_urls')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('short_url_visits');
        Schema::dropIfExists('short_urls');
    }
};
