

<?php $__env->startSection('content'); ?>

<h1>Управление пользователями</h1>

<?php if(session('success')): ?>
<p style="color:green;"><?php echo e(session('success')); ?></p>
<?php endif; ?>

<?php if(session('error')): ?>
<p style="color:red;"><?php echo e(session('error')); ?></p>
<?php endif; ?>

<table class="admin-table">
    <tr>
        <th>#</th>
        <th>Имя</th>
        <th>Email</th>
        <th>Роль</th>
        <th>Статус</th>
        <th>Действия</th>
    </tr>

    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
        <td><?php echo e($loop->iteration); ?></td>
        <td><?php echo e($user->name); ?></td>
        <td><?php echo e($user->email); ?></td>
        <td><?php echo e($user->role); ?></td>
        <td>
            <?php if($user->is_banned): ?>
            <span style="color:red;">Заблокирован</span>
            <?php else: ?>
            <span style="color:green;">Активен</span>
            <?php endif; ?>
        </td>
        <td>

            <?php if($user->id !== auth()->id()): ?>

            
            <form method="POST"
                action="<?php echo e(route('admin.users.ban', $user->id)); ?>"
                onsubmit="return confirmBan('<?php echo e($user->name); ?>', <?php echo e($user->is_banned ? 'true' : 'false'); ?>)"
                style="display:inline;">

                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>

                <button type="submit"
                    class="admin-btn <?php echo e($user->is_banned ? 'btn-success' : 'btn-danger'); ?>">
                    <?php echo e($user->is_banned ? 'Разблокировать' : 'Заблокировать'); ?>

                </button>
            </form>

            
            <form action="<?php echo e(route('admin.users.role', $user->id)); ?>"
                method="POST"
                style="display:inline;">

                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>

                <button class="admin-btn" type="submit">
                    Сделать админом
                </button>
            </form>

            
            <a href="<?php echo e(route('admin.users.password.edit', $user->id)); ?>" class="admin-btn">
                Сменить пароль
            </a>

            <?php else: ?>
            <span style="color:gray;">Недоступно</span>
            <?php endif; ?>

        </td>
    </tr>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr>
        <td colspan="6" style="text-align:center; padding:20px;">
            Пользователей пока нет
        </td>
    </tr>
    <?php endif; ?>

</table>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\home\forumap.local\resources\views/admin/users/index.blade.php ENDPATH**/ ?>