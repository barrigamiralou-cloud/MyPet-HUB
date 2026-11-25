<?php $__env->startSection('title', 'Register'); ?>

<?php $__env->startSection('content'); ?>
    <h1>Create an account</h1>
    <p class="lead">It only takes a minute.</p>

    <form method="POST" action="<?php echo e(route('register.store')); ?>" class="form" data-once>
        <?php echo csrf_field(); ?>
        <input type="hidden" name="_once" value="<?php echo e(\App\Support\Once::issue()); ?>">

        <label class="field">
            <span>Full name</span>
            <input type="text" name="name" value="<?php echo e(old('name')); ?>" required autofocus autocomplete="name">
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </label>

        <div class="row">
            <label class="field">
                <span>Username</span>
                <input type="text" name="username" value="<?php echo e(old('username')); ?>" required autocomplete="username">
                <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </label>

            <label class="field">
                <span>Email</span>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </label>
        </div>

        <div class="row">
            <label class="field">
                <span>Password</span>
                <input type="password" name="password" required autocomplete="new-password">
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </label>

            <label class="field">
                <span>Confirm password</span>
                <input type="password" name="password_confirmation" required autocomplete="new-password">
            </label>
        </div>

        <button type="submit" class="btn btn-primary btn-block" data-loading="Creating account…">Create account</button>
    </form>

    <p class="switch">Already have an account? <a href="<?php echo e(route('login')); ?>">Log in</a></p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\LaravelProjects\Greg & Clint\Clint-Activity\resources\views/auth/register.blade.php ENDPATH**/ ?>