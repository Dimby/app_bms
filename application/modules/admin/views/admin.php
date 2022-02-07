
<?php 
    var_dump($all_tickets_by_clients);
    var_dump($clients);
    var_dump($data_chart);
    var_dump($last_value);
    var_dump($list_value);

    $client = $this->session->userdata('client') != NULL ? $this->session->userdata('client')['client'] : '';
    $sess_tickets = $this->session->userdata('tickets') != NULL ? $this->session->userdata('tickets') : '';
    
    $active_ticket = isset($sess_tickets['active_ticket']) ? $sess_tickets['active_ticket'] : '';
    $active_stat = isset($sess_tickets['active_stat']) ? $sess_tickets['active_stat'] : '';
    function percentage($votes, $val) {
        return round(($val*100)/$votes, 2);
    }

    // Somme de tout les tickets
    $sum = array_sum(explode(';', $last_value));
    // Pour le total
    $backups = explode(";", $last_value);

?>

<button class="btn btn-primary" id="logout_button" data-toggle="modal" data-target="#logout_modal">Deconnecter</button>

<div style="padding: 10px">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="menu <?= $active_ticket ?>" data-action="list-ticket"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Liste des tickets</a></li>
    <li role="presentation" class="menu <?= $active_stat ?>" data-action="stat"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Statistiques</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane <?= $active_ticket ?>" id="home">
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
                                            <option value="<?= $item->nom ?>" <?= $client == $item->nom ? "selected='selected'" : '' ?> ><?= $item->nom ?></option>
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
    </div>
    <div role="tabpanel" class="tab-pane <?= $active_stat ?>" id="profile">
        <div>
            <div>
                <div class="row">
                    <div class="col-lg-2">
                        <h2>Filtre</h2>
                        <form action="" id="form_filter">
                        <hr>
                            <div class="form-group">
                                <label for="mounth">Par mois</label>
                                <select class="form-control chosen-select" name="mounth" multiple id="mounth" data-action="mounth">
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
                                <label for="customer">Par client</label>
                                <select class="form-control chosen-select" name="customer" multiple id="customer" data-action="customer">
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
                                <label for="valeur">Par valeur</label>
                                <select class="form-control chosen-select" name="valeur" multiple id="valeur" data-action="valeur">
                                    <option value="0">Pas du tout satisfait</option>
                                    <option value="1">Peu satisfait</option>
                                    <option value="2">Plutôt satisfait</option>
                                    <option value="3">Très satisfait</option>
                                </select>
                            </div>

                            <button class="btn btn-primary" id="valid_filter">Filtrer</button>
                        </form>
                    </div>
                    <div class="col-lg-10">
                        <div class="alert alert-info" role="alert">
                            <strong>Résultats filtré(s) :</strong> <span>Toutes les données</span>
                        </div>
                        <div class="alert alert-info" role="alert">
                            <strong>Résultats filtré(s) :</strong> 
                            De <span class="filter_date">04 Janvier à 12 Avril</span> -
                            Pour <span class="filter_customer">Aveolys, Iris</span> -
                            <span>[Pas du tout Satisfait, Satisfait]</span>
                        </div>
                    </div>
                    <div class="col-lg-10 row">
                            <div class="col-lg-6">
                                <h3>Tickets par clients [ <span id="clients_length"></span> client(s) ]</h3>
                                <div class="d-flex" id="client_section"></div>
                            </div>
                            <div class="col-lg-6">
                                <h3>Liste [ <?= $sum ?> vote(s) ]</h3>
                                <div class="d-flex" id="valeur_section" style="justify-content: start">
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
                                        <div class="text">Plutôt satisfait</div>
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
                            <div class="col-lg-6">
                                <h3>Courbe</h3>
                                <canvas id="myChart_line" width="100%"></canvas>
                            </div>
                            <div class="col-lg-6">
                                <h3>Bâton</h3>
                                <canvas id="myChart_bar" width="100%"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
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

    let colors = [];
    let labels = []; // Pas du tout satisfait - Peu satisfait - Plutôt satisfait - Très satisfait
    <?php
        foreach($list_value as $item) {
            ?>
            colors.push("<?= $item->color ?>");
            labels.push("<?= $item->label ?>")
            <?php
        }
    ?>
    let mounths = ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'];
    let datasets = []; // Variable pour les courbes
    let count = 0;
    <?php
        foreach($data_chart as $item) {
            ?>
            datasets.push({
                label: labels[count],
                data: [<?= implode(", ", $item) ?>],
                borderColor: [colors[count]],
                backgroundColor: [colors[count]],
                borderWidth: 2
            })
            count++
            <?php
        }
    ?>

    let clients_list = []

    <?php
        foreach($all_tickets_by_clients as $c) {
            ?>
                clients_list.push({
                    nom: "<?= $c['nom_client'] ?>",
                    somme: <?= $c['somme'] ?>,
                    feedbacks: <?= json_encode($c['feedbacks']) ?>
                })
            <?php
        }
    ?>

    // console.log(clients_list);

    let get_all_name_clients = () => {
        let temp = [];
        clients_list.forEach(item => {
            temp.push(item.nom)
        });
        return temp;
    }

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

    $('.nav .menu').on('click', function() {
        $.ajax({
            url: '<?= site_url('admin/set_session_tickets') ?>',
            method: "POST",
            data: {tab: $(this).data('action')},
            success: function() {
            }
        })
    })

    // $('.chosen-select').change('select', function() {
    //     switch($(this).data('action')) {
    //         case 'mounth':
    //         break;
    //         case 'customer':
    //             $(this).val() != null
    //             ? dynamise_data_for_client($(this).val().length, $(this).val())
    //             : dynamise_data_for_client(clients_list.length, get_all_name_clients());
    //         break;
    //         case 'valeur':
    //             console.log($(this).val())
    //         break;
    //     }
    // })

    let dynamise_data_for_client = (x) => {
        $('#clients_length').html(x.length < 10 ? '0'+x.length : x.length);
        $('#client_section').html('');
        let temp = clients_list.filter(client => x.includes(client.nom));
        for (let i = 0; i < temp.length; i++) {
            let somme = temp[i].somme < 10 ? '0'+temp[i].somme : temp[i].somme
            let arr_temp = temp[i].feedbacks;
            let str = '';
            let j = 0;
            arr_temp.map(item => {
                str += '<div style="color: '+colors[j]+'">'+labels[j]+' : '+item+'</div>'
                j++;
            })
            // (temp[i].feedbacks).map(item => console.log(item));
            $('#client_section').append(`
                <div class="d-flex" style="justify-content: start">
                    <div class="item-backup">
                        <div class="count" style="color: grey" id="`+temp[i].nom+`">`+ somme +`</div>
                        <div class="percentage">`+temp[i].nom+`</div>
                        <div class="list">
                            `+str+`
                        </div>
                    </div>
                </div>
            `);
        }
    }

    let dynamise_data_for_valeur = () => {
        $('#valeur_section').html('');
        labels.forEach(item => {
            let k = 0;
            // let temp = datasets.filter(dataset => )
            // for (let i = 0; i < m.length; i++) {
                
            // }
            $('#valeur_section').append(`
                <div class="item-backup">
                    <div class="icon">`+(k++)+`</div>
                    <div class="text">`+item+`</div>
                    <div class="count" style="color: #FF6384"><?= $backups[0] < 10 ? '0'.$backups[0] : $backups[0] ?></div>
                    <div class="percentage"><?= percentage(array_sum($backups), $backups[0]) ?>%</div>
                </div>
            `);
        });

    }

    dynamise_data_for_client(get_all_name_clients());

    $('#valid_filter').on('click', function(e) {
        e.preventDefault();
        let temp = $('#form_filter').serializeArray();
        
        let tab_mounth_temp = temp.filter(item => (item.name).includes("mounth"));
        let tab_client_temp = temp.filter(item => (item.name).includes("customer"));
        let tab_valeur_temp = temp.filter(item => (item.name).includes("valeur"));
        
        console.log(tab_valeur_temp)
        if(tab_client_temp.length === 0) {
            dynamise_data_for_client(get_all_name_clients());
        } else {
            let val = [];
            tab_client_temp.forEach(item => {
                val.push(item.value);
            });
            dynamise_data_for_client(val);
        }
    })

    const ctx_line = document.getElementById('myChart_line').getContext('2d');
    const ctx_bar = document.getElementById('myChart_bar').getContext('2d');
    const myChart_line = new Chart(ctx_line, {
        type: 'line',
        data: {
            labels: mounths,
            datasets: datasets
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
            labels: mounths,
            datasets: datasets
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

    let globals = [
        {
            nom: "Aveolys",
            somme: 8,
            // feedbacks: [[0, 1, 1], [0, 1, 1], [1, 0, 1], [0, 0, 2]]
            feedbacks: 
                {
                    0: [0, 1, 1],
                    1: [0, 1, 1],
                    2: [1, 0, 1],
                    3: [0, 0, 2]
                }
        },
        {
            nom: "Iris",
            somme: 10,
            feedbacks: 
                {
                    0: [0, 1, 2], 
                    1: [1, 0, 1], 
                    2: [0, 0, 0], 
                    3: [1, 2, 1]
                }
        },
        {
            nom: "Newpack",
            somme: 7,
            feedbacks: 
                {
                    0: [1, 1, 3], 
                    1: [0, 2, 1], 
                    2: [0, 1, 0], 
                    3: [0, 1, 2]
                }
        }
    ]

            // [0, 1]  [0, 1]  ["Aveolys", "Iris"]
            // valeur : 0 Pas du tout Satisfait, 1 Peu satisfait, ... 
    let filtre = (mounth, valeur, client) => {
        let mounth_filtered = [];
        let valeur_filtered = [];
        let client_filtered = globals.filter(item => client.includes(item.nom));
        // Filtrer par client d'abord
        client_filtered.forEach(item => {
            mounth_filtered.push(
                {
                    nom: item.nom,
                    somme: sum(filter_mounth(item.feedbacks, mounth.length)),
                    feedbacks: filter_mounth(item.feedbacks, mounth.length)
                }
            );
        });
        // Filtrer par mois apres
        mounth_filtered.forEach(item => {
            let t = filter_valeur(item.feedbacks, valeur);
            valeur_filtered.push(
                {
                    nom: item.nom,
                    somme: sum(t),
                    feedbacks: t
                }
            )
        })
        return valeur_filtered;
    }

    let filter_mounth = (feedbacks, n) => {
        let f = Object.entries(feedbacks);
        let temp = {}
        f.forEach(([key, value]) => {
            temp[key] = _.take(value, n);
        });
        return temp;
    }
    let sum = (feedbacks) => {
        let f = Object.entries(feedbacks);
        let sum = 0;
        f.forEach(([key, value]) => {
            sum += value.reduce((a, b) => a + b,0)
        });
        return sum;
    }
    let filter_valeur = (feedbacks, v) => {
        let f = Object.entries(feedbacks);
        let ret = {}
        f.forEach(([key, value]) => {
            if(v.includes(parseInt(key, 10))) {
                ret[key] = value
            }
        })
        return ret;
    }
    let last_value = (data) => {
        let temp = [];
        data.forEach(element => {
            temp.push({
                nom: element.nom,
                somme: sum(element.feedbacks),
                last_feedback: reduce_last_value(element.feedbacks)
            });
        });
        return temp;
    }
    let reduce_last_value = (feedbacks) => {
        let f = Object.entries(feedbacks);
        let temp = [];
        f.forEach(([key, value]) => {
            temp.push(value.reduce((a, b) => a + b,0))
        });
        return temp;
    }

    // mois - valeur - client
    console.log(last_value(filtre([1, 2], [0, 1], ["Iris"])))
    console.dir(filtre([1, 2], [0, 1], ["Iris"]));
    // console.log(filter_mounth(globals[2].feedbacks, 2))
    // console.log(ret);

</script>