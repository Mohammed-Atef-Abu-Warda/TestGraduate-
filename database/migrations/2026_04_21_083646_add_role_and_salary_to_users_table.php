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
            // إضافة حقل الصلاحية وتحديد قيمته الافتراضية كموظف
            // استخدمنا after لترتيب ظهور الحقل في قاعدة البيانات بعد حقل الإيميل
            $table->string('role')->default('employee')->after('email'); 
            
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
