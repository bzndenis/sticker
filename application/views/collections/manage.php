<?php 
$data['title'] = 'Kelola Koleksi - ' . $category->name;
$this->load->view('templates/header', $data); 
?>

<?php $this->load->view('templates/navbar'); ?>

<div class="container my-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Kelola Stiker - <?= $category->name ?></h5>
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionDropdown">
                    <li>
                        <a class="dropdown-item" href="<?= base_url('collections/view/'.$category->id) ?>">
                            <i class="bi bi-arrow-left me-2"></i> Kembali ke Koleksi
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item text-danger" href="#" onclick="resetForm()">
                            <i class="bi bi-x-circle me-2"></i> Reset Form
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <?= form_open_multipart('collections/upload_sticker', ['id' => 'stickerForm']) ?>
                <input type="hidden" name="category_id" value="<?= $category->id ?>">
                
                <!-- Image Upload Section -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Gambar Stiker <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control" id="imageInput" accept="image/*" required>
                        <small class="text-muted d-block mt-1">Format: JPG, PNG, GIF. Maks: 2MB</small>
                        <?php if($sticker && $sticker->image_path): ?>
                            <div class="mt-2">
                                <p class="mb-1">Gambar Saat Ini:</p>
                                <img src="<?= base_url('uploads/stickers/'.$sticker->image_path) ?>" 
                                     class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <p class="mb-1">Preview:</p>
                            <img src="" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                    </div>
                </div>

                <!-- Quantities Section -->
                <h5 class="mb-3">Jumlah Stiker yang Dimiliki</h5>
                <div class="row g-3">
                    <?php for($i = 1; $i <= 9; $i++): ?>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <label class="form-label">Stiker #<?= $i ?></label>
                                    <input type="number" 
                                           name="quantities[<?= $i ?>]" 
                                           class="form-control quantity-input" 
                                           value="<?= isset($quantities[$i]) ? $quantities[$i] : 0 ?>" 
                                           min="0"
                                           data-original="<?= isset($quantities[$i]) ? $quantities[$i] : 0 ?>">
                                    <small class="text-muted">Jumlah yang dimiliki</small>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                    <a href="<?= base_url('collections/view/'.$category->id) ?>" class="btn btn-light">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let hasChanges = false;
    const $submitBtn = $('#submitBtn');
    const $imageInput = $('#imageInput');
    const $quantityInputs = $('.quantity-input');
    
    // Inisialisasi dropdown Bootstrap
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl)
    });
    
    // Image preview
    $imageInput.on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview img').attr('src', e.target.result);
                $('#imagePreview').show();
            }
            reader.readAsDataURL(file);
        }
        checkFormValidity();
    });
    
    // Monitor quantity changes
    $quantityInputs.on('change', function() {
        const originalValue = $(this).data('original');
        const newValue = parseInt($(this).val()) || 0;
        
        if (newValue !== originalValue) {
            hasChanges = true;
            $imageInput.prop('required', true);
            if (!$imageInput.val()) {
                Swal.fire({
                    title: 'Perhatian!',
                    text: 'Anda harus mengupload gambar stiker ketika mengubah jumlah',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            }
        }
        
        checkFormValidity();
    });
    
    // Form validation
    function checkFormValidity() {
        const hasImage = $imageInput.get(0).files.length > 0;
        const hasQuantityChanges = Array.from($quantityInputs).some(input => {
            return parseInt(input.value) !== parseInt($(input).data('original'));
        });
        
        $submitBtn.prop('disabled', !hasImage && hasQuantityChanges);
    }
    
    // Form submit handler
    $('#stickerForm').on('submit', function(e) {
        const hasImage = $imageInput.get(0).files.length > 0;
        const hasQuantityChanges = Array.from($quantityInputs).some(input => {
            return parseInt(input.value) !== parseInt($(input).data('original'));
        });
        
        if (hasQuantityChanges && !hasImage) {
            e.preventDefault();
            Swal.fire({
                title: 'Perhatian!',
                text: 'Anda harus mengupload gambar stiker ketika mengubah jumlah',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return false;
        }
    });
});

// Reset form function
function resetForm() {
    Swal.fire({
        title: 'Reset Form?',
        text: "Semua perubahan akan hilang!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Reset!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#stickerForm')[0].reset();
            $('#imagePreview').hide();
            $('.quantity-input').each(function() {
                $(this).val($(this).data('original'));
            });
            checkFormValidity();
        }
    });
}
</script>

<!-- Add SweetAlert2 for better alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.quantity-input::-webkit-inner-spin-button, 
.quantity-input::-webkit-outer-spin-button { 
    opacity: 1;
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15);
}

#imagePreview img {
    max-width: 100%;
    height: auto;
    border-radius: 0.25rem;
}

/* Tambahan style untuk dropdown */
.dropdown-item {
    display: flex;
    align-items: center;
    padding: 0.5rem 1rem;
}

.dropdown-item i {
    width: 1.2rem;
}

.dropdown-item:hover {
    background-color: var(--bs-light);
}

.dropdown-item.text-danger:hover {
    background-color: var(--bs-danger-light);
}
</style>

<?php $this->load->view('templates/footer'); ?> 