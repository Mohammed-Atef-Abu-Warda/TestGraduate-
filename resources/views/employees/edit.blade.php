@extends('layouts.app')

@section('content')

<div class="card p-4 shadow-sm" style="max-width: 600px; margin: 20px auto; direction: rtl; border-radius: 15px;">
    <h3 class="mb-4 text-center text-primary">تعديل بيانات الموظف</h3>

    {{-- تم استبدال id بـ employee_number في رابط الـ action --}}
    <form action="{{ route('employees.update', $employee->employee_number) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- عرض الرقم الوظيفي كحقل للقراءة فقط لضمان عدم ضياع الهوية --}}
        <div class="mb-3">
            <label class="form-label fw-bold text-muted">الرقم الوظيفي (لا يمكن تعديله):</label>
            <input type="text" value="{{ $employee->employee_number }}" class="form-control bg-light" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">الاسم:</label>
            <input type="text" name="name" value="{{ old('name', $employee->name) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">الإيميل:</label>
            <input type="email" name="email" value="{{ old('email', $employee->email) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">الوظيفة:</label>
            <input type="text" name="position" value="{{ old('position', $employee->position) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">الراتب:</label>
            <input type="number" step="0.01" name="salary" value="{{ old('salary', $employee->salary) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">الصلاحية (Role):</label>
            <select name="role" class="form-select">
                <option value="employee" {{ $employee->role == 'employee' ? 'selected' : '' }}>موظف عادي</option>
                <option value="admin" {{ $employee->role == 'admin' ? 'selected' : '' }}>مدير (Admin)</option>
            </select>
            <small class="text-muted">تغيير الصلاحية يؤثر على صفحات الوصول للنظام.</small>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">كلمة المرور الجديدة (اختياري):</label>
            <input type="password" name="password" class="form-control" placeholder="اتركها فارغة لعدم التغيير">
        </div>

        <hr>

        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">تحديث البيانات</button>
        <a href="{{ route('employees.index') }}" class="btn btn-light w-100 mt-2">إلغاء والعودة</a>
    </form>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

@endsection