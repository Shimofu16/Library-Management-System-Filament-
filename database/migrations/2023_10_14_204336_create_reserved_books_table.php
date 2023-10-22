<?php

use App\Enums\FulfillmentStatusEnum;
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
        Schema::create('reserved_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books');
            $table->foreignId('borrower_id')->constrained('borrowers');
            $table->date('reservation_date');
            $table->date('due_date')->default(now()->addDays(3));
            $table->enum('fulfillment_status',FulfillmentStatusEnum::toArray())->default(FulfillmentStatusEnum::PENDING);
            $table->string('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserved_books');
    }
};
