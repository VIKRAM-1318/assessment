<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subcategory_id')->constrained()->cascadeOnDelete();
            $table->string('listing_type'); // 'product' or 'service'
            $table->string('name');
            $table->text('detail');
            $table->string('country');
            $table->string('state');
            $table->string('city')->index();
            $table->string('area');
            $table->decimal('price', 12, 2);
            $table->string('image_path')->nullable();
            $table->string('status')->default('active')->index();
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamps();

            $table->index(['city', 'category_id']);
            $table->index(['listing_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
