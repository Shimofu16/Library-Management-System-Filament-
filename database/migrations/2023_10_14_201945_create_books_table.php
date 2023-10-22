<?php

use App\Enums\BookGenreEnum;
use App\Enums\BookStatusEnum;
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

        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('authors')->onUpdate('cascade');
            $table->string('cover');
            $table->string('title');
            $table->string('synopsis');
            $table->string('genre');
            $table->foreignId('publisher_id')->constrained('publishers')->onUpdate('cascade');
            $table->date('publication_date');
            $table->string('isbn');
            $table->integer('stock');
            $table->integer('initial_stock')->nullable();
            $table->enum('status',BookStatusEnum::toArray())->default(BookStatusEnum::AVAILABLE);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
