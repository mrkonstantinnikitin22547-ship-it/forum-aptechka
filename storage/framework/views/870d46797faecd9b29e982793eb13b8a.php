<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Аптечка - Форум пациентов'); ?></title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="<?php echo e(asset('favicon.png')); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<script>
    window.APP_URL = "<?php echo e(url('/')); ?>";
    window.ROUTES = {
        ajaxLogin: "<?php echo e(url('ajax-login')); ?>",
        ajaxRegister: "<?php echo e(url('ajax-register')); ?>",
        ajaxForgot: "<?php echo e(url('ajax-forgot')); ?>"
    };
</script>

<body>
    <?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <main class="main-content">
        <div class="container">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-content">
                <p>© <?php echo e(date('Y')); ?> Аптечка - Форум пациентов. Все права защищены.</p>
                <p>Платформа для обмена опытом между пациентами</p>
            </div>
        </div>
    </footer>

    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
</body>

</html><?php /**PATH C:\OSPanel\home\forumap.local\resources\views/layouts/app.blade.php ENDPATH**/ ?>