<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('content'); ?>

<h3 class="mb-4">📚 Katalog Buku</h3>

<div class="row">
    <?php foreach($buku as $item): ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm">

                <img src="/uploads/<?= $item->image ?>" 
                     class="card-img-top" 
                     style="height:220px; object-fit:cover">

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">
                        <?= htmlspecialchars($item->judul) ?>
                    </h5>

                    <p class="mb-1">
                        <strong>Pengarang:</strong> <?= $item->pengarang ?>
                    </p>

                    <p class="mb-2">
                        <strong>Penerbit:</strong> <?= $item->penerbit ?>
                    </p>

                    <p class="text-muted mb-2">
                        Stok: <?= $item->stok ?>
                    </p>

                    <div class="mt-auto">
                        <?php if(\Illuminate\Support\Facades\Session::get('role') == 'anggota'): ?>
                            <?php if($item->stok > 0): ?>
                                <a href="<?php echo e(url('pinjam/'.$item->id)); ?>" class="btn btn-primary mt-auto w-100">
                                    📌 Pinjam
                                </a>
                            <?php else: ?>
                                <button class="btn btn-secondary mt-auto w-100" disabled>
                                    Stok Habis
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                </div>

            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
