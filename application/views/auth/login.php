<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?> - Sticker GetRich</title>
    <link rel="stylesheet" href="<?= base_url('assets/vendors/mdi/css/materialdesignicons.min.css') ?>">
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
                <h3 class="card-title text-left mb-3">Login</h3>
                
                <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= $this->session->flashdata('error') ?>
                </div>
                <?php endif; ?>

                <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <?= $this->session->flashdata('success') ?>
                </div>
                <?php endif; ?>
                
                <?= form_open('auth/login') ?>
                  <div class="form-group">
                    <label>Username *</label>
                    <input type="text" name="username" class="form-control p_input" 
                           value="<?= set_value('username') ?>">
                    <?= form_error('username', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <label>Password *</label>
                    <input type="password" name="password" class="form-control p_input">
                    <?= form_error('password', '<small class="text-danger">', '</small>') ?>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block enter-btn">Login</button>
                  </div>
                  <p class="sign-up text-center">Belum punya akun? <a href="<?= base_url('index.php/auth/register') ?>">Daftar</a></p>
                <?= form_close() ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="<?= base_url('assets/vendors/js/vendor.bundle.base.js') ?>"></script>
  </body>
</html>