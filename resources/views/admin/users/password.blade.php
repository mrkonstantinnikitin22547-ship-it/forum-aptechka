@extends('admin.layout')

@section('content')

<h1>Смена пароля</h1>

@if($errors->any())
    <div style="color:red;">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('admin.users.password.update', $user->id) }}">
    @csrf
    @method('PATCH')

    <div style="margin-bottom:10px;">
        <label>Новый пароль:</label><br>
        <input type="password" name="password" required>
    </div>

    <div style="margin-bottom:10px;">
        <label>Подтвердите пароль:</label><br>
        <input type="password" name="password_confirmation" required>
    </div>

    <button type="submit" class="admin-btn">
        Сохранить
    </button>

    <a href="{{ route('admin.users') }}" class="admin-btn">
        Назад
    </a>

</form>

@endsection