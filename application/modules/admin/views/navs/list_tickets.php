<?php
    $client = $this->session->userdata('client') != NULL ? $this->session->userdata('client')['client'] : '';
?>

<div class="row d-flex justify-content-center" style="padding: 10px;">
    <div class="col-lg-10">
        <div class="row">
            <div class="col-lg-4">
                <h2>Retour client - 2022</h2>
            </div>
            <div class="col-lg-4"><br>
                <div class="form-group">
                    <label for="select_client">Filtrer par client</label>
                    <select class="form-control" id="select_client">
                        <option value="">Tous</option>
                        <?php
                            foreach($clients as $item) {
                                ?>
                                    <option value="<?= $item->nom_client ?>" <?= $client == $item->nom_client ? "selected='selected'" : '' ?> ><?= $item->nom_client ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-lg-6" style="border: 1px solid red">
    </div> -->
</div>
<div class="row d-flex justify-content-center">
    <div class="col-lg-10">
        <table id="tickets_datatable" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable_info" style="width: 100%">
            <thead>
                <tr role="row">
                    <th>Date feedback</th>
                    <th>ID Tickets</th>
                    <th>Titre</th>
                    <th>Client</th>
                    <th>Type</th>
                    <th>Classification</th>
                    <th>Subdivision</th>
                    <th>Evaluation</th>
                    <th>Commentaire</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script>

    let action_feedback = function(id) {
        return `
            <div class="btn-group" role="group" aria-label="...">
                <button type="button" class="btn btn-danger" data-action="`+id+`" data-toggle="modal" data-target="#delete_modal"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
            </div>
        `;
    }

    $('button[data-dismiss=modal]').on('click', function() {
        location.reload()
    })

    tickets_datatable("<?= $client ?>");

    function tickets_datatable(client = '') {
        tableUser = $('#tickets_datatable').DataTable({
            "ajax": {
                url: "<?= site_url('/admin/list_tickets') ?>",
                method: "POST",
                data: {client: client},
            },
            "columns": [
                {"data": 'date_feedback'},
                {"data": 'id_ticket'},
                {"data": 'ticket_title'},
                {"data": 'client_name'},
                {"data": 'ticket_type'},
                {"data": 'issue_type'},
                {"data": 'issue_subtype'},
                {"data": null,
                    render: function(item) {
                        switch(item.valeur) {
                            case '0':
                                return 'Pas du tout satisfait';
                                break;
                            case '1':
                                return 'Peu satisfait';
                                break;
                            case '2':
                                return 'Plutôt satisfait';
                                break;
                            case '3':
                                return 'Très satisfait';
                                break;
                            default:
                                return '-';
                                break;
                        }
                    }
                },
                {"data": 'commentaire'},
                {"data": null,
                    render: function(item) {
                        return action_feedback(item.id_ticket);
                    }
                }
            ],
            "language": {
                "emptyTable": "Aucun Résultat",
                "infoEmpty": "Aucun enregistrement disponible",
                "zeroRecords": "Aucun Résultat",
                "infoFiltered": "",
                "lengthMenu": "Afficher : _MENU_",
                "info": "_END_ sur _MAX_ entrée(s)",
                'search': "Recherche : ",
                "paginate": {
                    "first":      "Premier",
                    "last":       "Dernier",
                    "next":       "Suivant",
                    "previous":   "Précedent"
                },
            },
            // "dom": "<'row w-100 m-0 p-2'<'col-lg-4 text-left'B><'col-lg-4 text-center'><'col-lg-4 text-right'fp>>",
            "dom": "<'row '<'col-lg-6'B><'col-lg-6 text-right'f>rt<'row'<'col-lg-6'li><'col-lg-6 text-right'p>>",
            "bFilter": true,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Tous']],
            "responsive": true,
            "buttons": [
                {
                    extend: 'pdf',
                    text: 'Exporté : en PDF',
                    exportOptions: {
                        modifier: {
                            page: 'current'
                        }
                    }
                },
                {
                    extend: 'csv',
                    text: 'en CSV',
                    exportOptions: {
                        modifier: {
                            search: 'none'
                        }
                    }
                }
            ],
            "order": [[0, "desc"]]
        });
        //!LIST All User
    }

    
    $('#tickets_datatable tbody').on('click', 'button', function() {
        let data = {name: "id_ticket", value: $(this).data('action')};
        $('#delete_confirm').on('click', function() {
            $.ajax({
                url: "<?= site_url('admin/delete_ticket') ?>",
                method: "POST",
                data: [data],
                success: function() {
                    location.reload();
                }
            });
        })
    })

    $('#select_client').change(function() {
        $.ajax({
            url: '<?= site_url('admin/set_session_client') ?>',
            method: "POST",
            data: {client: this.value},
            success: function() {
                location.reload();
            }
        })
    })

    $('.nav .menu').on('click', function() {
        $.ajax({
            url: '<?= site_url('admin/set_session_tickets') ?>',
            method: "POST",
            data: {tab: $(this).data('action')},
            success: function() {
            }
        })
    })

</script>