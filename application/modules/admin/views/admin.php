
<?php 
    // var_dump($all_tickets_by_clients);
    // var_dump($clients);
    // var_dump($data_chart);
    // var_dump($last_value);
    // var_dump($list_value);
    // var_dump($min_date);
    // var_dump($max_date);
    // var_dump($all_tickets);

    $sess_tickets = $this->session->userdata('tickets') != NULL ? $this->session->userdata('tickets') : '';
    $active_ticket = isset($sess_tickets['active_ticket']) ? $sess_tickets['active_ticket'] : '';
    $active_stat = isset($sess_tickets['active_stat']) ? $sess_tickets['active_stat'] : '';
    

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
        <?= $list_tickets ?>
    </div>
    <div role="tabpanel" class="tab-pane <?= $active_stat ?>" id="profile">
        <?= $statistiques ?>
    </div>
  </div>
</div>

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

</script>