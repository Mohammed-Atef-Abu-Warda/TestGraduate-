@extends('layouts.app')

@section('content')

<div class="card">

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color: red">{{ session('error') }}</p>
    @endif

    @if(auth()->check() && auth()->user()->role === 'admin')
        <div class="mb-3">
            <a href="{{ route('employees.create') }}" class="btn btn-success">
                إضافة موظف جديد
            </a>
        </div>
    @endif

    {{-- زر الذكاء الاصطناعي العائم --}}
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

    <table border="1" width="100%" style="margin-top:20px; text-align: center; border-collapse: collapse;">
        <tr style="background-color: #f2f2f2;">
            <th>الرقم الوظيفي</th> 
            <th>الاسم</th>
            <th>الإيميل</th>
            <th>الوظيفة (Position)</th>
            <th>الراتب</th>
            <th>إجراءات</th>
        </tr>

        @foreach($employees as $emp)
            <tr>
                <td style="font-weight: bold; color: #6366f1;">{{ $emp->employee_number }}</td>
                
                <td>{{ $emp->name }}</td>
                
                <td>{{ $emp->email }}</td>
                
                <td>{{ $emp->position }}</td>
                
                <td>{{ number_format($emp->salary, 2) }}</td>
                
                <td>
                    {{-- تم التعديل هنا: استخدام employee_number بدلاً من id --}}
                    @if(Auth::user()->role === 'admin' || Auth::user()->employee_number === $emp->employee_number)
                        <a href="{{ route('employees.edit', $emp->employee_number) }}" style="margin-left: 10px;">تعديل</a>
                    @endif

                    {{-- تم التعديل هنا أيضاً في رابط الحذف --}}
                    @if(Auth::user()->role === 'admin')
                        <form action="{{ route('employees.destroy', $emp->employee_number) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
    
    <br>
    {{ $employees->links() }}

</div>

@endsection