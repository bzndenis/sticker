            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/vendors/js/vendor.bundle.base.js') ?>"></script>
    <script src="<?= base_url('assets/js/off-canvas.js') ?>"></script>
    <script src="<?= base_url('assets/js/hoverable-collapse.js') ?>"></script>
    <script src="<?= base_url('assets/js/misc.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/dataTables.bootstrap4.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/sweetalert2.min.js') ?>"></script>
    <script>
        $(document).ready(function() {
            $('.datatable').DataTable();
            
            // Handle trade request
            $('.btn-trade').click(function(e) {
                e.preventDefault();
                var tradeId = $(this).data('id');
                
                Swal.fire({
                    title: 'Konfirmasi Pertukaran',
                    text: "Apakah Anda yakin ingin melakukan pertukaran?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = $(this).attr('href');
                    }
                });
            });
        });
    </script>
</body>
</html>