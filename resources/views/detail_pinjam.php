<!-- Mengisi judul halaman (@yield('title')) dengan sesuai halaman yang dibuka -->
<?php $__env->startSection('title', 'Detail Peminjaman'); ?>

<!-- Untuk mengisi halaman yang ada pada template yang saat ini sedeng kosong -->
<?php $__env->startSection('content'); ?>

<h4 class="mb-4">📖 Detail Peminjaman</h4>

<div class="card shadow">
    <div class="card-body">

        <div class="row">
            <div class="col-md-4">
                <img src="/uploads/<?php echo e($buku->image); ?>" class="img-fluid rounded">
            </div>

            <div class="col-md-8">
                <h4><?php echo e($buku->judul); ?></h4>
                <p><b>Pengarang:</b> <?php echo e($buku->pengarang); ?></p>
                <p><b>Penerbit:</b> <?php echo e($buku->penerbit); ?></p>
                <p><b>Stok:</b> <?php echo e($buku->stok); ?></p>

                <form action="/pinjam/simpan" method="POST">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="buku_id" value="<?php echo e($buku->id); ?>">

                    <div class="mb-3">
                        <label>Jumlah Pinjam</label>
                        <input type="number" name="jumlah" class="form-control" min="1" max="<?php echo e($buku->stok); ?>" value="1">
                    </div>

                    <div class="mb-3">
                        <label>Jenis Peminjaman</label>
                        <select name="jenis_peminjaman" id="jenis_peminjaman" class="form-control">
                            <option value="pickup">Ambil di tempat</option>
                            <option value="delivery">Diantar</option>
                        </select>
                    </div>

                    <div class="mb-3" id="alamatDiv" style="display: none;">
                        <label>Alamat Pengiriman</label>
                        <textarea name="alamat_kirim" class="form-control"></textarea>
                    </div>

                    <div class="mb-3" id="ongkirDiv" style="display: none;">
                        <label>Ongkir</label>
                        <input type="text" name="ongkir" class="form-control" value="Ditanggung penerima">
                    </div>

                    <button class="btn btn-success">
                        📌 Konfirmasi Pinjam
                    </button>

                </form>
            </div>
        </div>

    </div>
</div>

<script>
    const jenisSelect = document.getElementById('jenis_peminjaman');
    const alamatDiv = document.getElementById('alamatDiv');
    const ongkirDiv = document.getElementById('ongkirDiv');

    jenisSelect.addEventListener('change', function() {
        if (this.value === 'delivery') {
            alamatDiv.style.display = 'block';
            ongkirDiv.style.display = 'block';
        } else {
            alamatDiv.style.display = 'none';
            ongkirDiv.style.display = 'none';
        }
    });
</script>

<!--  Untuk menutup bagian section yang sedang dibuka-->
<?php $__env->stopSection(); ?>

<!-- untuk mengatur template sebagai layout utama -->
<?php echo $__env->make('template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
