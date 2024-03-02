<?php

use App\Models\User;
use App\Models\Store;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Store::class)->nullable()->constrained()->nullOnDelete();
            $table->string('code')->unique();
            $table->string('payment_method')->default('PayPal');
            $table->enum('status',['pending','processing','delivering','completed','cancelled','refunded'])->default('pending');
            $table->enum('payment_status',['pending','paid','failed'])->default('pending');
            $table->float('tax')->default(0);
            $table->float('discount')->default(0);
            $table->float('total')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
