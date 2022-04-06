
<br><br><br>
<div class="row" style="display: flex; justify-content: center; align-items: center">
    <div class="col-lg-4">
        <form id="login_form">
            <center><h1>Connexion</h1></center>
            <div class="form-group">
                <label for="user_email">Nom d'utilisateur</label>
                <input type="text" id="user_email" name="user_email" class="form-control" placeholder="Votre nom">
            </div>
            <div class="form-group">
                <label for="user_password">Mot de passe</label>
                <input type="password" id="user_password" name="user_password"class="form-control" placeholder="Votre mot de passe">
            </div>

            <input type="submit" id="login_submit" value="Connecter" class="btn btn-primary">
        </form>
        <?php
            $message = $this->session->flashdata('message');
            if($message) {
                ?>
                    <div class="bms-alert">
                        <div class="alert alert-danger">
                            <?= $message; ?>        
                        </div>
                    </div>
                <?php
            }
        ?>
    </div>
</div>
<br><br>
<br><br>

<script>
    // Choix 1
    $('#login_submit').on('click', function(e) {
        e.preventDefault()
        // alert ('mety');
        let data_login = $('#login_form').serializeArray();
        $.ajax({
            url: '<?= site_url('security/authentification') ?>',
            method: "POST",
            data: data_login,
            success: function(msg) {
                location.reload('/')
            }
        })
    })
</script>
