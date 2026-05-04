@extends('layouts.app')

@section('title', 'Техподдержка - Аптечка')

@section('content')
<h1 class="page-title">Техподдержка</h1>

<div class="content-layout">
    <div class="main-area">

        {{-- Большой стеклянный блок формы --}}
        <div class="glass-section">
            <h2 class="glass-title">Форма обратной связи</h2>

            <form action="{{ route('contact.store') }}" method="POST">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name" class="form-label">Имя</label>
                        <input type="text" id="first_name" name="first_name" class="form-control glass-input" required placeholder="Введите ваше имя">
                    </div>

                    <div class="form-group">
                        <label for="last_name" class="form-label">Логин</label>
                        <input type="text" id="last_name" name="last_name" class="form-control glass-input" required placeholder="Введите ваш логин">
                    </div>
                </div>

                <div class="form-group">
                    <label for="support_email" class="form-label">Электронная почта</label>
                    <input type="email" id="support_email" name="email" class="form-control glass-input" required placeholder="Введите вашу электронную почту">
                </div>

                <div class="form-group">
                    <label for="message" class="form-label">Ваше сообщение</label>
                    <textarea id="message" name="message" class="form-control glass-input" rows="8" required placeholder="Кратко опишите вашу проблему"></textarea>
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <button type="submit" class="btn btn-primary btn-block">Отправить</button>
                </div>
            </form>
        </div>

    </div>

    <aside class="sidebar">

        <div class="widget">
            <h3 class="widget-title">Контакты</h3>
            <div class="category-item" style="background: transparent; box-shadow:none;">
                <p><strong>Email:</strong> support@aptechka.ru</p>
                <p><strong>Телефон:</strong> 8-800-123-45-67</p>
            </div>
        </div>

        <div class="widget">
            <h3 class="widget-title">Частые вопросы</h3>
            <ul class="category-list">
                <li class="category-item">
                    <span class="category-name">Как создать тему?</span>
                </li>
                <li class="category-item">
                    <span class="category-name">Как изменить пароль?</span>
                </li>
                <li class="category-item">
                    <span class="category-name">Правила форума</span>
                </li>
                <li class="category-item">
                    <span class="category-name">Как пожаловаться на пользователя?</span>
                </li>
            </ul>
        </div>

    </aside>
</div>
@endsection