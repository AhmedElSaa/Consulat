<!DOCTYPE html>
<html lang="fr">   

<head>
    <meta charset="utf-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="Content/style.css"/>
    <link rel="icon" href="img/logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600,800,900&display=swap&subset=arabic" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="Content/script.js" defer></script>
</head>

<body class="sign">

    <div class="sign-back">
        <a href="index.php">&#10094;Retour à l'accueil</a>
    </div>
    
    <div class="sign-container">
        <div class="sign-form"> 
            <?php echo $successMsg; ?>

            <form action="?controller=signup&action=signup" class="sign-form-info" method="post">
                <input type="text" placeholder="Nom" name="nom" required>
                <input type="text" placeholder="Prénom" name="prenom" required>
                <input type="email" placeholder="Adresse e-mail" name="email" required>

                <select id="nationSelect" name="nations" required>
                    <option value="" disabled selected hidden>Nationnalité</option>
                    <?php foreach ($nations as $nation): ?>
                        <option value="<?php echo $nation['id_nat']; ?>"><?php echo $nation['nation']; ?></option>
                    <?php endforeach; ?>
                </select> 

                <input type="text" placeholder="N° Passeport" name="numPass">
                <label for="dateExpPass">Date de d'expiration du passeport</label>
                <input id="dateExpPass" type="date" name="dateExpPass" required>
                <label for="dateNaissance">Date de naissance</label>
                <input id="dateNaissance" type="date" name="dateNaissance" required>
                
                <div class="password-container">
                    <input id="password" type="password" placeholder="Mot de passe" name="password" required>
                    <i class="fas fa-eye" id="togglePassword" style="cursor: pointer; position: absolute; right: 15px; top: 15px;"></i>
                </div>

                <div class="password-container">
                    <input id="password_c" type="password" placeholder="Confirmer le mot de passe" name="password_c" required>
                    <i class="fas fa-eye" id="toggleConfirmPassword" style="cursor: pointer; position: absolute; right: 15px; top: 15px;"></i>
                </div>

                <div class="checkbox">
                    <label><input type="checkbox" name="conditions" required> J'ai lu et accepte les conditions générales*</label>
                </div>

                <div class="checkbox">
                    <label><input type="checkbox" id="loterie" name="loterie" value="1">Participer à la loterie</label>
                </div>

                <button type="submit">S'inscrire</button>
                <p>Vous possédez déjà un compte ? <br><a href="?controller=signin" style="color: black;">Identifiez-vous.</a></p>
            </form>
        </div>
             
        
        <div>
            <div class="sign-error">
                <?php   
                echo $errorMessages;
                ?>
            </div>
                        
            <div class="sign-loterie">
                <h2>Règle de la loterie</h2>
                <p>
                    La loterie pour la nationalité égyptienne est un concept auquel chaque utilisateur peut choisir de s'inscrire gratuitement. Les participants sont inscrits jusqu'à ce que le nombre nécessaire soit atteint, 
                    après quoi un tirage au sort est organisé pour désigner un gagnant. Ce gagnant reçoit la nationalité égyptienne, et toutes les informations des participants sont traitées de manière confidentielle.
                    Le tirage est effectué de manière transparente. Participer signifie accepter les règles du concept, avec la compréhension que seule la chance déterminera le gagnant.
                </p>
            </div>
        </div>               

    </div>    
</body>
</html>