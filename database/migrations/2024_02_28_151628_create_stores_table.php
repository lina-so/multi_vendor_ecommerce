<?php

use App\Models\Vendor;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Vendor::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('email');
            $table->string('phone');
            $table->string('industry')->nullable();// نوع الخدمات التي يقدمها المتجر
            $table->string('logo')->nullable();
            $table->json('social_media_links')->nullable();
            $table->text('return_policy')->nullable(); // سياسة الارجاع
            $table->text('shipping_policy')->nullable();// سياسة الشحن
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->integer('rating_count')->default(0);

            $table->unique(['name']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
