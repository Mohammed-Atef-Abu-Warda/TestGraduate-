@extends('layouts.app')

@section('content')

<div class="card">
    <h3>إضافة موظف جديد</h3>

    <form action="{{ route('employees.store') }}" method="POST">
    @csrf
        {{-- حقل الرقم الوظيفي الجديد --}}
        <div class="mb-3">
            <label for="employee_number">الرقم الوظيفي:</label>
            <input type="text" name="employee_number" id="employee_number" placeholder="مثلاً: EMP-2026-001" value="{{ old('employee_number') }}" required>
            <small style="display: block; color: #666;">يجب أن يكون الرقم الوظيفي فريداً لكل موظف.</small>
        </div>
        
        <input type="text" name="name" placeholder="الاسم الكامل" value="{{ old('name') }}" required>
        
        <input type="text" name="position" placeholder="المسمى الوظيفي (مثلاً: مدير تسويق)" value="{{ old('position') }}" required>
        
        <input type="email" name="email" placeholder="البريد الإلكتروني" value="{{ old('email') }}" required>
        
        <input type="password" name="password" placeholder="كلمة المرور" required>
        
        <input type="number" step="0.01" name="salary" placeholder="الراتب الشهري" value="{{ old('salary') }}" required>
        
        <div class="mb-3">
            <label>صلاحية النظام:</label>
            <select name="role">
                <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>موظف (تعديل محدود)</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>مدير (تحكم كامل)</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-success">إضافة الموظف</button>
    </form>

    @if ($errors->any())
        <div style="color:red; margin-top: 20px; border: 1px solid red; padding: 10px;">
            <strong>هناك أخطاء في المدخلات:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</div>

@endsection