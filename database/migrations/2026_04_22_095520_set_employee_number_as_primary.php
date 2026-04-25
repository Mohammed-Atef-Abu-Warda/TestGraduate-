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
        // 1. حذف المفتاح الأساسي الحالي من عمود id
        // ملاحظة: إذا كان الـ id هو increments، يجب حذف الـ auto-increment أولاً
        $table->bigInteger('id')->change(); 
        $table->dropPrimary('id');

        // 2. جعل employee_number هو المفتاح الأساسي
        $table->primary('employee_number');
    });
}

public function down(): void
{
    Schema::table('employees', function (Blueprint $table) {
        $table->dropPrimary('employee_number');
        $table->primary('id');
        $table->bigIncrements('id')->change();
    });
}
};


