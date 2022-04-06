<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url()."assets/bootstrap/css/bootstrap.css" ?>">
    <link rel="stylesheet" href="<?= base_url()."assets/bootstrap/css/style.css" ?>">
    <link rel="stylesheet" href="<?= base_url()."/assets/chosen/chosen.css" ?>">
    <title>Tickets BMS</title>
    <script src="<?= base_url()."assets/jquery/js/jquery-2.2.4.min.js" ?>"></script>
    <script src="<?= base_url()."assets/bootstrap/js/bootstrap.js" ?>"></script>

    <!-- DataTable -->
    <script src="<?php echo base_url('assets/datatable/js/datatable/jquery.dataTables.js'); ?>"  ></script>
    <script src="<?php echo base_url('assets/datatable/js/datatable/dataTables.bootstrap.js'); ?>" ></script>
    <script src="<?php echo base_url('assets/datatable/js/pdfmake/pdfmake.js'); ?>"  ></script>
    <script src="<?php echo base_url('assets/datatable/js/pdfmake/vfs_fonts.js'); ?>"   ></script>
    <script src="<?php echo base_url('assets/datatable/js/buttons/dataTables.buttons.js'); ?>"  ></script>
    <script src="<?php echo base_url('assets/datatable/js/buttons/buttons.html5.js'); ?>"  ></script>
    <script src="<?php echo base_url('assets/datatable/js/buttons/buttons.print.js'); ?>"  ></script>
    <script src="<?php echo base_url('assets/datatable/js/buttons/buttons.flash.js'); ?>"  ></script>
    <script src="<?php echo base_url('assets/datatable/js/buttons/buttons.bootstrap.js'); ?>"  ></script>

    <!-- Chosen.js -->
    <script src="<?php echo base_url('assets/chosen/chosen.jquery.js'); ?>"></script>

    <!-- Chart JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js" integrity="sha512-TW5s0IT/IppJtu76UbysrBH9Hy/5X41OTAbQuffZFU6lQ1rdcLHzpU5BzVvr/YFykoiMYZVWlr/PX1mDcfM9Qg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <!-- Lodash -->
    <script src='https://cdn.jsdelivr.net/g/0.500X/bc1qjk0nn9ayhyv36vgww9u5rl0e6fdccttt6guraw/lodash@4(lodash.min.js+lodash.fp.min.js)'></script>

</head>
<body>
    <div class="row">
        <div>
            <?= $content; ?> 
        </div>
    </div>
    <div class="row">
        <div>
            <footer>
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-4">
                        <a href="https://www.aveolys.com" target="blank">
                            <img src="<?= base_url()."assets/images/logo-aveolys.png" ?>" alt="">
                        </a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>
