<?php require 'view_beginco.php'; ?>

<main>
    
    <h1 style="text-align: center;">Récapitulatif de la Demande</h1>

    <div class="form_user">
        
        <h3>Vos Informations Personnelles</h3>

        <p><strong>Nom :</strong> <?php echo htmlspecialchars($user['nom']); ?></p>
        <p><strong>Prénom :</strong> <?php echo htmlspecialchars($user['prenom']); ?></p>
        <p><strong>Email :</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Nationalité :</strong> <?php echo htmlspecialchars($user['nation']); ?></p>
        <p><strong>Date de Naissance :</strong> <?php echo htmlspecialchars($user['dateNaissance']); ?></p>

        <h3>Informations du Passeport</h3>
        <p><strong>Numéro de Passeport :</strong> <?php echo htmlspecialchars($user['numPass']); ?></p>
        <p><strong>Date d'Expiration du Passeport :</strong> <?php echo htmlspecialchars($user['dateExpPass']); ?></p>

        <h3>Informations de la Demande</h3>
        <p><strong>Pays de résidence :</strong> <?php echo htmlspecialchars($request_data['pays_residence']); ?></p>
        <p><strong>Adresse :</strong> <?php echo htmlspecialchars($request_data['adresse']); ?></p>
        <p><strong>Code Postal :</strong> <?php echo htmlspecialchars($request_data['code_postal']); ?></p>
        <p><strong>Ville :</strong> <?php echo htmlspecialchars($request_data['ville']); ?></p>

        <form action="?controller=user&action=submit_request" method="post">
            <button type="submit" name="confirm" class="bt_user">Confirmer</button>
            <button type="submit" name="cancel" class="bt_user">Annuler</button>
        </form>

    </div>

</main>

<?php require 'view_end.php'; ?>
