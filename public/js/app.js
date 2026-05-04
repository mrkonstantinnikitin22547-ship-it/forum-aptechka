// Модальные окна
document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM загружен, инициализируем модальные окна...');

    // Элементы модальных окон
    const loginModal = document.getElementById('login-modal');
    const registerModal = document.getElementById('register-modal');
    const forgotModal = document.getElementById('forgot-modal');

    // Кнопки
    const openLoginBtn = document.getElementById('open-login-modal');
    const openRegisterFromLogin = document.getElementById('open-register-from-login');
    const openLoginFromRegister = document.getElementById('open-login-from-register');
    const openForgotBtn = document.getElementById('open-forgot-modal');
    const openLoginFromForgot = document.getElementById('open-login-from-forgot');

    // CSRF (безопасно)
    const csrfToken =
        document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    // Кнопки закрытия
    const closeLoginBtn = document.getElementById('close-login-modal');
    const closeRegisterBtn = document.getElementById('close-register-modal');
    const closeForgotBtn = document.getElementById('close-forgot-modal');

    // Проверяем что элементы существуют
    console.log('Найдены элементы:', {
        loginModal: !!loginModal,
        registerModal: !!registerModal,
        forgotModal: !!forgotModal,
        openLoginBtn: !!openLoginBtn,
        openRegisterFromLogin: !!openRegisterFromLogin,
        openLoginFromRegister: !!openLoginFromRegister,
        openForgotBtn: !!openForgotBtn,
        openLoginFromForgot: !!openLoginFromForgot,
        csrfTokenPresent: !!csrfToken
    });

    function openModal(modal) {
        if (!modal) return;
        console.log('Открываем окно:', modal.id);

        modal.style.display = '';
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(modal) {
        if (!modal) return;
        console.log('Закрываем окно:', modal.id);

        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // ===== ОБРАБОТЧИКИ ОТКРЫТИЯ =====
    if (openLoginBtn) {
        openLoginBtn.addEventListener('click', function (e) {
            e.preventDefault();
            console.log('Клик по кнопке Войти');
            openModal(loginModal);
        });
    }

    if (openRegisterFromLogin) {
        openRegisterFromLogin.addEventListener('click', function (e) {
            e.preventDefault();
            console.log('Клик по кнопке Зарегистрироваться в окне входа');
            closeModal(loginModal);
            setTimeout(() => openModal(registerModal), 50);
        });
    }

    if (openLoginFromRegister) {
        openLoginFromRegister.addEventListener('click', function (e) {
            e.preventDefault();
            console.log('Клик по кнопке Войти в окне регистрации');
            closeModal(registerModal);
            setTimeout(() => openModal(loginModal), 50);
        });
    }

    if (openForgotBtn) {
        openForgotBtn.addEventListener('click', function (e) {
            e.preventDefault();
            console.log('Клик по ссылке Забыли пароль?');
            closeModal(loginModal);
            setTimeout(() => openModal(forgotModal), 50);
        });
    }

    if (openLoginFromForgot) {
        openLoginFromForgot.addEventListener('click', function (e) {
            e.preventDefault();
            console.log('Клик по кнопке Вернуться к входу');
            closeModal(forgotModal);
            setTimeout(() => openModal(loginModal), 50);
        });
    }

    // ===== ОБРАБОТЧИКИ ЗАКРЫТИЯ =====
    if (closeLoginBtn) closeLoginBtn.addEventListener('click', () => closeModal(loginModal));
    if (closeRegisterBtn) closeRegisterBtn.addEventListener('click', () => closeModal(registerModal));
    if (closeForgotBtn) closeForgotBtn.addEventListener('click', () => closeModal(forgotModal));

    window.addEventListener('click', function (e) {
        if (e.target.classList.contains('modal-overlay')) {
            closeModal(e.target);
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.active').forEach(modal => closeModal(modal));
        }
    });

    console.log('Загружен app.js');

    // ===== УНИВЕРСАЛЬНАЯ ФУНКЦИЯ ДЛЯ AJAX =====
    async function postForm(url, formEl) {
        const formData = new FormData(formEl);

        const response = await fetch(url, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin', // ВАЖНО: чтобы Laravel видел сессию/куки
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        // Если сервер вернул не JSON (например HTML ошибки/редирект), покажем текст
        const contentType = response.headers.get('content-type') || '';
        if (!contentType.includes('application/json')) {
            const text = await response.text();
            console.error('Сервер вернул не JSON. Status:', response.status);
            console.error('Ответ сервера (первые 500 символов):', text.slice(0, 500));
            throw new Error(`Сервер вернул не JSON (status ${response.status})`);
        }

        const data = await response.json();

        if (!response.ok) {
            // Laravel часто кладёт ошибки валидации сюда
            const msg = data.message || `Ошибка сервера (status ${response.status})`;
            const err = new Error(msg);
            err.data = data;
            throw err;
        }

        return data;
    }

    // ===== ФОРМА ВХОДА =====
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            console.log('Отправка формы входа');

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn ? submitBtn.textContent : '';
            if (submitBtn) {
                submitBtn.textContent = 'Вход...';
                submitBtn.disabled = true;
            }

            try {
                const data = await postForm(window.ROUTES.ajaxLogin, this);
                console.log('Ответ сервера:', data);

                if (data.success) {
                    window.location.href = data.redirect || '/';
                } else {
                    alert(data.message || 'Ошибка входа');
                    if (data.errors) console.error('Ошибки валидации:', data.errors);
                }
            } catch (error) {
                console.error('Ошибка:', error);
                // если это валидация
                if (error?.data?.errors) {
                    const errorMessages = Object.values(error.data.errors).flat().join('\n');
                    alert('Ошибки:\n' + errorMessages);
                } else {
                    alert(error.message || 'Ошибка соединения с сервером');
                }
            } finally {
                if (submitBtn) {
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                }
            }
        });
    }

    // ===== ФОРМА РЕГИСТРАЦИИ =====
    const registerForm = document.getElementById('register-form');
    if (registerForm) {
        registerForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            console.log('Отправка формы регистрации');

            const password = document.getElementById('register-password');
            const confirmPassword = document.getElementById('register-password-confirm');

            if (password && confirmPassword && password.value !== confirmPassword.value) {
                alert('Пароли не совпадают!');
                return;
            }
            if (password && password.value.length < 6) {
                alert('Пароль должен быть не менее 6 символов');
                return;
            }

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn ? submitBtn.textContent : '';
            if (submitBtn) {
                submitBtn.textContent = 'Регистрация...';
                submitBtn.disabled = true;
            }

            try {
                const data = await postForm(window.ROUTES.ajaxRegister, this);
                console.log('Ответ сервера:', data);

                if (data.success) {
                    window.location.href = data.redirect || '/';
                } else {
                    alert(data.message || 'Ошибка регистрации');
                    if (data.errors) console.error('Ошибки валидации:', data.errors);
                }
            } catch (error) {
                console.error('Ошибка:', error);
                if (error?.data?.errors) {
                    const errorMessages = Object.values(error.data.errors).flat().join('\n');
                    alert('Ошибки:\n' + errorMessages);
                } else {
                    alert(error.message || 'Ошибка соединения с сервером');
                }
            } finally {
                if (submitBtn) {
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                }
            }
        });
    }

    // ===== ФОРМА ВОССТАНОВЛЕНИЯ (пока заглушка) =====
    const forgotForm = document.getElementById('forgot-form');
    if (forgotForm) {
        forgotForm.addEventListener('submit', function (e) {
            e.preventDefault();
            console.log('Отправка формы восстановления пароля');

            setTimeout(() => {
                alert('Инструкции отправлены на ваш email!');
                closeModal(forgotModal);
                setTimeout(() => openModal(loginModal), 100);
            }, 500);
        });
    }

    // ===== ДОПОЛНИТЕЛЬНЫЕ КНОПКИ =====
    document.querySelectorAll('.btn-primary, .open-register').forEach(btn => {
        if (btn.textContent.includes('Присоединиться') || btn.classList.contains('open-register')) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                console.log('Клик по кнопке Присоединиться');
                openModal(registerModal);
            });
        }
    });

    // ===== DROPDOWN МЕНЮ =====
    document.querySelectorAll('.dropdown').forEach(dropdown => {
        dropdown.addEventListener('mouseenter', function () {
            const menu = this.querySelector('.dropdown-menu');
            if (menu) menu.style.display = 'block';
        });
        dropdown.addEventListener('mouseleave', function () {
            const menu = this.querySelector('.dropdown-menu');
            if (menu) menu.style.display = 'none';
        });
    });

    // Отладка
    window.debugModals = {
        openLogin: function () { openModal(loginModal); },
        openRegister: function () { openModal(registerModal); },
        openForgot: function () { openModal(forgotModal); },
        listElements: function () {
            return {
                loginModal: document.getElementById('login-modal'),
                registerModal: document.getElementById('register-modal'),
                forgotModal: document.getElementById('forgot-modal'),
                openRegisterFromLogin: document.getElementById('open-register-from-login')
            };
        }
    };

    console.log('Модальные окна инициализированы!');
    console.log('Для отладки используйте window.debugModals в консоли');
});