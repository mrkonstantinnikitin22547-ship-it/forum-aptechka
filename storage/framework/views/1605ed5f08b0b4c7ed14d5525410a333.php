

<?php $__env->startSection('title', 'Личный кабинет - Аптечка'); ?>

<?php $__env->startSection('content'); ?>
<div class="profile-container">

    <h1 class="page-title-profile">Личный кабинет</h1>

    <?php
    $tab = request('tab', 'info');
    ?>

    <div class="profile-layout">

        
        <aside class="sidebar-profile">

            <a href="<?php echo e(route('profile', ['tab' => 'info'])); ?>"
                class="nav-link <?php echo e($tab === 'info' ? 'active' : ''); ?>">
                Личный кабинет
            </a>

            <a href="<?php echo e(route('profile', ['tab' => 'topics'])); ?>"
                class="nav-link <?php echo e($tab === 'topics' ? 'active' : ''); ?>">
                Мои обсуждения
            </a>

            <a href="<?php echo e(route('profile', ['tab' => 'support'])); ?>"
                class="nav-link <?php echo e($tab === 'support' ? 'active' : ''); ?>">
                Чат поддержки
            </a>

        </aside>

        
        <div class="profile-main">

            
            <?php if($tab === 'info'): ?>

            <div class="profile-info">

                <div class="profile-avatar">
                    <?php if($user->avatar): ?>
                    <img src="<?php echo e(asset('storage/avatars/' . $user->avatar)); ?>" alt="Аватар">
                    <?php else: ?>
                    <div class="avatar-placeholder">
                        <i class="fas fa-user"></i>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="profile-details">
                    <h2><?php echo e($user->name); ?></h2>

                    <p><strong>Email:</strong> <?php echo e($user->email); ?></p>

                    <?php if($user->login): ?>
                    <p><strong>Логин:</strong> <?php echo e($user->login); ?></p>
                    <?php endif; ?>

                    <?php if($user->is_admin): ?>
                    <span class="badge badge-admin">Администратор</span>
                    <?php else: ?>
                    <span class="badge badge-user">Пользователь</span>
                    <?php endif; ?>

                    <?php if($user->bio): ?>
                    <div class="bio-section">
                        <h3>О себе:</h3>
                        <p><?php echo e($user->bio); ?></p>
                    </div>
                    <?php endif; ?>

                    <?php if($user->city): ?>
                    <p><strong>Город:</strong> <?php echo e($user->city); ?></p>
                    <?php endif; ?>

                    <?php if($user->diagnosis): ?>
                    <p><strong>Диагноз:</strong> <?php echo e($user->diagnosis); ?></p>
                    <?php endif; ?>

                    <p><strong>Зарегистрирован:</strong> <?php echo e($user->created_at->format('d.m.Y')); ?></p>
                </div>

                <?php if(session('password_success')): ?>
                    <p style="color:green;"><?php echo e(session('password_success')); ?></p>
                <?php endif; ?>

                <?php if(session('password_error')): ?>
                    <p style="color:red;"><?php echo e(session('password_error')); ?></p>
                <?php endif; ?>

                <button type="button" class="btn btn-primary" onclick="openPasswordModal()">
                    Изменить пароль
                </button>
            </div>

            
            <?php elseif($tab === 'topics'): ?>

            <div class="widget">
                <h3 class="widget-title">Мои обсуждения</h3>

                <?php $__empty_1 = true; $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="discussion-item">

                    <a href="<?php echo e(route('topics.show', $topic->id)); ?>" class="discussion-link">
                        <?php echo e($topic->title); ?>

                    </a>

                    <span class="discussion-date">
                        <?php echo e($topic->created_at->format('d.m.Y H:i')); ?>

                    </span>

                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="empty">Нет активности</div>
                <?php endif; ?>
            </div>

            
            <?php elseif($tab === 'support'): ?>

            <?php
            $chat = auth()->user()->supportChat;
            $messages = $chat
            ? $chat->messages()->oldest()->get()
            : collect();
            ?>

            <div class="support-chat">

                <h3>💬 Чат с поддержкой</h3>

                <div class="chat-box">

                    <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <div class="
                        chat-message
                        <?php echo e($message->sender_type === 'user' ? 'user-message' : 'admin-message'); ?>

                    ">

                        <div class="message-author">
                            <?php echo e($message->sender_type === 'user' ? auth()->user()->name : 'Админ'); ?>

                        </div>

                        <div class="message-text">
                            <?php echo e($message->message); ?>

                        </div>

                    </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <p class="empty">
                        Пока нет сообщений. Начните диалог с поддержкой.
                    </p>

                    <?php endif; ?>

                </div>

                <form
                    method="POST"
                    action="<?php echo e(route('profile.support.send')); ?>"
                    class="support-form">

                    <?php echo csrf_field(); ?>

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

            <?php endif; ?>

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

            <?php if($errors->any()): ?>
                <div style="color:red; margin-bottom:10px;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p><?php echo e($error); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('profile.password.update')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>

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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\home\forumap.local\resources\views/profile/show.blade.php ENDPATH**/ ?>