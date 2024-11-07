<?php require 'view_beginco.php'; ?>

<main style="height: 76.7vh;">
    
    <h1 style="text-align: center;">Paiement de 50€</h1>

    <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <div class="form_user">
        <form action="?controller=user&action=submit_payment" method="post">
            <div>
                <label for="card_number">Numéro de Carte :</label>
                <input type="text" id="card_number" name="card_number" required><br>
            </div>

            <div>
                <label for="card_cvv">Code CVV :</label>
                <input type="text" id="card_cvv" name="card_cvv" required><br>
            </div>
            
            <div>
                <label for="card_expiry">Date d'expiration (AAAA-MM) :</label>
                <input type="month" id="card_expiry" name="card_expiry" required><br>
            </div>
            
            <div>
                <button type="submit" class="bt_user">Payer</button>
            </div>
        </form>
    </div>

</main>
<?php require 'view_end.php'; ?>
