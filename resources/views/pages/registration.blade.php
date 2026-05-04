@extends('layouts.app')

@section('title', 'Регистрация - Аптечка')

@section('content')
    <div class="registration-layout">
        <div class="registration-form">
            <h1 class="page-title">Регистрация</h1>
            
            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="login" class="form-label">Логин</label>
                    <input type="text" id="login" name="login" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">Электронная почта</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="password" class="form-label">Придумайте пароль</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Повторите пароль</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Зарегистрироваться</button>
                </div>
                
                <div class="form-footer">
                    <p>У меня уже есть аккаунт</p>
                    <a href="{{ route('login') }}" class="btn" style="background-color: var(--border-color); color: var(--text-color);">Войти</a>
                </div>
            </form>
        </div>
        
        <aside class="sidebar">
            <div class="widget">
                <h3 class="widget-title">Количество участников</h3>
                <div class="members-count">
                    <div class="count-number">43</div>
                    <div class="count-label">активных участников</div>
                </div>
            </div>
            
            <div class="widget">
                <h3 class="widget-title">Темы</h3>
                <ul class="topic-list">
                    <li class="topic-item">
                        <div class="topic-title">Диабет</div>
                        <div class="topic-meta">Проблемы/вопросы</div>
                    </li>
                    <li class="topic-item">
                        <div class="topic-title">Диабет</div>
                        <div class="topic-meta">Проблемы/вопросы</div>
                    </li>
                    <li class="topic-item">
                        <div class="topic-title">Диабет</div>
                        <div class="topic-meta">Обсуждение лечения</div>
                    </li>
                </ul>
            </div>
            
            <div class="widget">
                <h3 class="widget-title">Создать тему</h3>
                <ul class="category-list">
                    <li class="category-item">
                        <span class="category-name">Вирусы</span>
                    </li>
                    <li class="category-item">
                        <span class="category-name">Инфекционные заболевания</span>
                    </li>
                    <li class="category-item">
                        <span class="category-name">Заболевания печени</span>
                    </li>
                </ul>
            </div>
        </aside>
    </div>
@endsection