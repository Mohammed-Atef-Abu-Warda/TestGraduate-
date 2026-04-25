@extends('layouts.app')

@section('content')
<div style="background: #f4f7fe; min-height: 100vh; padding: 40px 20px; font-family: 'Cairo', sans-serif; direction: rtl;">
    <div style="max-width: 1000px; margin: 0 auto;">
        
        <div style="margin-bottom: 30px;">
            <h1 style="color: #1a237e; font-weight: 800;">مرحباً بك، {{ Auth::user()->name }} 👋</h1>
            {{-- إضافة عرض الرقم الوظيفي هنا لسهولة استخدامه في المحادثة مع AI --}}
            <p style="color: #64748b;">الرقم الوظيفي الخاص بك: <span style="font-weight: bold; color: #4f46e5;">{{ Auth::user()->employee_number }}</span></p>
            <p style="color: #64748b;">إليك نظرة سريعة على أدواتك المتاحة اليوم</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px;">
            
            {{-- ملاحظة: رابط الملف الشخصي لا يحتاج معامل id لأنه غالباً يجلب بيانات المستخدم الحالي Auth::user() --}}
            <a href="{{ route('employees.profile') }}" style="text-decoration: none; color: inherit;">
                <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 20px rgba(0,0,0,0.05); transition: 0.3s; border-bottom: 5px solid #4f46e5;">
                    <div style="font-size: 40px; margin-bottom: 15px;">👤</div>
                    <h3 style="margin-bottom: 10px; color: #1e293b;">عرض الملف الشخصي</h3>
                    <p style="color: #64748b; font-size: 14px;">شاهد بياناتك الوظيفية، الراتب، وقم بتحديث معلوماتك الشخصية.</p>
                </div>
            </a>

            <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 20px rgba(0,0,0,0.05); opacity: 0.7; cursor: not-allowed; border-bottom: 5px solid #22c55e;">
                <div style="font-size: 40px; margin-bottom: 15px;">📅</div>
                <h3 style="margin-bottom: 10px; color: #1e293b;">المهام اليومية</h3>
                <p style="color: #64748b; font-size: 14px;">قريباً: ستتمكن من رؤية قائمة المهام المطلوبة منك هنا.</p>
            </div>

            <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 20px rgba(0,0,0,0.05); border-bottom: 5px solid #ef4444;">
                <div style="font-size: 40px; margin-bottom: 15px;">🛠️</div>
                <h3 style="margin-bottom: 10px; color: #1e293b;">طلب مساعدة</h3>
                <p style="color: #64748b; font-size: 14px;">هل لديك مشكلة؟ تواصل مع قسم الموارد البشرية مباشرة.</p>
            </div>

        </div>
    </div>
</div>

<style>
    /* تأثير التحويم للبطاقات */
    div[style*="background: white"]:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(79, 70, 229, 0.1) !important;
    }
</style>

<a href="{{ route('operation-gpt.index') }}" 
        style="
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: #6366f1;
            color: white;
            padding: 15px;
            border-radius: 50%;
            text-decoration: none;
            font-size: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            z-index: 1000;
            ">
            🤖OperationGPT
    </a>
@endsection