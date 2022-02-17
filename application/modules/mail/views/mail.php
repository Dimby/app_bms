Bonjour Support, <br><br>
Un feedback pour le ticket : <b><?= $id_ticket ?> - <?= $ticket_title ?> </b> a été enregistré. <br>
<?php
    switch($valeur) {
        case '0':
            $v = "Pas du tout satisfait";
            break;
        case '1':
            $v = "Peu satisfait";
            break;
        case '2':
            $v = "Plutôt satisfait";
            break;
        case '3':
            $v = "Très satisfait";
            break;
        default:
            $v = "";
            break;
    }
?>
Evaluation : <b><?= $v ?></b> <br><br>
<a href="https://bms.aveolys.com" target="blank">Voir les détails.</a><br><br>
Merci.