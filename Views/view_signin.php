<!DOCTYPE html>
<html lang="fr">   

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
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
        <div class="sign-form-in"> 
            <?php   
            echo $errorLogin;
            ?>
            <form action="?controller=signin&action=signin" method="post" class="sign-form-info">
                <input type="email" placeholder="Adresse e-mail" name="email" required>

                <div class="password-container">
                    <input id="password" type="password" placeholder="Mot de passe" name="password" required>
                    <i class="fas fa-eye" id="togglePassword" style="cursor: pointer; position: absolute; right: 15px; top: 15px;"></i>
                </div>
                <a href="#" style="text-align: center; color: #000000;">Mot de passe oublié ?</a>

                <button type="submit">Se connecter</button>
                <p>Pas encore inscrit ?<br><a href="?controller=signup" style="color: black;">Inscrivez-vous.</a></p>
            </form>
        </div>
    </div>    
</body>
</html>