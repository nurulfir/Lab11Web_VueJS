<?= $this->include('template/admin_header'); ?>

<h2><?= $title; ?></h2>

<div class="row mb-2 justify-content-center">
    <div class="col-md-8">
        <form id="search-form">
            <input type="text" name="q" id="search-box" value="<?= $q; ?>" placeholder="Cari artikel">

            <select name="kategori_id" id="category-filter">
                <option value="">Semua Kategori</option>
                <?php foreach ($kategori as $k): ?>
                    <option value="<?= $k['id_kategori']; ?>" <?= ($kategori_id == $k['id_kategori']) ? 'selected' : ''; ?>>
                        <?= $k['nama_kategori']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select id="sort-order" name="sort">
                <option value="">Urutkan Judul</option>
                <option value="judul_asc">Judul A-Z</option>
                <option value="judul_desc">Judul Z-A</option>
            </select>

            <input type="submit" value="Cari">
        </form>
    </div>
</div>

<div id="loading" style="display:none;">
    <div class="spinner"></div>
</div>

<div id="article-container"></div>
<div id="pagination-container"></div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        const articleContainer = $('#article-container');
        const paginationContainer = $('#pagination-container');
        const searchForm = $('#search-form');
        const searchBox = $('#search-box');
        const categoryFilter = $('#category-filter');
        const sortOrder = $('#sort-order');
        const loading = $('#loading');

        const getFormData = () => ({
            q: searchBox.val(),
            kategori_id: categoryFilter.val(),
            sort: sortOrder.val()
        });

        const fetchData = (url) => {
            loading.show();
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function(data) {
                    renderArticles(data.artikel);
                    renderPagination(data.pager, data.q, data.kategori_id, data.sort);
                },
                error: function() {
                    articleContainer.html('<p class="text-danger">Gagal memuat data.</p>');
                },
                complete: function() {
                    loading.hide();
                }
            });
        };

        const renderArticles = (articles) => {
            let html = '<table class="table">';
            html += '<thead><tr><th>ID</th><th>Judul</th><th>Kategori</th><th>Status</th><th>Aksi</th></tr></thead><tbody>';

            if (articles.length > 0) {
                articles.forEach(article => {
                    html += `
                        <tr>
                            <td>${article.id}</td>
                            <td>
                                <b>${article.judul}</b>
                                <p><small>${article.isi.substring(0, 50)}</small></p>
                            </td>
                            <td>${article.nama_kategori}</td>
                            <td>${article.status}</td>
                            <td>
                                <a class="btn btn-sm btn-info" href="/admin/artikel/edit/${article.id}">Ubah</a>
                                <a class="btn btn-sm btn-danger" onclick="return confirm('Yakin menghapus data?');" href="/admin/artikel/delete/${article.id}">Hapus</a>
                            </td>
                        </tr>
                    `;
                });
            } else {
                html += '<tr><td colspan="5">Tidak ada data.</td></tr>';
            }

            html += '</tbody></table>';
            articleContainer.html(html);
        };

        const renderPagination = (pager, q, kategori_id, sort) => {
            let html = '<div class="pagination mt-3">';

            pager.forEach(p => {
                const active = p.isCurrent ? 'active' : '';
                html += `
                    <button 
                        class="btn btn-sm btn-outline-primary me-1 ${active} pagination-button" 
                        data-page="${p.page}" 
                        data-q="${q}" 
                        data-kategori="${kategori_id}" 
                        data-sort="${sort}"
                    >
                        ${p.page}
                    </button>
                `;
            });

            html += '</div>';
            paginationContainer.html(html);
        };

        // Handle form submit
        searchForm.on('submit', function(e) {
            e.preventDefault();
            const { q, kategori_id, sort } = getFormData();
            fetchData(`/admin/artikel?q=${q}&kategori_id=${kategori_id}&sort=${sort}`);
        });

        // Handle filter/sort change
        categoryFilter.on('change', () => searchForm.trigger('submit'));
        sortOrder.on('change', () => searchForm.trigger('submit'));

        // Handle pagination click
        $(document).on('click', '.pagination-button', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            const q = $(this).data('q');
            const kategori_id = $(this).data('kategori');
            const sort = $(this).data('sort');
            fetchData(`/admin/artikel?page=${page}&q=${q}&kategori_id=${kategori_id}&sort=${sort}`);
        });

        // Initial load
        fetchData('/admin/artikel');
    });
</script>

<?= $this->include('template/admin_footer'); ?>
