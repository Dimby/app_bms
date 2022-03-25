
<?php 
    // var_dump($all_tickets_by_clients);
    // var_dump($clients);
    // var_dump($data_chart);
    // var_dump($last_value);
    // var_dump($list_value);
    // var_dump($min_date);
    // var_dump($max_date);
    // var_dump($all_tickets);

    $client = $this->session->userdata('client') != NULL ? $this->session->userdata('client')['client'] : '';
    $sess_tickets = $this->session->userdata('tickets') != NULL ? $this->session->userdata('tickets') : '';
    
    $active_ticket = isset($sess_tickets['active_ticket']) ? $sess_tickets['active_ticket'] : '';
    $active_stat = isset($sess_tickets['active_stat']) ? $sess_tickets['active_stat'] : '';
    function percentage($votes, $val) {
        return round(($val*100)/$votes, 2);
    }

    $clients_json = json_encode((array) $clients);

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
                                <label for="customer">Par client</label>
                                <select class="form-control chosen-select" name="customer" multiple id="customer" data-action="customer">
                                    <?php
                                        foreach($clients as $item) {
                                            ?>
                                                <option value="<?= $item->nom_client ?>"><?= $item->nom_client ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="valeur">Par valeur</label>
                                <select class="form-control chosen-select" name="valeur" multiple id="valeur" data-action="valeur">
                                    <?php foreach ($list_value as $value): ?>
                                    <option value="<?= $value->label ?>"><?= $value->label ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <button class="btn btn-primary" id="valid_filter">Filtrer</button>
                        </form>
                    </div><br>
                    <div class="col-lg-10">
                        <div class="row">
                            <div class="col">
                                <div>
                                    <i class="fa-solid fa-circle-chevron-left"></i>
                                    Année <?= $year ?>
                                    <i class="fa-solid fa-circle-chevron-right"></i>
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <h3>Valeur(s)</h3>
                                <canvas id="myChart_bar" width="100%"></canvas>
                            </div>
                            <div class="col-lg-8">
                                <h3>Client(s) [<span class="total_client"></span>]</h3>
                                <div class="filter"></div><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <h3>Année 2022</h3>
                                <canvas id="myChart_line_mounth" height="70%"></canvas>
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

    // SECTION FILTRE -----------------------------------------------------------------------------------------------------------------
    let with_zero = (n) => {
        return n < 10 ? ("0"+n) : n;
    }

    let colors = [];
    <?php
        foreach($list_value as $item) {
            ?>
                colors.push("<?= $item->color ?>");
            <?php
        }
    ?>
    let mounths = ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'];
    let all_tickets = <?= $all_tickets ?>;
    let clients = <?= $clients_json ?>;
    let list_valeur = <?= json_encode((array) $list_value) ?>;

    let lv_label = []
    list_valeur.forEach(lv => {
        lv_label.push(lv.label);
    })
    let c_label = []
    clients.forEach(c => {
        c_label.push(c.nom_client);
    })

    let filter_by_client = (tickets, client) => {
        return _.filter(tickets, { client_name: client });
    }
    let filter_by_value = (tickets, valeur) => {
        return _.filter(tickets, { valeur: valeur });
    }
    let filter_by_date = (tickets, date) => {
        return _.filter(tickets, { date_feedback: date });
    }
    let percentage = (n, total) => {
        return ((n*100)/total).toFixed(2)
    }
    let sum_all_index = (arr) => {
        return arr.reduce(function(accumulateur, valeurCourante, index, array){
            return accumulateur + valeurCourante;
        });
    }
    let set_total_data = (datasets) => {
        let d = []
        mounths.forEach((i, key) => {
            let sum_temp = 0;
            datasets.forEach(ds => {
                sum_temp += ds.data[key];
            })
            d.push(sum_temp);
        })
        return d;
    }

    const ctx_bar = document.getElementById('myChart_bar').getContext('2d');
    let myChart_bar = new Chart(ctx_bar);
    const ctx_line_mounth = document.getElementById('myChart_line_mounth').getContext('2d');
    let myChart_line_mounth = new Chart(ctx_line_mounth);

    let config_chart = (type, labels, datasets) => {
        return {
            type: type,
            data: {
                labels: labels,
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
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                if(datasets.total == undefined) {
                                    let sum = sum_all_index(context.dataset.data);
                                    return context.dataset.label+ " : " +context.dataset.data[context.dataIndex]+ " ("+percentage(context.dataset.data[context.dataIndex], sum)+" %)";
                                } else {
                                    return context.dataset.label+ " : " +context.dataset.data[context.dataIndex]+ " sur "+ datasets.total[context.dataIndex] +" ("+percentage(context.dataset.data[context.dataIndex], datasets.total[context.dataIndex])+" %)";
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    let callchart = (d, l) => {
        myChart_bar.destroy();
        
        temp_bar = new Chart(ctx_bar, config_chart('bar', l, d));
        myChart_bar = temp_bar;
    }
    
    let callchart_month = (d) => {
        myChart_line_mounth.destroy();
        temp_line_mounth = new Chart(ctx_line_mounth, config_chart('line', mounths, d));
        myChart_line_mounth = temp_line_mounth;
    }
    
        // Evenement Bouton Filtrer
        $('#valid_filter').on('click', function(e) {
            e.preventDefault()
            let temp_customer = null;
            let temp_valeur = null;
            let temp = $('#form_filter').serializeArray();

            temp_customer = (_.filter(temp, { name: "customer" })).length != 0 ? _.map(_.filter(temp, { name: "customer" }), "value") : c_label;
            temp_valeur = (_.filter(temp, { name: "valeur" })).length != 0 ? _.map(_.filter(temp, { name: "valeur" }), "value") : lv_label;
            let tickets_filter_c = [];
            let tickets_filter_v = [];

            if(temp_customer && temp_valeur) {
                
                temp_customer.forEach(c => {
                    tickets_filter_c = [...tickets_filter_c, ...filter_by_client(all_tickets, c)];
                });

                temp_valeur.forEach(v => {
                    let item = null;
                    switch(v) {
                        case "Pas du tout satisfait" : item = "0"; break;
                        case "Peu satisfait" : item = "1"; break;
                        case "Plutôt satisfait" : item = "2"; break;
                        case "Très satisfait" : item = "3"; break;
                        default: break;
                    }
                    tickets_filter_v = [...tickets_filter_v, ...filter_by_value(tickets_filter_c, item)]
                })
            }
            retrieve_valeur(tickets_filter_v);
            retrieve_client(tickets_filter_v, temp_customer, temp_valeur);
        })

        let get_data_valeur = (tickets, valeur) => {
            if(tickets.length == 0) return null;
            let v = filter_by_value(tickets, valeur);
            return v.length;
        }

        let get_data_client = (tickets, client, _valeur) => {
            let d = []
            let c = filter_by_client(tickets, client);
            list_valeur.forEach(lv => {
                if(_valeur.indexOf(lv.label) !== -1) {
                    d.push(_.filter(c, { valeur: lv.flag }).length);
                } else {
                    d.push(0);
                }
            })
            return d;
        }

        let getMonth = (date) => {
            return new Date(date).getMonth();
        }
        let retrieve_valeur = (tickets) => {
            let datasets = [];
            let count = 0;
            lv_label.forEach(lv => {
                datasets.push({
                    label: lv,
                    borderColor: [colors[count]],
                    backgroundColor: [colors[count]],
                    borderWidth: 2,
                })
                count++;
            })
            datasets.forEach((d, key_d) => {
                let data = []
                
                mounths.forEach((i, key_m) => {
                    data.push(get_data_valeur(_.filter(tickets, o => getMonth(o.date_feedback) == key_m ), key_d+""));
                })
                datasets[key_d].data = data
            })
            datasets.total = set_total_data(datasets);
            callchart_month(datasets);
        }

        let retrieve_client = (tickets, client, valeur) => {
            console.log(client, valeur)
            $('.total_client').html(client.length)
            filter();
            let datasets = []
            let count = 0;
            
            client.forEach(c => {
                let data = get_data_client(tickets, c, valeur);
                sum_all = sum_all_index(data);
                let divs = "";
                
                data.forEach(d => {
                    t = with_zero(d);
                    divs += `<div>`+ t +`</div>`
                })
                $('.filter').append(`
                    <div class="item">
                        <div class="title" style="background-color: `+colors[count]+`">`+ c +`</div>
                        `+divs+`
                        <div>`+ with_zero(sum_all) +`</div>
                    </div>
                `)
                datasets.push({
                    label: c,
                    data: data,
                    borderColor: [colors[count]],
                    backgroundColor: [colors[count]],
                    borderWidth: 2
                })
                count++;
            })
            callchart(datasets, lv_label);
        }

        let filter = () => {
            $('.filter').html('');
            $('.filter').append(`
                <div class="item">
                    <div>-</div>
                    <div>Pas du tout satisfait</div>
                    <div>Peu satisfait</div>
                    <div>Plutôt satisfait</div>
                    <div>Très satisfait</div>
                </div>
            `)
        }

        retrieve_valeur(all_tickets);
        retrieve_client(all_tickets, c_label, lv_label);

</script>