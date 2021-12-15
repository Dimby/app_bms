<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-6">
            <h2>Votre feedback a été enregistré.</h2>
            <p>Vous êtes : <span id="avis_ticket"></span></p>
            <p>Ajouter un commentaire * :</p> <br>
            <form id="from_comment_ticket">
                <div class="form-group">
                    <textarea class="form-control" id="exampleFormControlTextarea1" name="commentaire" rows="4"></textarea>
                    <small class="form-text text-muted" style="font-style: italic">* Facultatif</small>
                </div>
                <input type="submit" class="btn btn-primary" value="Envoyer" style="background_color: #00a99d;">
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let id_ticket = getParameter('id');
        let value = getParameter('value');
        switch(value) {
            case '0':
                $('#avis_ticket').html('Pas du tout satisfait');
                break;
            case '1':
                $('#avis_ticket').html('Peu satisfait');
                break;
            case '2':
                $('#avis_ticket').html('Plutôt satisfait');
                break;
            case '3':
                $('#avis_ticket').html('Tres satisfait');
                break;
            default:
                location.replace('<?= site_url('') ?>');
                break;
        }
    });

    $('#from_comment_ticket').on('submit', function(e) {
        e.preventDefault();
        let data = $(this).serializeArray();
        console.log(data);
        $.ajax({
            url: "<?= site_url('/tickets/add_ticket') ?>",
            method: "POST",
            data: data,
            success: function(msg) {
                location.replace('<?= site_url('/tickets/register_success') ?>');
            }
        })
    })

    let getParameter = function(parametre) {
        let params = new URLSearchParams(window.location.search);
        return params.get(parametre);
    }
</script>