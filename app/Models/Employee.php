<?php

namespace App\Models;

// 1. استيراد كلاس Authenticatable بدلاً من Model العادي
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// 2. جعل الكلاس يرث من Authenticatable
class Employee extends Authenticatable
{
    use HasFactory, Notifiable;

    // اسم الجدول في قاعدة البيانات
    protected $table = 'employees';

    // أخبر لارافيل بالاسم الجديد للمفتاح الأساسي
    protected $primaryKey = 'employee_number';

    // إذا كان الرقم الوظيفي نصاً (String) وليس رقماً تلقائياً
    public $incrementing = false;
    protected $keyType = 'string';

    // الحقول التي يمكن تعبئتها
    protected $fillable = [
        'name',
        'email',
        'password',
        'position',
        'salary',
        'role',
        'employee_number',
    ];

    // الحقول التي يجب إخفاؤها (مثل الباسورد)
    protected $hidden = [
        'password',
        'remember_token',
    ];
}