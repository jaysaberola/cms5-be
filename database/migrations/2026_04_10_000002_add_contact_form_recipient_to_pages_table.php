<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            if (! Schema::hasColumn('pages', 'contact_form_recipient')) {
                $table->string('contact_form_recipient')->nullable()->after('meta_description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            if (Schema::hasColumn('pages', 'contact_form_recipient')) {
                $table->dropColumn('contact_form_recipient');
            }
        });
    }
};
