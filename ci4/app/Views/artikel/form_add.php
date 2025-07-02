<?= $this->include('template/admin_header'); ?>

<style>
    /* Main Form Styles */
    #main.container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    #main h2 {
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
    form p {
        margin-bottom: 20px;
    }

    form label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #2c3e50;
    }

    form input[type="text"],
    form textarea,
    form select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
        transition: border-color 0.3s;
        background-color: #f8f8f8;
    }

    form input[type="text"]:focus,
    form textarea:focus,
    form select:focus {
        border-color: #3498db;
        outline: none;
        background-color: #fff;
    }

    form textarea {
        min-height: 200px;
        resize: vertical;
    }

    form select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 14px;
        padding-right: 35px;
    }

    /* Upload Area Styles */
    .upload-container {
        margin: 2rem 0;
    }

    .upload-area {
        border: 2px dashed #3498db;
        border-radius: 8px;
        padding: 30px;
        text-align: center;
        background-color: #f8fafc;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .upload-area:hover {
        background-color: #ebf4ff;
        border-color: #2980b9;
    }

    .upload-area.active {
        border-color: #2ecc71;
        background-color: #e8f5e9;
    }

    .upload-area.reject {
        border-color: #e74c3c;
        background-color: #fdedec;
    }

    .upload-icon {
        font-size: 48px;
        color: #3498db;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }

    .upload-text {
        font-size: 16px;
        color: #2c3e50;
        margin-bottom: 10px;
        font-weight: 500;
    }

    .upload-hint {
        font-size: 14px;
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

    /* Preview Styles */
    .preview-container {
        margin-top: 1.5rem;
        display: none;
        text-align: center;
    }

    .preview-image {
        max-width: 100%;
        max-height: 250px;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: 1px solid #eee;
    }

    /* Submit Button */
    .btn-submit {
        background-color: #3498db;
        color: white;
        border: none;
        padding: 12px 24px;
        font-size: 16px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
        width: 100%;
    }

    .btn-submit:hover {
        background-color: #2980b9;
    }

    /* Responsive */
    @media (max-width: 768px) {
        #main.container {
            margin: 1rem;
            padding: 15px;
        }

        .upload-area {
            padding: 20px;
        }

        form textarea {
            min-height: 150px;
        }
    }
</style>

<div id="main" class="container">
    <h2><?= $title; ?></h2>
    <form action="" method="post" enctype="multipart/form-data">
        <p>
            <label for="judul">Judul</label>
            <input type="text" name="judul" id="judul" required placeholder="Masukkan judul artikel">
        </p>
        <p>
            <label for="isi">Isi</label>
            <textarea name="isi" id="isi" cols="50" rows="10" required placeholder="Tulis konten artikel anda disini..."></textarea>
        </p>
        <p>
            <label for="id_kategori">Kategori</label>
            <select name="id_kategori" id="id_kategori" required>
                <?php foreach ($kategori as $k): ?>
                    <option value="<?= $k['id_kategori']; ?>"><?= $k['nama_kategori']; ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        
        <div class="upload-container">
            <label class="upload-label">Gambar Artikel</label>
            <div class="upload-area" id="uploadArea">
                <div class="upload-icon">
                    <i class="fas fa-cloud-upload-alt"></i>
                </div>
                <div class="upload-text">Klik atau drop gambar di sini</div>
                <div class="upload-hint">Format: JPG, PNG (Maks. 2MB)</div>
                <input type="file" name="gambar" id="gambar" class="file-input" accept="image/*">
            </div>
            <div class="preview-container" id="previewContainer">
                <img src="" alt="Preview Gambar" class="preview-image" id="previewImage">
            </div>
        </div>
        
        <p>
            <input type="submit" value="Kirim" class="btn-submit">
        </p>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('gambar');
    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');
    
    // Highlight area saat drag over
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, (e) => {
            e.preventDefault();
            uploadArea.classList.add('active');
        });
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, (e) => {
            e.preventDefault();
            uploadArea.classList.remove('active');
        });
    });
    
    // Handle file drop
    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        fileInput.files = e.dataTransfer.files;
        handleFiles(e.dataTransfer.files);
    });
    
    // Handle file select via click
    fileInput.addEventListener('change', (e) => {
        if (fileInput.files.length) {
            handleFiles(fileInput.files);
        }
    });
    
    // Process selected files
    function handleFiles(files) {
        const file = files[0];
        
        if (file.type.match('image.*')) {
            // Validasi ukuran file (maks 2MB)
            if (file.size > 2 * 1024 * 1024) {
                showError('Ukuran file maksimal 2MB');
                return;
            }
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
                
                // Update upload area appearance
                uploadArea.classList.add('active');
                uploadArea.querySelector('.upload-icon').className = 'fas fa-check-circle upload-icon';
                uploadArea.querySelector('.upload-icon').style.color = '#2ecc71';
                uploadArea.querySelector('.upload-text').textContent = file.name;
                uploadArea.querySelector('.upload-hint').textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
            };
            
            reader.readAsDataURL(file);
        } else {
            showError('Hanya file gambar yang diperbolehkan');
        }
    }
    
    function showError(message) {
        uploadArea.classList.add('reject');
        uploadArea.querySelector('.upload-text').textContent = message;
        uploadArea.querySelector('.upload-icon').className = 'fas fa-exclamation-circle upload-icon';
        uploadArea.querySelector('.upload-icon').style.color = '#e74c3c';
        
        // Reset after 3 seconds
        setTimeout(() => {
            uploadArea.classList.remove('reject');
            resetUploadArea();
        }, 3000);
    }
    
    function resetUploadArea() {
        uploadArea.classList.remove('active');
        uploadArea.querySelector('.upload-icon').className = 'fas fa-cloud-upload-alt upload-icon';
        uploadArea.querySelector('.upload-icon').style.color = '#3498db';
        uploadArea.querySelector('.upload-text').textContent = 'Klik atau drop gambar di sini';
        uploadArea.querySelector('.upload-hint').textContent = 'Format: JPG, PNG (Maks. 2MB)';
        previewContainer.style.display = 'none';
        fileInput.value = '';
    }
});
</script>

<?= $this->include('template/admin_footer'); ?>