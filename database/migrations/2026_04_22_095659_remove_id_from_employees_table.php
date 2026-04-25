<?php

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
    Schema::table('employees', function (Blueprint $table) {
        // 1. حذف المفتاح الأساسي (Primary Key) عن عمود id
        $table->dropPrimary('id'); 
        
        // 2. حذف عمود id نفسه
        $table->dropColumn('id');
        
        // 3. تعيين employee_number كمفتاح أساسي جديد
        $table->primary('employee_number');
    });
}

public function down(): void
{
    Schema::table('employees', function (Blueprint $table) {
        // للتراجع عن العملية (إعادة id)
        $table->bigIncrements('id')->first();
        $table->dropPrimary('employee_number');
        $table->primary('id');
    });
}
};
