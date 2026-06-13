<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('isbn')->nullable()->unique();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained()->nullOnDelete();
            $table->string('publisher')->nullable();
            $table->year('published_year')->nullable();
            $table->string('language')->default('Bangla');
            $table->integer('pages')->nullable();
            $table->string('edition')->nullable();
            $table->decimal('purchase_price', 10, 2)->default(0);
            $table->decimal('market_price', 10, 2)->default(0);
            $table->date('purchase_date')->nullable();
            $table->string('cover_image')->nullable();
            $table->enum('status', ['wishlist','ordered','to_read','reading','completed'])->default('to_read');
            $table->string('genre')->default('other');
            $table->tinyInteger('rating')->nullable();
            $table->text('notes')->nullable();
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->boolean('is_ebook')->default(false);
            $table->string('ebook_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void { Schema::dropIfExists('books'); }
};
