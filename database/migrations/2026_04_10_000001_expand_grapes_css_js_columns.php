<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Visual builder CSS/JS can exceed MySQL TEXT (~64KB) when Contact Us
 * templates or theme rules accumulate — causing generic "Server Error" on save.
 */
return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('pages')) {
            return;
        }

        if (Schema::hasColumn('pages', 'grapes_css')) {
            DB::statement('ALTER TABLE `pages` MODIFY `grapes_css` LONGTEXT NULL');
        }
        if (Schema::hasColumn('pages', 'grapes_js')) {
            DB::statement('ALTER TABLE `pages` MODIFY `grapes_js` LONGTEXT NULL');
        }
        if (Schema::hasColumn('pages', 'styles')) {
            DB::statement('ALTER TABLE `pages` MODIFY `styles` LONGTEXT NULL');
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('pages')) {
            return;
        }

        if (Schema::hasColumn('pages', 'grapes_css')) {
            DB::statement('ALTER TABLE `pages` MODIFY `grapes_css` TEXT NULL');
        }
        if (Schema::hasColumn('pages', 'grapes_js')) {
            DB::statement('ALTER TABLE `pages` MODIFY `grapes_js` TEXT NULL');
        }
        if (Schema::hasColumn('pages', 'styles')) {
            DB::statement('ALTER TABLE `pages` MODIFY `styles` TEXT NULL');
        }
    }
};
