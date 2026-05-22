<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('settings')->insertOrIgnore([
            'key'   => 'openai',
            'value' => json_encode([
                'api_key' => '',
                'model'   => 'gpt-4o',
            ]),
        ]);
    }

    public function down(): void
    {
        DB::table('settings')->where('key', 'openai')->delete();
    }
};
