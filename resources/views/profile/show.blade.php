@extends('layouts.app')

@section('title', 'Личный кабинет - Аптечка')

@section('content')
<div class="profile-container">

    <h1 class="page-title-profile">Личный кабинет</h1>

    @php
    $tab = request('tab', 'info');
    @endphp

    <div class="profile-layout">

        {{-- SIDEBAR --}}
        <aside class="sidebar-profile">

            <a href="{{ route('profile', ['tab' => 'info']) }}"
                class="nav-link {{ $tab === 'info' ? 'active' : '' }}">
                Личный кабинет
            </a>

            <a href="{{ route('profile', ['tab' => 'topics']) }}"
                class="nav-link {{ $tab === 'topics' ? 'active' : '' }}">
                Мои обсуждения
            </a>

            <a href="{{ route('profile', ['tab' => 'support']) }}"
                class="nav-link {{ $tab === 'support' ? 'active' : '' }}">
                Чат поддержки
            </a>

        </aside>

        {{-- CONTENT --}}
        <div class="profile-main">

            {{-- 1. ЛИЧНЫЙ КАБИНЕТ --}}
            @if($tab === 'info')

            <div class="profile-info">

                <div class="profile-avatar">
                    @if($user->avatar)
                    <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Аватар">
                    @else
                    <div class="avatar-placeholder">
                        <i class="fas fa-user"></i>
                    </div>
                    @endif
                </div>

                <div class="profile-details">
                    <h2>{{ $user->name }}</h2>

                    <p><strong>Email:</strong> {{ $user->email }}</p>

                    @if($user->login)
                    <p><strong>Логин:</strong> {{ $user->login }}</p>
                    @endif

                    @if($user->is_admin)
                    <span class="badge badge-admin">Администратор</span>
                    @else
                    <span class="badge badge-user">Пользователь</span>
                    @endif

                    @if($user->bio)
                    <div class="bio-section">
                        <h3>О себе:</h3>
                        <p>{{ $user->bio }}</p>
                    </div>
                    @endif

                    @if($user->city)
                    <p><strong>Город:</strong> {{ $user->city }}</p>
                    @endif

                    @if($user->diagnosis)
                    <p><strong>Диагноз:</strong> {{ $user->diagnosis }}</p>
                    @endif

                    <p><strong>Зарегистрирован:</strong> {{ $user->created_at->format('d.m.Y') }}</p>
                </div>

                @if(session('password_success'))
                    <p style="color:green;">{{ session('password_success') }}</p>
                @endif

                @if(session('password_error'))
                    <p style="color:red;">{{ session('password_error') }}</p>
                @endif

                <button type="button" class="btn btn-primary" onclick="openPasswordModal()">
                    Изменить пароль
                </button>
            </div>

            {{-- 2. МОИ ОБСУЖДЕНИЯ --}}
            @elseif($tab === 'topics')

            <div class="widget">
                <h3 class="widget-title">Мои обсуждения</h3>

                @forelse($topics as $topic)
                <div class="discussion-item">

                    <a href="{{ route('topics.show', $topic->id) }}" class="discussion-link">
                        {{ $topic->title }}
                    </a>

                    <span class="discussion-date">
                        {{ $topic->created_at->format('d.m.Y H:i') }}
                    </span>

                </div>
                @empty
                <div class="empty">Нет активности</div>
                @endforelse
            </div>

            @elseif($tab === 'support')

            @php
            $chat = auth()->user()->supportChat;
            $messages = $chat
            ? $chat->messages()->oldest()->get()
            : collect();
            @endphp

            <div class="support-chat">

                <h3>💬 Чат с поддержкой</h3>

                <div class="chat-box">

                    @forelse($messages as $message)

                    <div class="
                        chat-message
                        {{ $message->sender_type === 'user' ? 'user-message' : 'admin-message' }}
                    ">

                        <div class="message-author">
                            {{ $message->sender_type === 'user' ? auth()->user()->name : 'Админ' }}
                        </div>

                        <div class="message-text">
                            {{ $message->message }}
                        </div>

                    </div>

                    @empty

                    <p class="empty">
                        Пока нет сообщений. Начните диалог с поддержкой.
                    </p>

                    @endforelse

                </div>

                <form
                    method="POST"
                    action="{{ route('profile.support.send') }}"
                    class="support-form">

                    @csrf

                    <textarea class="form-chat-admin"
                        name="message"
                        required
                        placeholder="Напишите сообщение поддержке..."></textarea>

                    <button
                        type="submit"
                        class="btn btn-primary">
                        Отправить
                    </button>

                </form>
            </div>

            @endif

        </div>

    </div>
</div>
<div id="passwordModal" class="modal-overlay">
    <div class="modal-container">

        <div class="modal-header">
            <h3>Изменение пароля</h3>
            <button type="button" class="modal-close" onclick="closePasswordModal()">×</button>
        </div>

        <div class="modal-body">

            @if($errors->any())
                <div style="color:red; margin-bottom:10px;">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('profile.password.update') }}">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label class="form-label">Текущий пароль</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Новый пароль</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Повторите новый пароль</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    Сохранить пароль
                </button>
            </form>

        </div>
    </div>
</div>

<script>
    function openPasswordModal() {
        document.getElementById('passwordModal').classList.add('active');
    }

    function closePasswordModal() {
        document.getElementById('passwordModal').classList.remove('active');
    }
</script>

@endsection