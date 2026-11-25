<?php $__env->startSection('title', 'Welcome'); ?>

<?php $__env->startSection('content'); ?>
    <h1>Hello, there.</h1>
    <p class="lead">A quiet place to keep track of your profile, your pets and the businesses you belong to.</p>

    <div class="actions">
        <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">Log in</a>
        <a href="<?php echo e(route('register')); ?>" class="btn btn-ghost">Create an account</a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\LaravelProjects\Greg & Clint\Clint-Activity\resources\views/welcome.blade.php ENDPATH**/ ?>