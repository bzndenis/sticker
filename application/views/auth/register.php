<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?> - Sticker GetRich</title>
    <link rel="stylesheet" href="<?= base_url('assets/vendors/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
              <div class="card-body px-5 py-5">
                <h3 class="card-title text-left mb-3">Register</h3>
                
                <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= $this->session->flashdata('error') ?>
                </div>
                <?php endif; ?>

                <?= form_open('auth/register') ?>
                  <div class="form-group">
                    <label>Username *</label>
                    <input type="text" name="username" class="form-control p_input" 
                           value="<?= set_value('username') ?>">
                    <?= form_error('username', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control p_input" 
                           value="<?= set_value('email') ?>">
                    <?= form_error('email', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <label>Password *</label>
                    <input type="password" name="password" class="form-control p_input">
                    <?= form_error('password', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <label>Konfirmasi Password *</label>
                    <input type="password" name="confirm_password" class="form-control p_input">
                    <?= form_error('confirm_password', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-group d-flex align-items-center justify-content-between">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" name="terms" class="form-check-input"> 
                        Saya setuju dengan syarat dan ketentuan
                      </label>
                      <?= form_error('terms', '<small class="text-danger d-block">', '</small>') ?>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block enter-btn">Register</button>
                  </div>
                  <p class="sign-up text-center">Sudah punya akun? <a href="<?= base_url('index.php/auth/login') ?>">Login</a></p>
                <?= form_close() ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="<?= base_url('assets/vendors/js/vendor.bundle.base.js') ?>"></script>
    <script src="<?= base_url('assets/js/off-canvas.js') ?>"></script>
    <script src="<?= base_url('assets/js/hoverable-collapse.js') ?>"></script>
    <script src="<?= base_url('assets/js/misc.js') ?>"></script>
  </body>
</html> 