<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <div class="admin-container">

        <aside class="sidebar-admin">
            <h2 class="logo">ADMIN</h2>

            <ul>
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('admin.topics') }}">Темы</a></li>
                <li><a href="{{ route('admin.users') }}">Пользователи</a></li>
                <li><a href="{{ route('admin.messages') }}">Обратная связь</a></li>
                <li><a href="{{ route('admin.complaints') }}">Жалобы</a></li>
                <li>
                    <a href="{{ route('admin.support.index') }}">
                        Чат с поддержкой
                    </a>
                </li>

                <li class="sidebar-divider"></li>

                <li>
                    <a href="{{ route('home') }}" class="sidebar-link back-to-site">
                        <i class="fas fa-arrow-left"></i> Вернуться на сайт
                    </a>
                </li>
            </ul>
        </aside>

        <main class="content">
            @yield('content')
        </main>
    </div>
    <script>
        function confirmDelete(name) {
            return confirm('Вы точно хотите удалить ' + name + ' ?');
        }

        function confirmBan(username, isBanned) {

            if (isBanned) {
                return confirm('Вы уверены что хотите разблокировать "' + username + '" ?');
            }

            return confirm('Вы уверены что хотите заблокировать "' + username + '" ?');
        }
    </script>
    @stack('scripts')
</body>

</html>