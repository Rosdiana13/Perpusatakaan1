<?php $__env->startSection('title', 'Registrasi Anggota'); ?>
<?php $__env->startSection('content'); ?>

<div class="container mt-5">
    <div class="card shadow mx-auto" style="max-width: 500px;">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Daftar Anggota</h4>
        </div>
        <div class="card-body">

            <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('error')); ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(url('/registrasi/simpan')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" required></textarea>
                </div>

                <div class="mb-3">
                    <label>No HP</label>
                    <input type="text" name="nohp" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button class="btn btn-success w-100">
                    Daftar
                </button>
            </form>

            <div class="text-center mt-3">
                <small>
                    Sudah punya akun?
                    <a href="<?php echo e(url('/login')); ?>">Login di sini</a>
                </small>
            </div>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
