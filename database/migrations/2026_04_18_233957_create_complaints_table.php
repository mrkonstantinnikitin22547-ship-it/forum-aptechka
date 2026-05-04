<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('complaints_table', function (Blueprint $table) {
            $table->id();

            // кто пожаловался
            $table->foreignId('from_user_id')->constrained('users')->onDelete('cascade');

            // на кого жалоба
            $table->foreignId('to_user_id')->constrained('users')->onDelete('cascade');

            // из какого сообщения
            $table->foreignId('reply_id')->constrained('topic_replies')->onDelete('cascade');

            $table->text('reason')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints_table');
    }
};