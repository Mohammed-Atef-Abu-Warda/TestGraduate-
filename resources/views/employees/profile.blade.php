@extends('layouts.app')

@section('content')
<div style="background-color: #f0f2f5; min-height: 100vh; padding: 40px 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; direction: rtl;">
    <div style="max-width: 500px; margin: 0 auto; background: #fff; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
        
        <div style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); padding: 40px 20px; text-align: center; color: white;">
            <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 32px; font-weight: bold; border: 2px solid #fff;">
                {{ mb_substr($employee->name, 0, 2) }}
            </div>
            <h2 style="margin: 0; font-size: 24px;">{{ $employee->name }}</h2>
            <p style="margin: 5px 0 0; opacity: 0.9; font-size: 16px;">{{ $employee->position }}</p>
        </div>

        <div style="padding: 30px;">
            {{-- إضافة عرض الرقم الوظيفي هنا كمعرف أساسي --}}
            <div style="margin-bottom: 20px; padding: 15px; background: #fefce8; border-radius: 10px; border-right: 5px solid #eab308;">
                <small style="color: #64748b; display: block; margin-bottom: 5px;">الرقم الوظيفي</small>
                <span style="color: #1e293b; font-weight: bold; font-size: 16px;">{{ $employee->employee_number }}</span>
            </div>

            <div style="margin-bottom: 20px; padding: 15px; background: #f8fafc; border-radius: 10px; border-right: 5px solid #4f46e5;">
                <small style="color: #64748b; display: block; margin-bottom: 5px;">البريد الإلكتروني</small>
                <span style="color: #1e293b; font-weight: bold; font-size: 16px;">{{ $employee->email }}</span>
            </div>

            <div style="margin-bottom: 30px; padding: 15px; background: #f0fdf4; border-radius: 10px; border-right: 5px solid #22c55e;">
                <small style="color: #64748b; display: block; margin-bottom: 5px;">الراتب الشهري</small>
                <span style="color: #1e293b; font-weight: bold; font-size: 16px;">{{ number_format($employee->salary, 2) }} ريال</span>
            </div>

            {{-- استبدال id بـ employee_number في الرابط --}}
            <a href="{{ route('employees.edit', $employee->employee_number) }}" 
               style="display: block; width: 100%; padding: 15px; background: #4f46e5; color: white; text-align: center; text-decoration: none; border-radius: 10px; font-weight: bold; transition: background 0.3s;">
                ⚙️ تعديل بياناتي
            </a>
            
            <a href="{{ route('employees.dashboard') }}" 
            style="display: block; text-align: center; margin-top: 15px; color: #64748b; text-decoration: none; font-size: 14px; font-weight: bold;">
            🏠 العودة لصفحة التحكم (Dashboard)
            </a>        
        </div>
    </div>
</div>

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