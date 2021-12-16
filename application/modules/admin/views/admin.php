
<div class="row d-flex" style="padding: 10px;">
    <div class="col-lg-10">
        <div class="row">
            <div class="col-lg-4">
                <h2>Retour client</h2>
            </div>
            <div class="col-lg-4"><br>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Filtrer par client</label>
                    <select class="form-control" disabled id="exampleFormControlSelect1">
                        <?php
                            foreach($clients as $item) {
                                ?>
                                    <option><?= $item->nom ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-4" style="text-align: right"><br>
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

<!-- Modal -->
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="delete">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="delete">Supprimer le ticket</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
        <button type="button" id="delete_confirm" class="btn btn-primary">Oui</button>
      </div>
    </div>
  </div>
</div>

<script>

    let action_feedback = function(id) {
        return `
            <div class="btn-group" role="group" aria-label="...">
                <button type="button" class="btn btn-primary" data-action="`+id+`" data-toggle="modal" data-target="#edit_modal"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
                <button type="button" class="btn btn-danger" data-action="`+id+`" data-toggle="modal" data-target="#delete_modal"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
            </div>
        `;
    }
    
    // let delete_ticket = function() {
    //     console.log(this.data('action'))
    //     // $('#id_ticket').val(id_ticket);
    //     $('#delete_confirm').on('click', function() {
    //         $.ajax({
    //             url: "<?= site_url('admin/delete_ticket') ?>",
    //             method: "POST",
    //             data: $('#delete_form').serializeArray(),
    //             success: function() {
    //                 location.reload();
    //             }
    //         });
    //     })
    // }

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
        // "dom": "<'row w-100 m-0 p-2'<'col-lg-4 text-left'B><'col-lg-4 text-center'><'col-lg-4 text-right'fp>>",
        "dom": "<'row '<'col-lg-6'B><'col-lg-6 text-right'f>rtip",
        "bFilter": true,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Tous']],
        "responsive": true,
        "buttons": [
            'pdf', 'csv'
        ]
    });
    //!LIST All User

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
</script>