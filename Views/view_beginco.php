<!DOCTYPE html>
<html lang="fr">   

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulat</title>
    <link rel="stylesheet" href="Content/style.css"/>
    <link rel="icon" href="img/logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600,700,800,900&display=swap&subset=arabic" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="Content/script.js" defer></script>
</head>

<body>
    <header>
        <div class="head1">
            <a href="?index.php"><img src="img/logo.png" alt="logo"></a>
            <p>Consulat général<br>de la République<br>arabe d’Égypte</p>
        </div>

        <!-- Menu principal pour les grands écrans -->
        <div class="head2"> 
            <a href="?controller=home" class="nb_a">Accueil</a>
            <a href="?controller=visa" class="nb_a">Demande d'e-Visa</a>
            <a href="?controller=user" class="nb_a">Suivi</a>
            <a href="deco.php" class="b_deco" style="color: #ffffff">
                <i class="fa-solid fa-power-off"></i>
            </a> 
        </div>

        <!-- Bouton hamburger pour les petits écrans -->
        <button class="navbar-toggler" type="button" onclick="toggleMenu()">
            <i class="fas fa-bars navbar-toggler-icon"></i>
        </button>

        <!-- Menu mobile -->
        <nav id="navbarNav" class="navbar-collapse">
            <a href="?controller=home" class="nb_a">Accueil</a>
            <a href="?controller=visa" class="nb_a">Demande d'e-Visa</a>
            <a href="?controller=user" class="nb_a">Suivi</a>
            <a href="deco.php" class="b_deco" style="color: #ffffff">
                <i class="fa-solid fa-power-off"></i>
            </a>        
        </nav>
    </header>

    <div class="tricolor-bar">
        <div class="red"></div>
        <div class="white"></div>
        <div class="black"></div>
    </div>

    <!-- Script pour activer/désactiver le menu mobile -->
    <script>
        function toggleMenu() {
            var navbarNav = document.getElementById("navbarNav");
            navbarNav.classList.toggle("show");
        }
    </script>
