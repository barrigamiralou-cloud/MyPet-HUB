<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title'); ?> · <?php echo e(config('app.name', 'MyPet HUB')); ?></title>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
</head>
<body class="auth-body">
    <main class="auth-panel">
        <a href="<?php echo e(route('welcome')); ?>" class="brand"><?php echo e(config('app.name', 'MyPet HUB')); ?></a>

        <div class="auth-content">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

        <p class="auth-foot">&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name', 'MyPet HUB')); ?></p>
    </main>

    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>
</body>
</html>
<?php /**PATH C:\LaravelProjects\Greg & Clint\Clint-Activity\resources\views/layouts/auth.blade.php ENDPATH**/ ?>