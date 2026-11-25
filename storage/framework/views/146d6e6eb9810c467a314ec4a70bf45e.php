<?php $__env->startSection('title', 'Log in'); ?>

<?php $__env->startSection('content'); ?>
    <h1>Welcome back</h1>
    <p class="lead">Log in with your username or email.</p>

    <?php if(session('status')): ?>
        <div class="notice"><?php echo e(session('status')); ?></div>
    <?php endif; ?>

    <?php if($lockSeconds > 0): ?>
        <div class="notice notice-error" id="lock-notice" data-seconds="<?php echo e($lockSeconds); ?>">
            Too many attempts. Try again in <strong id="lock-timer"><?php echo e($lockSeconds); ?></strong>s.
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login.store')); ?>" class="form" data-once>
        <?php echo csrf_field(); ?>

        <label class="field">
            <span>Username or email</span>
            <input type="text" name="login" value="<?php echo e(old('login')); ?>" required autofocus autocomplete="username">
            <?php $__errorArgs = ['login'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </label>

        <label class="field">
            <span>Password</span>
            <input type="password" name="password" required autocomplete="current-password">
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </label>

        <label class="check">
            <input type="checkbox" name="remember" value="1"> <span>Keep me logged in</span>
        </label>

        <button type="submit" class="btn btn-primary btn-block" id="login-btn"
                data-loading="Logging in…" <?php if($lockSeconds > 0): echo 'disabled'; endif; ?>>Log in</button>
    </form>

    <p class="switch">New here? <a href="<?php echo e(route('register')); ?>">Create an account</a></p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\LaravelProjects\Greg & Clint\Clint-Activity\resources\views/auth/login.blade.php ENDPATH**/ ?>