
<?php 
    $client = $this->session->userdata('client') != NULL ? $this->session->userdata('client')['client'] : '';
?>

<div class="row d-flex" style="padding: 10px;">
    <div class="col-lg-10">
        <div class="row">
            <div class="col-lg-4">
                <h2>Retour client</h2>
            </div>
            <div class="col-lg-4"><br>
                <div class="form-group">
                    <label for="select_client">Filtrer par client</label>
                    <select class="form-control" id="select_client">
                        <option value="">Tous</option>
                        <?php
                            foreach($clients as $item) {
                                ?>
                                    <option value="<?= $item->nom ?>" <?= $client == $item->nom ? "selected='selected'" : '' ?> ><?= $item->nom ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-4" style="text-align: right"><br>
                <button class="btn btn-primary" id="logout_button" data-toggle="modal" data-target="#logout_modal">Deconnecter</button>
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
        <hr>
        <div class="">
            <div class="d-flex">
                <div class="item-backup">
                    <div class="icon">1</div>
                    <div class="text">Pas du tout satisfait</div>
                    <div class="count"><?= $backups[0] < 10 ? '0'.$backups[0] : $backups[0] ?></div>
                </div>
                <div class="item-backup">
                    <div class="icon">2</div>
                    <div class="text">Peu satisfait</div>
                    <div class="count"><?= $backups[1] < 10 ? '0'.$backups[1] : $backups[1] ?></div>
                </div>
                <div class="item-backup">
                    <div class="icon">3</div>
                    <div class="text">Satisfait</div>
                    <div class="count"><?= $backups[2] < 10 ? '0'.$backups[2] : $backups[2] ?></div>
                </div>
                <div class="item-backup">
                    <div class="icon">4</div>
                    <div class="text">Très satisfait</div>
                    <div class="count"><?= $backups[3] < 10 ? '0'.$backups[3] : $backups[3] ?></div>
                </div>
            </div>
        </div>
        <hr>
        <div class="">
            <div class="" style="width: 100%; padding-bottom: 50px">
                <canvas id="myChart" width="100%"></canvas>
            </div>
        </div>
    </div>
</div>
<br><br><br>
<br><br>

<!-- Modal -->
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <form>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">ID Tickets</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Titre</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Client</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Type Tickets</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Type</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Sous-type</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Valeur</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Commentaire</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    </div>
                </div>
            </div>
        </form>
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
      <div class="modal-body text-center">
        <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
        <button type="button" id="delete_confirm" class="btn btn-primary">Oui</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Deconnecter -->
<div class="modal fade" id="logout_modal" tabindex="-1" role="dialog" aria-labelledby="delete">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="delete">Déconnecter</h4>
      </div>
      <div class="modal-body text-center">
        <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
        <button type="button" id="logout_confirm" class="btn btn-primary">Oui</button>
      </div>
    </div>
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

    $('#logout_confirm').on('click', function() {
        $.ajax({
            url: "<?= site_url('admin/logout') ?>",
            method: 'POST',
            data: null,
            success: function() {
                location.reload();
            }
        })
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
            "dom": "<'row '<'col-lg-6'B><'col-lg-6 text-right'f>rt<'row'<'col-lg-6'l><'col-lg-6 text-right'p>>",
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
            ]
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

    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
        datasets: [{
            label: 'Pas du tou satisfait',
            data: [12, 19, 3, 5, 2, 3],
            borderColor: [
                'rgba(255, 99, 132, 1)',
            ],
            borderWidth: 2
        },
        {
            label: 'Peu satisfait',
            data: [6, 8, 1, 15, 3, 9],
            borderColor: [
                'green',
            ],
            borderWidth: 2
        },
        {
            label: 'Satisfait',
            data: [1, 10, 5, 12, 2, 4],
            borderColor: [
                'yellow',
            ],
            borderWidth: 2
        },
        {
            label: 'Très satisfait',
            data: [4, 17, 7, 2, 5, 10],
            borderColor: [
                'purple',
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

</script>