<?php $__env->startSection('title', 'List Peminjaman'); ?>

<?php $__env->startSection('content'); ?>

<h4 class="mb-4">📚 List Peminjaman</h4>

<?php if($peminjaman->isEmpty()): ?>
    <div class="alert alert-info">Belum ada peminjaman.</div>
<?php else: ?>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Buku yang Dipinjam</th>
                <th>Total Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($peminjaman as $pinjam): ?>
                <tr>
                    <td><?php echo e($pinjam->tanggal_pinjam); ?></td>
                    <td><?php echo e($pinjam->tanggal_kembali); ?></td>
                    <td><?php echo e($pinjam->status); ?></td>
                    <td>
                        <ul class="mb-0">
                            <?php foreach($pinjam->detail as $d): ?>
                                <li>
                                    <b><?php echo e($d->buku->judul); ?></b> - <?php echo e($d->buku->pengarang); ?> (<?php echo e($d->buku->penerbit); ?>)
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                    <td>
                        <?php echo e($pinjam->detail->sum('jumlah')); ?>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
