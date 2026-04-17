@extends('layouts.app')

@section('content')

<div class="card">
    <h3>إضافة موظف</h3>

    <form action="{{ route('employees.store') }}" method="POST">
        @csrf

        <label>الاسم:</label>
        <input type="text" name="name">

        <label>الإيميل:</label>
        <input type="email" name="email">

        <label>الوظيفة:</label>
        <input type="text" name="position">

        <label>الراتب:</label>
        <input type="number" name="salary">

        <button class="btn btn-success">حفظ</button>
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