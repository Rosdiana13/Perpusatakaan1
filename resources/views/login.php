<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white text-center">
                <h5 class="mb-0">Login Sistem Perpustakaan</h5>
            </div>

            <div class="card-body">

                <?php if(session('error')): ?>
                    <div class="alert alert-danger">
                        <?php echo e(session('error')); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(url('/login')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label class="form-label">Username / Email</label>
                        <input type="text" name="username" class="form-control" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-dark">
                            Login
                        </button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <small>
                        Belum punya akun?
                        <a href="<?php echo e(url('/registrasi')); ?>">Daftar di sini</a>
                    </small>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
