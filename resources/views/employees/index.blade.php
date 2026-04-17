@extends('layouts.app')

@section('content')

<div class="card">

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color: red">{{ session('error') }}</p>
    @endif

    <a href="{{ route('employees.create') }}" class="btn btn-success">إضافة موظف</a>

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
            ">
            🤖OperationGPT
    </a>

    <table border="1" width="100%" style="margin-top:20px;">
        <tr>
            <th>الاسم</th>
            <th>الإيميل</th>
            <th>الوظيفة</th>
            <th>الراتب</th>
            <th>إجراءات</th>
        </tr>

        @foreach($employees as $employee)
        <tr>
            <td>{{ $employee->name }}</td>
            <td>{{ $employee->email }}</td>
            <td>{{ $employee->position }}</td>
            <td>{{ $employee->salary }}</td>
            <td>
                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary">تعديل</a>

                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">حذف</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    <br>
    {{ $employees->links() }}

</div>

@endsection