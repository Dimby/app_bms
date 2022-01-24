
<?php 
    $client = $this->session->userdata('client') != NULL ? $this->session->userdata('client')['client'] : '';

    function percentage($votes, $val) {
        return round(($val*100)/$votes, 2);
    }

?>

<div class="row d-flex" style="padding: 10px;">
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
        <div class="row">
            <div class="col-lg-3" style="padding-right: 50px">
                <h2>Filtre</h2>
                <form action="">
                <hr>
                    <div class="form-group">
                        <label for="mounth">Par mois</label>
                        <select class="form-control chosen-select" multiple id="mounth">
                            <option value="0">Janvier</option>
                            <option value="1">Fevrier</option>
                            <option value="2">Mars</option>
                            <option value="3">Avril</option>
                            <option value="4">Mai</option>
                            <option value="5">Juin</option>
                            <option value="6">Juillet</option>
                            <option value="7">Août</option>
                            <option value="8">Septembre</option>
                            <option value="9">Octobre</option>
                            <option value="10">Novembre</option>
                            <option value="11">Décembre</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mounth">Par client</label>
                        <select class="form-control chosen-select" multiple id="customer">
                            <?php
                                foreach($clients as $item) {
                                    ?>
                                        <option value="<?= $item->nom ?>"><?= $item->nom ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mounth">Par valeur</label>
                        <select class="form-control chosen-select" multiple id="valeur">
                            <option value="">Pas du tout satisfait</option>
                            <option value="">Peu satisfait</option>
                            <option value="">Satisfait</option>
                            <option value="">Très satisfait</option>
                        </select>
                    </div>
                    
                    <button class="btn btn-primary">Valider</button>
                </form>
            </div>
            <div class="col-lg-9">
                <div class="alert alert-info" role="alert">
                    <strong>Résultats filtré(s) :</strong> <span>Toutes les données</span>
                </div>
                <div class="alert alert-info" role="alert">
                    <strong>Résultats filtré(s) :</strong> 
                    De <span class="filter_date">04 Janvier à 12 Avril</span> -
                    Pour <span class="filter_customer">Aveolys, Iris</span> -
                    <span>[Pas du tout Satisfait, Satisfait]</span>
                </div>
                <div>
                    <h3>Liste [ <?= array_sum($backups) ?> vote(s) ]</h3>
                    <div class="d-flex" style="justify-content: start">
                        <div class="item-backup">
                            <div class="icon">1</div>
                            <div class="text">Pas du tout satisfait</div>
                            <div class="count" style="color: #FF6384"><?= $backups[0] < 10 ? '0'.$backups[0] : $backups[0] ?></div>
                            <div class="percentage"><?= percentage(array_sum($backups), $backups[0]) ?>%</div>
                        </div>
                        <div class="item-backup">
                            <div class="icon">2</div>
                            <div class="text">Peu satisfait</div>
                            <div class="count" style="color: #FFB468"><?= $backups[1] < 10 ? '0'.$backups[1] : $backups[1] ?></div>
                            <div class="percentage"><?= percentage(array_sum($backups), $backups[1]) ?>%</div>
                        </div>
                        <div class="item-backup">
                            <div class="icon">3</div>
                            <div class="text">Satisfait</div>
                            <div class="count" style="color: #059BFF"><?= $backups[2] < 10 ? '0'.$backups[2] : $backups[2] ?></div>
                            <div class="percentage"><?= percentage(array_sum($backups), $backups[2]) ?>%</div>
                        </div>
                        <div class="item-backup">
                            <div class="icon">4</div>
                            <div class="text">Très satisfait</div>
                            <div class="count" style="color: #00D9D9"><?= $backups[3] < 10 ? '0'.$backups[3] : $backups[3] ?></div>
                            <div class="percentage"><?= percentage(array_sum($backups), $backups[3]) ?>%</div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <h3>Courbe</h3>
                    <canvas id="myChart_line" width="100%"></canvas>
                </div>
                <div class="row">
                    <h3>Bâton</h3>
                    <canvas id="myChart_bar" width="100%"></canvas>
                </div>
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

    var config = {
        '.chosen-select'           : {},
        '.chosen-select-deselect'  : { allow_single_deselect: true },
        '.chosen-select-no-single' : { disable_search_threshold: 10 },
        '.chosen-select-no-results': { no_results_text: 'Oops, Aucun résultat!' },
        '.chosen-select-rtl'       : { rtl: true },
        '.chosen-select-width'     : { width: '95%' }
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }

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

    const ctx_line = document.getElementById('myChart_line').getContext('2d');
    const ctx_bar = document.getElementById('myChart_bar').getContext('2d');
    const myChart_line = new Chart(ctx_line, {
        type: 'line',
        data: {
            labels: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
            datasets: [{
                label: 'Pas du tou satisfait',
                data: [0, 1],
                borderColor: [
                    '#FF6384',
                ],
                backgroundColor: [
                    '#FF6384',
                ],
                borderWidth: 2
            },
            {
                label: 'Peu satisfait',
                data: [0, 3],
                borderColor: [
                    '#FFC890',
                ],
                backgroundColor: [
                    '#FFC890',
                ],
                borderWidth: 2
            },
            {
                label: 'Satisfait',
                data: [0, 0],
                borderColor: [
                    '#059BFF',
                ],
                backgroundColor: [
                    '#059BFF',
                ],
                borderWidth: 2
            },
            {
                label: 'Très satisfait',
                data: [0, 2],
                borderColor: [
                    '#22CFCF',
                ],
                backgroundColor: [
                    '#22CFCF',
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                }
            },
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    const myChart_bar = new Chart(ctx_bar, {
        type: 'bar',
        data: {
            labels: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
            datasets: [{
                label: 'Pas du tou satisfait',
                data: [1],
                backgroundColor: [
                    '#FF6384',
                ],
                borderWidth: 2
            },
            {
                label: 'Peu satisfait',
                data: [3],
                backgroundColor: [
                    '#FFC890',
                ],
                borderWidth: 2
            },
            {
                label: 'Satisfait',
                data: [0],
                backgroundColor: [
                    '#059BFF',
                ],
                borderWidth: 2
            },
            {
                label: 'Très satisfait',
                data: [2],
                backgroundColor: [
                    '#22CFCF',
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
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