@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Сброс пароля</h2>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ $email }}" required>
        </div>

        <div>
            <label>Новый пароль</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label>Подтвердите пароль</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit">Сменить пароль</button>
    </form>
</div>
@endsection