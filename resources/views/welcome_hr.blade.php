@extends('layouts.app')

@section('content')
<div style="font-family: 'Cairo', sans-serif; direction: rtl; background: #f4f7fe; min-height: 100vh;">
    
    <div style="background: linear-gradient(135deg, #1a237e 0%, #3949ab 100%); padding: 80px 20px; text-align: center; color: white;">
        <h1 style="font-size: 3rem; font-weight: 800; mb-3;">نظام إدارة الموارد البشرية الذكي</h1>
        <p style="font-size: 1.2rem; opacity: 0.9; max-width: 700px; margin: 20px auto;">
            الحل المتكامل لإدارة بيانات الموظفين، الرواتب، والعمليات الإدارية بكل سهولة وكفاءة.
        </p>
        
        <div style="margin-top: 40px;">
            @auth
                <a href="{{ auth()->user()->role === 'admin' ? route('employees.index') : route('employees.profile') }}" 
                   style="background: #00c853; color: white; padding: 15px 40px; border-radius: 50px; text-decoration: none; font-weight: bold; font-size: 1.1rem; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                   دخول لوحة التحكم
                </a>
            @else
                <a href="{{ route('login') }}" 
                   style="background: #fff; color: #1a237e; padding: 15px 40px; border-radius: 50px; text-decoration: none; font-weight: bold; font-size: 1.1rem; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                   تسجيل الدخول للموظفين
                </a>
            @endauth
        </div>
    </div>

    <div style="max-width: 1200px; margin: -50px auto 50px; padding: 0 20px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            
            <div style="background: white; padding: 30px; border-radius: 20px; shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center; box-shadow: 0 10px 20px rgba(0,0,0,0.05);">
                <div style="font-size: 40px; margin-bottom: 15px;">👥</div>
                <h3 style="color: #1a237e;">إدارة الموظفين</h3>
                <p style="color: #666;">قاعدة بيانات شاملة لكل موظف تشمل المسمى الوظيفي والبيانات الشخصية.</p>
            </div>

            <div style="background: white; padding: 30px; border-radius: 20px; text-align: center; box-shadow: 0 10px 20px rgba(0,0,0,0.05);">
                <div style="font-size: 40px; margin-bottom: 15px;">📊</div>
                <h3 style="color: #1a237e;">هيكلة الرواتب</h3>
                <p style="color: #666;">تنظيم دقيق لرواتب الموظفين مع إمكانية التعديل للمدراء فقط.</p>
            </div>

            <div style="background: white; padding: 30px; border-radius: 20px; text-align: center; box-shadow: 0 10px 20px rgba(0,0,0,0.05);">
                <div style="font-size: 40px; margin-bottom: 15px;">🔐</div>
                <h3 style="color: #1a237e;">صلاحيات آمنة</h3>
                <p style="color: #666;">نظام حماية متطور يفرق بين صلاحيات المدير والموظف العادي.</p>
            </div>

        </div>
    </div>
</div>
@endsection