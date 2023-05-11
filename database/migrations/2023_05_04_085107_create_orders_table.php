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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('storehouse_id')->nullable()->constrained();
            $table->foreignId('company_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('client_id')->nullable()->constrained();
            $table->double('amount')->default(0);
            $table->double('profit')->default(0);
            $table->tinyInteger('status')->default(\App\Models\Order::STATUS_SOLD);
            $table->string('cancel_reason')->nullable();
            $table->softDeletes();
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
