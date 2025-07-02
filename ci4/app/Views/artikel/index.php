<?= $this->include('template/header'); ?>

<div class="container">
    <!-- Tambahkan wrapper content-container untuk layout flex -->
    <div class="content-container">
        
        <!-- Konten Utama -->
        <div class="main-content">
            <?php if ($artikel): foreach ($artikel as $row): ?>
                <article class="entry">
                    <h2><a href="<?= base_url('/artikel/' . $row['slug']); ?>"><?= $row['judul']; ?></a></h2>
                    <p>Kategori: <?= $row['nama_kategori'] ?></p>
                    <img src="<?= base_url('gambar/' . $row['gambar']); ?>" alt="<?= $row['judul']; ?>">
                    <p><?= substr($row['isi'], 0, 200); ?></p>
                </article>
                <hr class="divider" />
            <?php endforeach; else: ?>
                <article class="entry">
                    <h2>Belum ada data.</h2>
                </article>
            <?php endif; ?>
        </div>

        <!-- Sidebar Kategori -->
        <div class="sidebar">
            <div class="widget">
                <h3>Kategori</h3>
                <ul class="category-list">
                    <?php if ($kategori): foreach ($kategori as $cat): ?>
                        <li>
                           <a href="<?= base_url('/kategori/' . $cat['slug_kategori']); ?>">
                                <?= $cat['nama_kategori'] ?>                                
                            </a>
                        </li>
                    <?php endforeach; else: ?>
                        <li>Tidak ada kategori</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        
    </div> <!-- End content-container -->
</div> <!-- End container -->

<?= $this->include('template/footer'); ?>
