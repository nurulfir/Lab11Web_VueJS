<?= $this->include('template/admin_header'); ?>

<div class="container py-4">
    <h1>Daftar Artikel</h1>

    <!-- Tabel Artikel -->
    <table class="table table-bordered" id="artikelTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Script -->
<script src="<?= base_url('assets/js/jquery-3.7.1.min.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        function showLoadingMessage() {
            $('#artikelTable tbody').html('<tr><td colspan="4">Loading data...</td></tr>');
        }

        function loadData() {
            showLoadingMessage();
            $.ajax({
                url: "<?= base_url('ajax/getData') ?>",
                method: "GET",
                dataType: "json",
                success: function (data) {
                    let tableBody = "";
                    data.forEach(function (row) {
                        let statusText = row.status == "1" ? "Aktif" : "Nonaktif";
                        tableBody += `<tr>
                            <td>${row.id}</td>
                            <td>${row.judul}</td>
                            <td>${statusText}</td>
                            <td>
                                <a href="<?= base_url('admin/artikel/edit/') ?>${row.id}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="${row.id}">Delete</a>
                            </td>
                        </tr>`;
                    });
                    $('#artikelTable tbody').html(tableBody);
                }
            });
        }

        loadData();

        // Hapus data
        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            let id = $(this).data('id');
            if (confirm('Yakin ingin menghapus artikel ini?')) {
                $.ajax({
                    url: "<?= base_url('ajax/delete/') ?>" + id,
                    method: "DELETE",
                    success: function () {
                        loadData();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Gagal hapus: ' + textStatus + errorThrown);
                    }
                });
            }
        });
    });
</script>

<?= $this->include('template/admin_footer'); ?>
