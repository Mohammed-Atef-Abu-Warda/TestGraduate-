@extends('layouts.app')

@section('content')

<div class="card">
    <h3>تعديل موظف</h3>

    <form action="{{ route('employees.update', $employee->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>الاسم:</label>
        <input type="text" name="name" value="{{ $employee->name }}">

        <label>الإيميل:</label>
        <input type="email" name="email" value="{{ $employee->email }}">

        <label>الوظيفة:</label>
        <input type="text" name="position" value="{{ $employee->position }}">

        <label>الراتب:</label>
        <input type="number" name="salary" value="{{ $employee->salary }}">

        <button class="btn btn-primary">تحديث</button>
    </form>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</div>

@endsection