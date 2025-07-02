<?= $this->include('template/admin_header'); ?>

<style>
    /* Main Container */
    .admin-form-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 2rem;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    /* Form Title */
    .admin-form-title {
        color: #2c3e50;
        text-align: center;
        margin-bottom: 1.5rem;
        font-size: 1.8rem;
        font-weight: 600;
        border-bottom: 3px solid #e74c3c;
        padding-bottom: 0.5rem;
        display: block;
        width: fit-content;
        margin-left: auto;
        margin-right: auto;
    }

    /* Form Elements */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #2c3e50;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        transition: all 0.3s ease;
        background-color: #f8f8f8;
    }

    .form-control:focus {
        border-color: #3498db;
        outline: none;
        background-color: #fff;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    }

    textarea.form-control {
        min-height: 200px;
        resize: vertical;
    }

    select.form-control {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1rem;
        padding-right: 2.5rem;
    }

    /* Upload Area */
    .upload-area {
        border: 2px dashed #3498db;
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        background-color: #f8fafc;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
        position: relative;
    }

    .upload-area:hover {
        background-color: #ebf5ff;
    }

    .upload-area.active {
        border-color: #2ecc71;
        background-color: #e8f5e9;
    }

    .upload-icon {
        font-size: 2.5rem;
        color: #3498db;
        margin-bottom: 1rem;
    }

    .upload-text {
        font-size: 1rem;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .upload-hint {
        font-size: 0.875rem;
        color: #7f8c8d;
    }

    .file-input {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }

    /* Preview Image */
    .preview-container {
        margin-top: 1rem;
        text-align: center;
    }

    .current-image {
        max-width: 100%;
        max-height: 200px;
        border-radius: 4px;
        border: 1px solid #ddd;
        margin-bottom: 1rem;
    }

    .preview-image {
        max-width: 100%;
        max-height: 200px;
        border-radius: 4px;
        border: 1px solid #ddd;
        display: none;
    }

    .remove-image {
        display: inline-block;
        margin-top: 0.5rem;
        color: #e74c3c;
        cursor: pointer;
        font-size: 0.875rem;
    }

    /* Submit Button */
    .submit-btn {
        background-color: #3498db;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
    }

    .submit-btn:hover {
        background-color: #2980b9;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .admin-form-container {
            margin: 1rem;
            padding: 1.5rem;
        }
        
        .admin-form-title {
            font-size: 1.5rem;
        }
        
        .upload-area {
            padding: 1.5rem;
        }
    }
</style>

<div class="admin-form-container">
    <h2 class="admin-form-title"><?= $title; ?></h2>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" name="judul" id="judul" class="form-control" 
                   value="<?= esc($artikel['judul']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="isi" class="form-label">Isi</label>
            <textarea name="isi" id="isi" class="form-control" cols="50" rows="10"><?= esc($artikel['isi']); ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="id_kategori" class="form-label">Kategori</label>
            <select name="id_kategori" id="id_kategori" class="form-control" required>
                <?php foreach ($kategori as $k): ?>
                    <option value="<?= $k['id_kategori']; ?>" 
                        <?= ($artikel['id_kategori'] == $k['id_kategori']) ? 'selected' : ''; ?>>
                        <?= esc($k['nama_kategori']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label class="form-label">Gambar Artikel</label>
            
            <?php if (!empty($artikel['gambar'])): ?>
                <div class="preview-container">
                    <img src="<?= base_url('uploads/' . esc($artikel['gambar'])); ?>" alt="Current Image" class="current-image">
                    <div class="remove-image" id="removeCurrentImage">Hapus Gambar</div>
                    <input type="hidden" name="current_image" value="<?= esc($artikel['gambar']); ?>">
                </div>
            <?php endif; ?>
            
            <div class="upload-area" id="uploadArea">
                <div class="upload-icon">
                    <i class="fas fa-cloud-upload-alt"></i>
                </div>
                <div class="upload-text">Klik atau drop gambar baru di sini</div>
                <div class="upload-hint">Format: JPG, PNG (Maks. 2MB)</div>
                <input type="file" name="gambar" id="gambar" class="file-input" accept="image/*">
            </div>
            <div class="preview-container" id="previewContainer">
                <img src="#" alt="Preview" class="preview-image" id="previewImage">
                <div class="remove-image" id="removeNewImage">Batalkan</div>
            </div>
        </div>
        
        <div class="form-group">
            <input type="submit" value="Simpan Perubahan" class="submit-btn">
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('gambar');
    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');
    const removeNewImageBtn = document.getElementById('removeNewImage');
    const removeCurrentImageBtn = document.getElementById('removeCurrentImage');
    const currentImageContainer = document.querySelector('.current-image') ? document.querySelector('.current-image').parentNode : null;
    
    // Show current image or upload area
    if (currentImageContainer) {
        previewContainer.style.display = 'none';
    }
    
    // Handle drag and drop
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight(e) {
        e.preventDefault();
        e.stopPropagation();
        uploadArea.classList.add('active');
    }
    
    function unhighlight(e) {
        e.preventDefault();
        e.stopPropagation();
        uploadArea.classList.remove('active');
    }
    
    // Handle file drop
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        fileInput.files = e.dataTransfer.files;
        handleFiles(e.dataTransfer.files);
    });
    
    // Handle file selection
    fileInput.addEventListener('change', function() {
        if (this.files.length) {
            handleFiles(this.files);
        }
    });
    
    // Handle files
    function handleFiles(files) {
        const file = files[0];
        
        if (file.type.match('image.*')) {
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB');
                return;
            }
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
                
                if (currentImageContainer) {
                    currentImageContainer.style.display = 'none';
                }
            };
            
            reader.readAsDataURL(file);
        } else {
            alert('Hanya file gambar yang diperbolehkan');
        }
    }
    
    // Remove new image
    removeNewImageBtn.addEventListener('click', function() {
        previewImage.src = '#';
        previewContainer.style.display = 'none';
        fileInput.value = '';
        
        if (currentImageContainer) {
            currentImageContainer.style.display = 'block';
        }
    });
    
    // Remove current image
    if (removeCurrentImageBtn) {
        removeCurrentImageBtn.addEventListener('click', function() {
            if (confirm('Anda yakin ingin menghapus gambar ini?')) {
                currentImageContainer.style.display = 'none';
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'remove_image';
                hiddenInput.value = '1';
                document.querySelector('form').appendChild(hiddenInput);
            }
        });
    }
});
</script>

<?= $this->include('template/admin_footer'); ?>