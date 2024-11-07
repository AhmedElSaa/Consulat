<?php require 'view_beginco.php'; ?>

<main style="height: 76.7vmin;">

    <h1 style="text-align: center;">Informations de Résidence</h1>

    <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <div class="form_user">
        <form action="?controller=user&action=new_request" method="post">
            <div>
                <label for="pays_residence">Pays de résidence :</label>
                <input type="text" id="pays_residence" name="pays_residence" required><br>
            </div>

            <div>
                <label for="adresse">Adresse :</label>
                <input type="text" id="adresse" name="adresse" required><br>
            </div>

            <div>
                <label for="code_postal">Code Postal :</label>
                <input type="text" id="code_postal" name="code_postal" required><br> 
            </div>

            <div>
                <label for="ville">Ville :</label>
                <input type="text" id="ville" name="ville" required><br>
            </div>

            <div>
                <button type="submit" class="bt_user">Continuer vers le paiement</button>
            </div>

        </form>
    </div>
    
</main>

<?php require 'view_end.php'; ?>
