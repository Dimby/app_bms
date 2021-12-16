<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url()."assets/bootstrap/css/bootstrap.css" ?>">
    <link rel="stylesheet" href="<?= base_url()."assets/bootstrap/css/style.css" ?>">
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
    <style>
        footer {
            position: absolute;
            bottom: 3rem;
            width: 100%;
        }
    </style>
</head>
<body>
    <?= $content; ?>  
    <footer>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-4">
                <a href="https://www.aveolys.com" target="blank">
                    <img src="<?= base_url()."assets/images/logo-aveolys.png" ?>" alt="">
                </a>
            </div>
        </div>
    </footer>
</body>
</html>
