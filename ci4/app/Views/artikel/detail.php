<?= $this->include('template/header'); ?>
<article class="entry article-detail">
    <h2><?= $artikel['judul']; ?></h2>
    <div class="image-text-side">
        <div class="article-image-container">
            <img src="<?= base_url('/gambar/' . $artikel['gambar']); ?>" alt="<?=$artikel['judul']; ?>" class="article-image">
        </div>
        <div class="article-text-side">
            <p><?= $artikel['isi']; ?></p>
        </div>
    </div>
</article>
<?= $this->include('template/footer'); ?>