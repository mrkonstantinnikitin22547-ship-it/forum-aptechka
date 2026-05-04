

<?php $__env->startSection('content'); ?>

<h1>Просмотр сообщения</h1>

<p><strong>Имя:</strong> <?php echo e($message->first_name); ?> <?php echo e($message->last_name); ?></p>
<p><strong>Email:</strong> <?php echo e($message->email); ?></p>
<p><strong>Дата:</strong> <?php echo e($message->created_at); ?></p>

<hr>

<p><?php echo e($message->message); ?></p>

<br>
<a href="<?php echo e(route('admin.messages')); ?>"><button class="admin-btn">Назад</button></a>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\home\forumap.local\resources\views/admin/messages/show.blade.php ENDPATH**/ ?>