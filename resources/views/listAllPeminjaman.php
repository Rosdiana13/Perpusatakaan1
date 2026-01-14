<?php $__env->startSection('title', 'Semua Buku Dipinjam'); ?>
<?php $__env->startSection('content'); ?>

<h4 class="mb-4">📚 Semua Buku yang Sedang Dipinjam</h4>

<?php if($peminjaman->isEmpty()): ?>
    <div class="alert alert-info">
        Tidak ada buku yang sedang dipinjam.
    </div>
<?php else: ?>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nama Peminjam</th>
                <th>Buku</th>
                <th>Jumlah</th>
                <th>Jenis</th>
                <th>Alamat</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>   <!-- ✅ kolom baru -->
                <th>Aksi</th>
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
                        <td><?php echo e($pinjam->jenis_peminjaman); ?></td>
                        <td><?php echo e($pinjam->alamat_kirim); ?></td>
                        <td><?php echo e($pinjam->tanggal_pinjam); ?></td>
                        <td><?php echo e($pinjam->tanggal_kembali); ?></td>

                        <!-- ✅ STATUS -->
                        <td>
                            <?php if($pinjam->status == 'dipinjam'): ?>
                                <?php if(now()->gt($pinjam->tanggal_kembali)): ?>
                                    <span class="badge bg-danger">Terlambat</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Dipinjam</span>
                                <?php endif; ?>
                            <?php elseif($pinjam->status == 'terlambat'): ?>
                                <span class="badge bg-danger">Terlambat</span>
                            <?php else: ?>
                                <span class="badge bg-success">Dikembalikan</span>
                            <?php endif; ?>
                        </td>

                        <!-- ✅ AKSI -->
                        <td>
                            <?php if($pinjam->status == 'dipinjam'): ?>
                                <form action="<?php echo e(url('/peminjaman/kembalikan/'.$pinjam->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button class="btn btn-success btn-sm"
                                        onclick="return confirm('Yakin buku ini dikembalikan?')">
                                        Kembalikan
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="badge bg-secondary">Selesai</span>
                            <?php endif; ?>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
