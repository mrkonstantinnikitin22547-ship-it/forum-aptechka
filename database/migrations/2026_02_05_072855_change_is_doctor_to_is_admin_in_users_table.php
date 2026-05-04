<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('users', 'is_doctor') && !Schema::hasColumn('users', 'is_admin')) {
            // PostgreSQL вариант (без ` и без CHANGE)
            DB::statement('ALTER TABLE users RENAME COLUMN is_doctor TO is_admin');
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'is_admin') && !Schema::hasColumn('users', 'is_doctor')) {
            DB::statement('ALTER TABLE users RENAME COLUMN is_admin TO is_doctor');
        }
    }
};