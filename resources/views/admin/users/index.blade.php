@extends('admin.layout')

@section('content')

<h1>Управление пользователями</h1>

@if(session('success'))
<p style="color:green;">{{ session('success') }}</p>
@endif

@if(session('error'))
<p style="color:red;">{{ session('error') }}</p>
@endif

<table class="admin-table">
    <tr>
        <th>#</th>
        <th>Имя</th>
        <th>Email</th>
        <th>Роль</th>
        <th>Статус</th>
        <th>Действия</th>
    </tr>

    @forelse($users as $user)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->role }}</td>
        <td>
            @if($user->is_banned)
            <span style="color:red;">Заблокирован</span>
            @else
            <span style="color:green;">Активен</span>
            @endif
        </td>
        <td>

            @if($user->id !== auth()->id())

            {{-- Блокировка --}}
            <form method="POST"
                action="{{ route('admin.users.ban', $user->id) }}"
                onsubmit="return confirmBan('{{ $user->name }}', {{ $user->is_banned ? 'true' : 'false' }})"
                style="display:inline;">

                @csrf
                @method('PATCH')

                <button type="submit"
                    class="admin-btn {{ $user->is_banned ? 'btn-success' : 'btn-danger' }}">
                    {{ $user->is_banned ? 'Разблокировать' : 'Заблокировать' }}
                </button>
            </form>

            {{-- Сделать админом --}}
            <form action="{{ route('admin.users.role', $user->id) }}"
                method="POST"
                style="display:inline;">

                @csrf
                @method('PATCH')

                <button class="admin-btn" type="submit">
                    Сделать админом
                </button>
            </form>

            {{-- Смена пароля --}}
            <a href="{{ route('admin.users.password.edit', $user->id) }}" class="admin-btn">
                Сменить пароль
            </a>

            @else
            <span style="color:gray;">Недоступно</span>
            @endif

        </td>
    </tr>

    @empty
    <tr>
        <td colspan="6" style="text-align:center; padding:20px;">
            Пользователей пока нет
        </td>
    </tr>
    @endforelse

</table>

@endsection