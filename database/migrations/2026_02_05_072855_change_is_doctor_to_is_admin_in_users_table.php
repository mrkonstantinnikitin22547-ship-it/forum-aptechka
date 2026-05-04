<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Выполняем только если есть is_doctor и ещё нет is_admin
        if (Schema::hasColumn('users', 'is_doctor') && !Schema::hasColumn('users', 'is_admin')) {
            // Для старых MySQL/MariaDB rename column не поддерживается,
            // поэтому используем CHANGE и явно указываем тип.
            // Тип TINYINT(1) подходит для boolean.
            DB::statement("ALTER TABLE `users` CHANGE `is_doctor` `is_admin` TINYINT(1) NOT NULL DEFAULT 0");
        }
    }

    public function down(): void
    {
        // Откат только если есть is_admin и ещё нет is_doctor
        if (Schema::hasColumn('users', 'is_admin') && !Schema::hasColumn('users', 'is_doctor')) {
            DB::statement("ALTER TABLE `users` CHANGE `is_admin` `is_doctor` TINYINT(1) NOT NULL DEFAULT 0");
        }
    }
};
