<?php
    function percentage($votes, $val) {
        return round(($val*100)/$votes, 2);
    }

    $clients_json = json_encode((array) $clients);
?>
<div class="filter_button">
    <button class="btn btn-secondary" data-toggle="modal" data-target="#filter_modal"><span class="glyphicon glyphicon-filter"></span> Filtrer</button>
</div>
<div class="row">
    <div class="alert col-lg-12">
        <div class="wheel-years">
        </div>
    </div>
    <div class="col-lg-12">
        <canvas id="myChart_line_mounth" height="70%"></canvas>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-lg-12 table_filter"></div>
    <div class="col-lg-12"><hr></div>
    <div class="col-lg-12 text-center">
        <span class="badge v1-color">-</span> : Pas du tout satisfait &nbsp;
        <span class="badge v2-color">-</span> : Peu satisfait &nbsp;
        <span class="badge v3-color">-</span> : Plutôt satisfait &nbsp;
        <span class="badge v4-color">-</span> : Très satisfait &nbsp;
        <hr>
    </div>
</div>

<div>
    <div>
        <div class="row">
            </div><br>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <canvas id="myChart_bar" width="100%"></canvas>
                    </div>
                    <div class="col-lg-6">
                        <canvas id="myChart_line" width="100%"></canvas>
                    </div>
                </div>
                <br><br><br>
                <br><br><br>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="filter_modal" tabindex="-1" role="dialog" aria-labelledby="delete">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        Filter
      </div>
      <div class="modal-body">
      <form action="" id="form_filter">
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

            <button type="submit" class="btn btn-primary" id="valid_filter">Filtrer</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>

    let year = '<?= $year ?>';
    const equart = 4;
    let year_now = new Date().getFullYear();

    let turn_wheel_year = (year) => {
        let str = '';
        for (let i = parseInt(year, 10)-equart; i <= parseInt(year, 10); i++) { 
            if(i == parseInt(year, 10)) {
                str += `
                    <div class="item active" data-value="`+i+`">`+i+`</div>
                `;
            } else {
                str += `
                    <div class="item" data-value="`+i+`">`+i+`</div>
                `
            }
        }
        return str;
    }
    $('.wheel-years').append('<div class="item-now" data-value="next">Aoujourd\'hui</div>')
    $('.wheel-years').append(turn_wheel_year(year))
    let disabled = year_now == parseInt(year, 10) ? 'disabled-event' : '';
    $('.wheel-years').append('<div class="item-next '+disabled+'" data-value="next"><span class="glyphicon glyphicon-chevron-right"></span></div>');

    let ajax_func = (lien, data) => {
        $.ajax({
            url: lien,
            method: "POST",
            data: data,
            success: function() {
                // location.reload();
            }
        });
    }

    
    $('.wheel-years .item-next').on('click', function(e) {
        e.preventDefault()
        ajax_func("<?= site_url('admin/change_year') ?>", [{name: 'year', value: parseInt(year, 10)+1}])
    })

    $('.wheel-years .item-now').on('click', function(e) {
        e.preventDefault()
        ajax_func("<?= site_url('admin/change_year') ?>", [{name: 'year', value: year_now}])
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
    let months = ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'];
    let all_tickets = <?= $all_tickets ?>;
    console.dir(all_tickets);
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
        months.forEach((i, key) => {
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
    const ctx_line = document.getElementById('myChart_line').getContext('2d');
    let myChart_line = new Chart(ctx_line);
    const ctx_line_mounth = document.getElementById('myChart_line_mounth').getContext('2d');
    let myChart_line_mounth = new Chart(ctx_line_mounth);

    let config_chart = (type, labels, datasets, clients) => {
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
                        title: {
                            display: true,
                            text: "Client(s) : "+clients
                        }
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

    let callchart = (d, l, c) => {
        myChart_bar.destroy();
        myChart_line.destroy();
        
        temp_bar = new Chart(ctx_bar, config_chart('bar', l, d, c));
        myChart_bar = temp_bar;
        
        temp_line = new Chart(ctx_line, config_chart('line', l, d, c));
        myChart_line = temp_line;
    }
    
    let callchart_month = (d, c) => {
        myChart_line_mounth.destroy();

        temp_line_mounth = new Chart(ctx_line_mounth, config_chart('line', months, d, c));
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
        retrieve_valeur(tickets_filter_v, temp_customer);
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

    let get_data_client_months = (tickets, client, _valeur) => {
        let d_month = [];
        let c = filter_by_client(tickets, client);
        months.map((month, key) => {
            let x = _.filter(c, function(o) {
                return new Date(o.date_feedback).getMonth() == key
            })
            let d = [];
            list_valeur.forEach(lv => {
                if(_valeur.indexOf(lv.label) !== -1) {
                    d.push(_.filter(x, { valeur: lv.flag }).length);
                } else {
                    d.push(0);
                }
            })
            d_month.push(d);
        })
        return d_month;
    }

    let getMonth = (date) => {
        return new Date(date).getMonth();
    }
    let retrieve_valeur = (tickets, clients) => {
        let datasets = [];
        let count = 0;
        lv_label.forEach(lv => {
            datasets.push({
                label: lv,
                borderColor: [colors[count]],
                backgroundColor: [colors[count]],
                borderWidth: 3,
            })
            count++;
        })
        datasets.forEach((d, key_d) => {
            let data = []
            
            months.forEach((i, key_m) => {
                data.push(get_data_valeur(_.filter(tickets, o => getMonth(o.date_feedback) == key_m ), key_d+""));
            })
            datasets[key_d].data = data
        })
        datasets.total = set_total_data(datasets);
        callchart_month(datasets, clients);
    }

    let retrieve_client = (tickets, client, valeur) => {
        $('.total_client').html(client.length)
        let datasets = []
        let count = 0;
        let datas = [];
        
        client.forEach(c => {
            let data = get_data_client(tickets, c, valeur);
            datas.push(get_data_client_months(tickets, c, valeur));
            sum_all = sum_all_index(data);
            let divs = "";
            
            data.forEach(d => {
                t = with_zero(d);
                divs += `<div>`+ t +`</div>`
            })
            datasets.push({
                label: c,
                data: data,
                borderColor: [colors[count]],
                backgroundColor: [colors[count]],
                borderWidth: 2
            })
            count++;
        })
        
        table_filter(client, datas);
        callchart(datasets, lv_label, client);
    }

    let table_filter = (client, data) => {
        $('.table_filter').html('');
        $('.table_filter').append(`
            <table class="table table-responsive" style="width: 100%">
                <thead>
                    <tr>
                        <th scope="col">Année `+year+` | Client(s)</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        `);
        let str = '';
        client.map(c => {
            str += '<th scope="col">'+ c +'</th>';
        })
        $('.table_filter .table thead tr').append(str)
        months.map((item, key) => {
            str = ''
            data.map(d => {
                str_temp = '';
                str_temp += (d[key][0] != 0) ? '<span class="badge v1-color">'+with_zero(d[key][0])+'</span>' : '<span class="badge v1-color">-</span>'
                str_temp += (d[key][1] != 0) ? '<span class="badge v2-color">'+with_zero(d[key][1])+'</span>' : '<span class="badge v2-color">-</span>'
                str_temp += (d[key][2] != 0) ? '<span class="badge v3-color">'+with_zero(d[key][2])+'</span>' : '<span class="badge v3-color">-</span>'
                str_temp += (d[key][3] != 0) ? '<span class="badge v4-color">'+with_zero(d[key][3])+'</span>' : '<span class="badge v4-color">-</span>'
                str_temp += ' '+with_zero(sum_all_index(d[key]))+' ticket(s)'
                str += '<td>'+str_temp+'</td>'
            })

            $('.table_filter .table tbody').append(`
                <tr>
                    <th scope="row">`+item+`</th>
                    `+str+`
                </tr>
            `)
        })

        $('.table_filter .table tbody').append(`
            <tr class="totals">
                <th scope="row" style="color: #4dbdc3">Total :</th>
            </tr>
        `)
        data.map(d => {
            str = '';
            let temp_0 = 0;
            let temp_1 = 0;
            let temp_2 = 0;
            let temp_3 = 0;
            let t = 0;
            d.map(i => {
                temp_0 += i[0];
                temp_1 += i[1];
                temp_2 += i[2];
                temp_3 += i[3];
                t = temp_0+temp_1+temp_2+temp_3;
            })
            str += '<span class="badge v1-color">'+with_zero(temp_0)+'</span>';
            str += '<span class="badge v2-color">'+with_zero(temp_1)+'</span>';
            str += '<span class="badge v3-color">'+with_zero(temp_2)+'</span>';
            str += '<span class="badge v4-color">'+with_zero(temp_3)+'</span>';
            str += ' '+t+' ticket(s)';

            $('.table_filter .table tbody .totals').append(`
                <td>`+str+`</td>
            `)
        })
    }

    retrieve_valeur(all_tickets, c_label);
    retrieve_client(all_tickets, c_label, lv_label);

    // ----------------------------------------------------------------------------------

    $('.wheel-years .item').on('click', function(e) {
        e.preventDefault()
        ajax_func("<?= site_url('admin/change_year') ?>", [{name: 'year', value: $(this).data('value')}])
    })

</script>