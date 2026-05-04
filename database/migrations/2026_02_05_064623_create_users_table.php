<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Добавляем новые поля
            $table->string('login')->unique()->nullable()->after('email');
            $table->string('avatar')->nullable()->after('password');
            $table->text('bio')->nullable()->after('avatar');
            $table->string('phone')->nullable()->after('bio');
            $table->date('birth_date')->nullable()->after('phone');
            $table->string('city')->nullable()->after('birth_date');
            $table->string('diagnosis')->nullable()->after('city');
            $table->boolean('is_doctor')->default(false)->after('diagnosis');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Удаляем добавленные поля при откате миграции
            $table->dropColumn([
                'login',
                'avatar',
                'bio',
                'phone',
                'birth_date',
                'city',
                'diagnosis',
                'is_doctor'
            ]);
        });
    }
};