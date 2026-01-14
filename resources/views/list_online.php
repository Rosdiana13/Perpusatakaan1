<?php $__env->startSection('title', 'List Peminjaman Online'); ?>

<?php $__env->startSection('content'); ?>

<h4 class="mb-4">📦 List Peminjaman Online (Delivery)</h4>

<?php if($peminjaman->isEmpty()): ?>
    <div class="alert alert-info">Belum ada peminjaman online.</div>
<?php else: ?>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nama Peminjam</th>
                <th>Buku</th>
                <th>Jumlah</th>
                <th>Alamat Pengiriman</th>
                <th>No HP</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($peminjaman as $pinjam): ?>
                <?php $anggota = $pinjam->login->anggota ?? null; ?>
                <?php foreach($pinjam->detail as $d): ?>
                    <tr>
                        <td><?php echo e($anggota->nama ?? '-'); ?></td>
                        <td><?php echo e($d->buku->judul); ?></td>
                        <td><?php echo e($d->jumlah); ?></td>
                        <td><?php echo e($pinjam->alamat_kirim); ?></td>
                        <td><?php echo e($anggota->nohp ?? '-'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
