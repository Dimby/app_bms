
    <div class="row" style="padding: 10px; display: flex; justify-content: center">
        <div class="col-lg-10">
            <h3>Rapport feedback</h3>
            <button class="btn btn-primary" id="logout_button" style="float: right">Deconnecter</button>
            <button class="btn btn-info" id="import_button" style="float: right; margin-right: 20px">Exporter en PDF</button>
        </div>
        <!-- <div class="col-lg-6" style="border: 1px solid red">
        </div> -->
    </div>
    <div class="row" style="display: flex; justify-content: center">
        <div class="col-lg-10">
            <table id="tickets_datatable" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable_info">
                <thead>
                    <tr role="row">
                        <th>ID Tickets</th>
                        <th>Titre</th>
                        <th>Client</th>
                        <th>Type tickets</th>
                        <th>Type</th>
                        <th>Sous-type</th>
                        <th>Valeur</th>
                        <th>Commentaire</th>
                        <th>Date feedback</th>
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
                <button type="button" class="btn btn-primary" data-action="`+id+`"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
                <button type="button" class="btn btn-danger" data-action="`+id+`"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
            </div>
        `;
    }

    $('#logout_button').on('click', function() {
        $.ajax({
            url: "<?= site_url('admin/logout') ?>",
            method: 'POST',
            data: null,
            success: function() {
                location.reload();
            }
        })
    })

    tableUser = $('#tickets_datatable').DataTable({
        "ajax": '<?= site_url('/admin/list_tickets') ?>',
        "columns": [
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
            {"data": 'date_feedback'},
            {"data": null,
                render: function(item) {
                    return action_feedback(item.id_ticket);
                }
            }
        ],
        "language": {
            "emptyTable": "Aucun Résultat",
            "infoEmpty": "Aucun résultat",
            "zeroRecords": "Aucun Résultat",
            "info": "_START_ à _END_ sur _TOTAL_ entrées",
            "search": "Rechercher :",
            "infoFiltered": "",
        },
        "dom": 'fBrtip',
        "bFilter": true,
        "responsive": true,
    });
    //!LIST All User
</script>