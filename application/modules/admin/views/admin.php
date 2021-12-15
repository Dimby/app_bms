
    <div class="row d-flex" style="padding: 10px;">
        <div class="col-lg-10">
            <div class="row">
                <div class="col-lg-4">
                    <h2>Rapport feedback</h2>
                </div>
                <div class="col-lg-4"><br>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Filtrer par client</label>
                        <select class="form-control" id="exampleFormControlSelect1">
                            <option>Iris</option>
                            <option>Bethesda</option>
                            <option>Newpack</option>
                            <option>Smarteo</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4" style="text-align: right"><br>
                    <button class="btn btn-info" id="import_button" style="margin-right: 20px">Exporter en PDF</button>
                    <button class="btn btn-primary" id="logout_button">Deconnecter</button>
                </div>
            </div>
        </div>
        <!-- <div class="col-lg-6" style="border: 1px solid red">
        </div> -->
    </div>
    <div class="row d-flex">
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
            "infoEmpty": "Aucun enregistrement disponible",
            "zeroRecords": "Aucun Résultat",
            "infoFiltered": "(filtré à partir du total : _MAX_ entrée(s))",
            "lengthMenu": "Afficher : _MENU_",
            "info": "Page _PAGE_ sur _PAGES_",
            'search': "Recherche : ",
            "paginate": {
                "first":      "Premier",
                "last":       "Dernier",
                "next":       "Suivant",
                "previous":   "Précedent"
            },
        },
        "dom": "<'row w-100 m-0 p-2'<'col-lg-4 text-left'l><'col-lg-4 text-center'p><'col-lg-4 text-right'f>>",
        "bFilter": true,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Tous']],
        "responsive": true,
    });
    //!LIST All User
</script>