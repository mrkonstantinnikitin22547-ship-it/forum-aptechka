<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\TopicReplyController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminTopicController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminMessageController;
use App\Http\Controllers\Admin\AdminComplaintController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\ReplyLikeController;
use App\Http\Controllers\SupportChatController;
use App\Http\Controllers\Admin\SupportChatAdminController;

/*
|--------------------------------------------------------------------------
| ГЛАВНАЯ
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'home'])->name('home');

/*
|--------------------------------------------------------------------------
| ТЕМЫ
|--------------------------------------------------------------------------
*/

Route::get('/topics', [PageController::class, 'topics'])->name('topics.index');
Route::get('/topics/{topic}', [TopicController::class, 'show'])->name('topics.show');

Route::middleware('auth')->post('/topics', [TopicController::class, 'store'])
    ->name('topics.store');

/*
|--------------------------------------------------------------------------
| ОТВЕТЫ
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->post('/topics/{topic}/replies', [TopicReplyController::class, 'store'])
    ->name('replies.store');

Route::post('/replies/{id}/like', [ReplyLikeController::class, 'toggle'])
    ->middleware('auth')
    ->name('replies.like');

/*
|--------------------------------------------------------------------------
| СТРАНИЦЫ
|--------------------------------------------------------------------------
*/

Route::get('/about', [PageController::class, 'about'])->name('about');

/*
|--------------------------------------------------------------------------
| ПОИСК
|--------------------------------------------------------------------------
*/

Route::get('/search', [TopicController::class, 'search'])->name('search');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::post('/ajax-login', [AuthController::class, 'ajaxLogin'])->name('ajax.login');
Route::post('/ajax-register', [AuthController::class, 'ajaxRegister'])->name('ajax.register');
Route::post('/ajax-forgot', [AuthController::class, 'ajaxForgot'])->name('ajax.forgot');

Route::get('/login', fn() => view('auth.login'))->name('login');
Route::get('/register', fn() => view('auth.register'))->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ПОДДЕРЖКА (пользователь)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::post('/profile/support/send', [SupportChatController::class, 'store'])
        ->name('profile.support.send');
});

/*
|--------------------------------------------------------------------------
| ПАРОЛЬ
|--------------------------------------------------------------------------
*/

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->name('password.update');

/*
|--------------------------------------------------------------------------
| ПРОФИЛЬ
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');

    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password.update');
});
/*
|--------------------------------------------------------------------------
| ОБРАТНАЯ СВЯЗЬ
|--------------------------------------------------------------------------
*/

Route::get('/support', function () {
    return view('pages.support');
})->name('support');

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');

Route::patch('/users/{id}/password', [AdminUserController::class, 'changePassword'])
    ->name('admin.users.password');

Route::get('/users/{id}/password', [AdminUserController::class, 'editPassword'])
    ->name('admin.users.password.edit');

Route::patch('/users/{id}/password', [AdminUserController::class, 'updatePassword'])
    ->name('admin.users.password.update');
/*
|--------------------------------------------------------------------------
| ЖАЛОБЫ
|--------------------------------------------------------------------------
*/

Route::post('/replies/{reply}/complaint', [ComplaintController::class, 'store'])
    ->name('complaints.store');

/*
|--------------------------------------------------------------------------
| АДМИНКА
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/topics', [AdminTopicController::class, 'index'])
        ->name('admin.topics');

    Route::delete('/topics/{id}', [AdminTopicController::class, 'destroy'])
        ->name('admin.topics.delete');

    Route::get('/users', [AdminUserController::class, 'index'])
        ->name('admin.users');

    Route::patch('/users/{id}/ban', [AdminUserController::class, 'toggleBan'])
        ->name('admin.users.ban');

    Route::patch('/users/{id}/role', [AdminUserController::class, 'changeRole'])
        ->name('admin.users.role');

    Route::get('/messages', [AdminMessageController::class, 'index'])
        ->name('admin.messages');

    Route::get('/messages/{id}', [AdminMessageController::class, 'show'])
        ->name('admin.messages.show');

    Route::delete('/messages/{id}', [AdminMessageController::class, 'destroy'])
        ->name('admin.messages.delete');

    Route::get('/complaints', [AdminComplaintController::class, 'index'])
        ->name('admin.complaints');

    Route::delete('/complaints/{id}', [AdminComplaintController::class, 'destroy'])
        ->name('admin.complaints.delete');

    /*
    |--------------------------------------------------------------------------
    | ПОДДЕРЖКА (АДМИН)
    |--------------------------------------------------------------------------
    */

    Route::get('/support', [SupportChatAdminController::class, 'index'])
        ->name('admin.support.index');

    Route::get('/support/{chat}', [SupportChatAdminController::class, 'show'])
        ->name('admin.support.show');

    Route::post('/support/{chat}/send', [SupportChatAdminController::class, 'send'])
        ->name('admin.support.send');
});
