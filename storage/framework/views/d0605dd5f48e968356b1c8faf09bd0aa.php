

<?php $__env->startSection('content'); ?>

<h1>Смена пароля</h1>

<?php if($errors->any()): ?>
    <div style="color:red;">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <p><?php echo e($error); ?></p>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('admin.users.password.update', $user->id)); ?>">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PATCH'); ?>

    <div style="margin-bottom:10px;">
        <label>Новый пароль:</label><br>
        <input type="password" name="password" required>
    </div>

    <div style="margin-bottom:10px;">
        <label>Подтвердите пароль:</label><br>
        <input type="password" name="password_confirmation" required>
    </div>

    <button type="submit" class="admin-btn">
        Сохранить
    </button>

    <a href="<?php echo e(route('admin.users')); ?>" class="admin-btn">
        Назад
    </a>

</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\home\forumap.local\resources\views/admin/users/password.blade.php ENDPATH**/ ?>