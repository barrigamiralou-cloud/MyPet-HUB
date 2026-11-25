<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard · <?php echo e(config('app.name', 'MyPet HUB')); ?></title>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
</head>
<body class="dash-body" data-protected>
    <header class="topbar">
        <span class="brand"><?php echo e(config('app.name', 'MyPet HUB')); ?></span>

        <div class="topbar-right">
            <span class="who"><?php echo e($user->name); ?> <small>&#64;<?php echo e($user->username); ?></small></span>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-ghost btn-sm">Log out</button>
            </form>
        </div>
    </header>

    <main class="dash">
        <h1>Hi, <?php echo e($user->profile?->first_name ?: $user->name); ?>.</h1>

        <?php if(session('status')): ?>
            <div class="notice"><?php echo e(session('status')); ?></div>
        <?php endif; ?>

        <section class="stats">
            <div class="stat"><b><?php echo e($user->pets->count()); ?></b><span>Pets</span></div>
            <div class="stat"><b><?php echo e($user->businesses->count()); ?></b><span>Businesses</span></div>
            <div class="stat"><b><?php echo e($user->businesses->where('pivot.active', true)->count()); ?></b><span>Active</span></div>
        </section>

        <div class="grid">
            
            <section class="card">
                <h2>Profile</h2>
                <form method="POST" action="<?php echo e(route('profile.update')); ?>" class="form" data-once>
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="row">
                        <label class="field">
                            <span>First name</span>
                            <input type="text" name="first_name" value="<?php echo e(old('first_name', $user->profile?->first_name)); ?>">
                            <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </label>
                        <label class="field">
                            <span>Last name</span>
                            <input type="text" name="last_name" value="<?php echo e(old('last_name', $user->profile?->last_name)); ?>">
                            <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </label>
                    </div>

                    <label class="field">
                        <span>Birth date</span>
                        <input type="date" name="birth_date" value="<?php echo e(old('birth_date', $user->profile?->birth_date?->format('Y-m-d') ?? $user->profile?->birth_date)); ?>">
                        <?php $__errorArgs = ['birth_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>

                    <label class="field">
                        <span>Bio</span>
                        <textarea name="bio" rows="3"><?php echo e(old('bio', $user->profile?->bio)); ?></textarea>
                        <?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>

                    <button type="submit" class="btn btn-primary" data-loading="Saving…">Save profile</button>
                </form>
            </section>

            
            <section class="card">
                <h2>Pets</h2>

                <form method="POST" action="<?php echo e(route('pets.store')); ?>" class="form inline" data-once>
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="_once" value="<?php echo e(\App\Support\Once::issue()); ?>">

                    <label class="field">
                        <span>Name</span>
                        <input type="text" name="name" value="<?php echo e(old('name')); ?>" required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>
                    <label class="field">
                        <span>Type</span>
                        <input type="text" name="type" value="<?php echo e(old('type')); ?>" placeholder="Cat, dog…" required>
                        <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>
                    <button type="submit" class="btn btn-primary" data-loading="Adding…">Add</button>
                </form>

                <ul class="list">
                    <?php $__empty_1 = true; $__currentLoopData = $user->pets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li>
                            <div><b><?php echo e($pet->name); ?></b> <small><?php echo e($pet->type); ?></small></div>
                            <form method="POST" action="<?php echo e(route('pets.destroy', $pet)); ?>" data-once>
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="link-danger" data-loading="…">Remove</button>
                            </form>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li class="empty">No pets yet.</li>
                    <?php endif; ?>
                </ul>
            </section>

            
            <section class="card wide">
                <h2>Businesses</h2>

                <form method="POST" action="<?php echo e(route('businesses.store')); ?>" class="form inline" data-once>
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="_once" value="<?php echo e(\App\Support\Once::issue()); ?>">

                    <label class="field">
                        <span>Business name</span>
                        <input type="text" name="business_name" value="<?php echo e(old('business_name')); ?>" required>
                        <?php $__errorArgs = ['business_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="error"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>
                    <label class="field grow">
                        <span>Description</span>
                        <input type="text" name="business_description" value="<?php echo e(old('business_description')); ?>">
                    </label>
                    <button type="submit" class="btn btn-primary" data-loading="Creating…">Create</button>
                </form>

                <ul class="list">
                    <?php $__empty_1 = true; $__currentLoopData = $user->businesses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $business): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li>
                            <div>
                                <b><?php echo e($business->name); ?></b>
                                <span class="pill <?php echo e($business->pivot->active ? 'on' : 'off'); ?>">
                                    <?php echo e($business->pivot->active ? 'Active' : 'Inactive'); ?>

                                </span>
                                <?php if($business->description): ?><small><?php echo e($business->description); ?></small><?php endif; ?>
                            </div>
                            <form method="POST" action="<?php echo e(route('businesses.toggle', $business)); ?>" data-once>
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="link" data-loading="…">
                                    <?php echo e($business->pivot->active ? 'Deactivate' : 'Activate'); ?>

                                </button>
                            </form>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li class="empty">No businesses yet.</li>
                    <?php endif; ?>
                </ul>
            </section>
        </div>
    </main>

    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>
</body>
</html>
<?php /**PATH C:\LaravelProjects\Greg & Clint\Clint-Activity\resources\views/dashboard.blade.php ENDPATH**/ ?>