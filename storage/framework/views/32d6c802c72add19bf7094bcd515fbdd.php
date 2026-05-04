<header class="site-header">
    <div class="container">
        <div class="header-content">
            <nav class="main-nav">
                <div class="nav-container">

                    <ul class="nav-list">
                        <li class="logo">
                            <img class="logo_img" src="<?php echo e(asset('img/logo-7.png')); ?>" alt="logo">
                            <div>
                                <h1>Аптечка</h1>
                                <p>Форум пациентов</p>
                            </div>
                        </li>
                        <li>
                            <a href="<?php echo e(route('home')); ?>" class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">Главная </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('topics.index')); ?>" class="nav-link <?php echo e(request()->routeIs('topics.*') ? 'active' : ''); ?>">Темы</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('about')); ?>" class="nav-link <?php echo e(request()->routeIs('about') ? 'active' : ''); ?>">О форуме</a>
                        </li>
                        <?php if(auth()->guard()->check()): ?>

                        <?php if(auth()->user()->role === 'admin'): ?>
                        <li>
                            <a href="<?php echo e(route('admin.dashboard')); ?>"class="nav-link <?php echo e(request()->routeIs('admin.*') ? 'active' : ''); ?>"><i class="fas fa-tools"></i> Админ-панель </a>
                        </li>
                        <?php else: ?>
                        <li>
                            <a href="<?php echo e(route('profile')); ?>"class="nav-link <?php echo e(request()->routeIs('profile') ? 'active' : ''); ?>"><i class="fas fa-user-circle"></i> Профиль</a>
                        </li>
                        <?php endif; ?>
                        <li>
                            <form action="<?php echo e(route('logout')); ?>" method="POST" class="logout-form">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="nav-link logout-btn"><i class="fas fa-sign-out-alt"></i> Выйти</button>
                            </form>
                        </li>
                        <?php else: ?>
                        <li>
                            <a href="#" class="nav-link" id="open-login-modal">Войти</a>
                        </li>
                        <?php endif; ?>
                        <li>
                            <a href="<?php echo e(route('support')); ?>"class="nav-link <?php echo e(request()->routeIs('support') ? 'active' : ''); ?>"><i class="fas fa-headset"></i> Техподдержка </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="header-search">
            <form action="<?php echo e(route('search')); ?>" method="GET" class="search-form">
                <input
                    type="text"
                    name="q"
                    class="search-input"
                    placeholder="Поиск по темам..."
                    value="<?php echo e(request('q')); ?>">
                <button type="submit" class="search-btn">Найти</button>
            </form>
        </div>

    </div>
</header>
<div class="modal-overlay" id="login-modal">
    <div class="modal-container">
        <div class="modal-header">
            <h2>Вход на форум</h2>
            <button class="modal-close" id="close-login-modal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="login-form">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="login-name" class="form-label">Имя</label>
                    <input type="text" id="login-name" name="name" class="form-control" placeholder="Введите ваше имя">
                </div>
                <div class="form-group">
                    <label for="login" class="form-label">Логин</label>
                    <input type="text" id="login" name="login" class="form-control" required placeholder="Введите ваш логин">
                </div>
                <div class="form-group">
                    <label for="login-email" class="form-label">Email</label>
                    <input type="text" id="login-email" name="email" class="form-control" required placeholder="Введите вашу электронную почту">
                </div>

                <div class="form-group">
                    <label for="login-password" class="form-label">Пароль</label>
                    <input type="password" id="login-password" name="password" class="form-control" required placeholder="Введите ваш пароль">
                </div>

                <div class="form-options">
                    <label class="checkbox-label">
                    </label>
                    <a href="#" class="forgot-password" id="open-forgot-modal">Забыли пароль?</a>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary btn-block">Войти</button>
                    <button type="button" class="btn btn-secondary btn-block" id="open-register-from-login">
                        Зарегистрироваться
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal-overlay" id="register-modal">
    <div class="modal-container">
        <div class="modal-header">
            <h2>Регистрация</h2>
            <button class="modal-close" id="close-register-modal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="register-form">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="register-name" class="form-label">Имя</label>
                    <input type="text" id="register-name" name="name" class="form-control" required placeholder="Введите ваше имя">
                </div>
                <div class="form-group">
                    <label for="login" class="form-label">Логин</label>
                    <input type="text" id="login" name="login" class="form-control" required placeholder="Введите ваш логин">
                </div>
                <div class="form-group">
                    <label for="register-email" class="form-label">Электронная почта</label>
                    <input type="email" id="register-email" name="email" class="form-control" required placeholder="Введите вашу электронную почту">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="register-password" class="form-label">Пароль</label>
                        <input type="password" id="register-password" name="password" class="form-control" required placeholder="Придумайте пароль">
                    </div>

                    <div class="form-group">
                        <label for="register-password-confirm" class="form-label">Повторите пароль</label>
                        <input type="password" id="register-password-confirm" name="password_confirmation" class="form-control" required placeholder="Повторите пароль">
                    </div>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary btn-block">Зарегистрироваться</button>
                    <button type="button" class="btn btn-secondary btn-block" id="open-login-from-register">
                        Уже есть аккаунт? Войти
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<!-- Модальное окно восстановления пароля -->
<div class="modal-overlay" id="forgot-modal">
    <div class="modal-container">
        <div class="modal-header">
            <h2>Восстановление пароля</h2>
            <button class="modal-close" id="close-forgot-modal">&times;</button>
        </div>
        <div class="modal-body">
            <form method="POST" action="<?php echo e(route('password.email')); ?>">
                <?php echo csrf_field(); ?>
                <div class="password-help">
                    <p>
                        Восстановление пароля осуществляется через техническую поддержку.
                        Пожалуйста, укажите email, на который зарегистрирован аккаунт,
                        и опишите проблему. После проверки администратор отправит вам временный пароль.
                    </p>
                </div>

                <div class="form-buttons">
                    <a href="<?php echo e(route('support')); ?>" class="btn btn-secondary btn-block">
                        Перейти в техподдержку
                    </a>
                    <button type="button" class="btn btn-secondary btn-block" id="open-login-from-forgot">
                        Вернуться к входу
                    </button>
                </div>
            </form>
        </div>
    </div>
</div><?php /**PATH C:\OSPanel\home\forumap.local\resources\views/layouts/header.blade.php ENDPATH**/ ?>