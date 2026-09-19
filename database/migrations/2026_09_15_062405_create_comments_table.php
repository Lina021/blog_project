<?php

use App\Models\Post;
use App\Models\User;
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
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // BIGINT AUTO_INCREMENT
            $table->foreignIdFor(Post::class)->constrained()->cascadeOnDelete(); // BIGINT foreign key to posts
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete(); // BIGINT foreign key to users
            $table->text('comment'); // TEXT
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
