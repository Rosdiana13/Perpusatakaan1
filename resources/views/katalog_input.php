<?php $__env->startSection('title', 'Input Katalog'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-3">
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h4>Tambah Katalog Buku</h4>
        </div>
        <div class="card-body">

            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <?= session('success') ?>
                </div>
            <?php endif; ?>

            <form action="/katalog/simpan" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label>Judul</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Pengarang</label>
                    <input type="text" name="pengarang" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Penerbit</label>
                    <input type="text" name="penerbit" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Tahun</label>
                    <input type="number" name="tahun" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Stok</label>
                    <input type="number" name="stok" class="form-control" value="1" required>
                </div>

                <div class="mb-3">
                    <label>Cover Buku</label>
                    <input type="file" name="image" class="form-control" required>
                </div>

                <button class="btn btn-success">
                    Simpan Buku
                </button>

            </form>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>