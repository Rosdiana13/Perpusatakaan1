<?php $__env->startSection('title','Pinjam Offline'); ?>
<?php $__env->startSection('content'); ?>

<h4>📚 Pinjam Buku (Offline)</h4>

<?php if(session('success')): ?>
<div class="alert alert-success"><?= session('success') ?></div>
<?php endif; ?>

<?php if(session('error')): ?>
<div class="alert alert-danger"><?= session('error') ?></div>
<?php endif; ?>

<form method="POST" action="<?= url('/pinjam-offline/simpan') ?>">
<?= csrf_field() ?>

<div class="mb-3">
    <label>Anggota</label>
    <select name="anggota_id" class="form-control" required>
        <option value="">-- Pilih Anggota --</option>
        <?php foreach($anggota as $a): ?>
            <option value="<?= $a->id ?>"><?= $a->nama ?> (<?= $a->nohp ?>)</option>
        <?php endforeach; ?>
    </select>
</div>

<div class="mb-3">
    <label>Buku</label>
    <select name="buku_id" class="form-control" required>
        <option value="">-- Pilih Buku --</option>
        <?php foreach($buku as $b): ?>
            <option value="<?= $b->id ?>"><?= $b->judul ?> (Stok: <?= $b->stok ?>)</option>
        <?php endforeach; ?>
    </select>
</div>

<div class="mb-3">
    <label>Jumlah</label>
    <input type="number" name="jumlah" class="form-control" min="1" required>
</div>

<button class="btn btn-primary w-100">📌 Simpan Peminjaman</button>

</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('template')->render(); ?>
