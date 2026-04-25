@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm mx-auto" style="max-width: 500px; border-radius: 15px;">
        <div class="card-header bg-dark text-white text-center py-3">
            <h4 class="mb-0">تحديث بيانات الحساب</h4>
        </div>
        <div class="card-body p-4">
            {{-- تم استبدال $employee->id بـ $employee->employee_number هنا --}}
            <form action="{{ route('employees.update', $employee->employee_number) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- عرض الرقم الوظيفي كمعلومات فقط للتأكيد --}}
                <div class="mb-3 text-end">
                    <label class="form-label text-muted">الرقم الوظيفي</label>
                    <input type="text" value="{{ $employee->employee_number }}" class="form-control bg-light text-end" readonly>
                </div>

                <div class="mb-3 text-end">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ $employee->email }}" class="form-control text-end">
                </div>

                <div class="mb-3 text-end">
                    <label class="form-label">كلمة المرور الجديدة (اختياري)</label>
                    <input type="password" name="password" class="form-control text-end" placeholder="اتركها فارغة لعدم التغيير">
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">حفظ التغييرات</button>
                <a href="{{ route('employees.profile') }}" class="btn btn-link w-100 text-muted mt-2">إلغاء</a>
            </form>
        </div>
    </div>
</div>
@endsection