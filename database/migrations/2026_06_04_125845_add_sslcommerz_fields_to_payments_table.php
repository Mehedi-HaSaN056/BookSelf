<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('vendor_name')->nullable()->after('method');
            $table->string('vendor_phone')->nullable()->after('vendor_name');
            $table->string('method_number')->nullable()->after('vendor_phone');
            $table->string('gateway_response')->nullable()->after('method_number');
        });
    }
    public function down(): void {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['vendor_name','vendor_phone','method_number','gateway_response']);
        });
    }
};