<?php require 'view_begin.php'; ?>

<div class="loader-container">
        <div class="loader-flag">
            <img src="https://upload.wikimedia.org/wikipedia/commons/f/fe/Flag_of_Egypt.svg" alt="Drapeau de l'Égypte">
        </div>
    </div>

<main>

    <div class="home-present">
        <img src="img/luxor.jpg" alt="img-accueil">
        <div class="home-present-text">
            <h1>Consulat d'Égypte</h1>
            <p>
                Bienvenue sur le site officiel de la reproduction des services consulaires égyptiens, <br>
                votre portail dédié aux démarches administratives simplifiées et à l'assistance <br>
                personnalisée pour les citoyens égyptiens à l'étranger.<br>
            </p>
        </div>
    </div>

    <div class="home-contact">
        <div class="home-contact-info"><i class="fa-solid fa-phone"></i><div>Téléphone<br>+33 1 55 21 43 70</div></div>
        <div class="home-contact-info"><i class="fa-solid fa-envelope"></i><div>E-mail<br>consulate.paris@gmail.com</div></div>
        <div class="home-contact-info"><i class="fa-solid fa-map-pin"></i><div>Adresse<br>53 Bd Bineau, 92200</div></div>
    </div>

    <div class="home-info">
        <h1><b>À la Une</b></h1>
        <div class="container">
            <div class="row justify-content-between">
                
                <div class="custom-card col-md-4">
                    <div class="card">
                        <img src="img/case1.jpg" class="card-img-top" alt="Image 1">
                        <div class="card-body">
                            <h2>L'Égypte livre des armes à la Somalie</h2>
                            <p class="card-text">L'Égypte livre des armes à la Somalie pour renforcer sa défense.</p>
                        </div>
                    </div>
                </div>

                <div class="custom-card col-md-4">
                    <div class="card">
                        <img src="img/case2.jpg" class="card-img-top" alt="Image 2">
                        <div class="card-body">
                            <h2>Nouvelle découverte sous la Grande Pyramide de Gizeh</h2>
                            <p class="card-text">Les archéologues trouvent un tunnel caché sous la pyramide.</p>
                        </div>
                    </div>
                </div>

                <div class="custom-card col-md-4">
                    <div class="card">
                        <img src="img/case3.jpg" class="card-img-top" alt="Image 3">
                        <div class="card-body">
                            <h2>Le 129 débarque au Caire</h2>
                            <p class="card-text">Le 129 s'installe au Caire avec des recettes exclusives.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="home-culture">
        <h1><b>Point Culture</b></h1>
        <div class="carousel">
            <button class="prev" onclick="prevSlide()">&#10094;</button>
            <div class="carousel-track-container">
                <div class="carousel-track">

                    <div class="custom-card2">
                        <div class="card">
                            <img src="img/car1.jpg" class="card-img-top" alt="Image 1">
                            <div class="card-body">
                                <p class="card-text">Adel Imam, légende du cinéma.</p>
                            </div>
                        </div>
                    </div>

                    <div class="custom-card2">
                        <div class="card">
                            <img src="img/car2.jpg" class="card-img-top" alt="Image 2">
                            <div class="card-body">
                                <p class="card-text">Omo Kalthoum, la plus belle voix arabe.</p>
                            </div>
                        </div>
                    </div>

                    <div class="custom-card2">
                        <div class="card">
                            <img src="img/car3.jpg" class="card-img-top" alt="Image 3">
                            <div class="card-body">
                                <p class="card-text">Le mahshi, le plat traditionnel égyptien.</p>
                            </div>
                        </div>
                    </div>

                    <div class="custom-card2">
                        <div class="card">
                            <img src="img/car4.jpg" class="card-img-top" alt="Image 4">
                            <div class="card-body">
                                <p class="card-text">Les Pyramides, dernières merveille du monde.</p>
                            </div>
                        </div>
                    </div>

                    <div class="custom-card2">
                        <div class="card">
                            <img src="img/car5.jpg" class="card-img-top" alt="Image 5">
                            <div class="card-body">
                                <p class="card-text">Un tout nouveau musée au Caire.</p>
                            </div>
                        </div>
                    </div>

                    <div class="custom-card2">
                        <div class="card">
                            <img src="img/car6.jpg" class="card-img-top" alt="Image 6">
                            <div class="card-body">
                                <p class="card-text">Place du Vieux Marché, Sharm  El-Sheikh.</p>
                            </div>
                        </div>
                    </div>

                    <div class="custom-card2">
                        <div class="card">
                            <img src="img/car7.jpg" class="card-img-top" alt="Image 7">
                            <div class="card-body">
                                <p class="card-text">Les plus belles plages d'Afrique.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <button class="next" onclick="nextSlide()">&#10095;</button>
        </div>
    </div>
    
    <div class="home-fiche">
        <h2>Fiche pratique</h2>
        <div class="home-fiche-titles">
            <div class="home-fiche-gauche">
                <div class="home-fiche-info"><i class="fa-solid fa-money-bill"></i>Livre égyptien</div>
                <div class="home-fiche-info"><i class="fa-solid fa-user-group"></i>106 M d'habitants</div>
                <div class="home-fiche-info"><i class="fa-solid fa-ruler-combined"></i>1 M de km²</div>
                <div class="home-fiche-info"><i class="fa-solid fa-water"></i>Le Nil</div>
            </div>
            <div class="home-fiche-droite">
                <div class="home-fiche-info"><i class="fa-solid fa-language"></i>Arabe</div>
                <div class="home-fiche-info"><i class="fa-solid fa-shield"></i>1er puissance militaire africaine</div>
                <div class="home-fiche-info"><i class="fa-solid fa-clock"></i>GMT +2</div>
                <div class="home-fiche-info"><i class="fa-solid fa-map-pin"></i>Le Caire</div>
            </div>
        </div>
    </div>

    <div class="home-end">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2623.5059991807657!2d2.279798976757265!3d48.886693198713814!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66f888a10d50f%3A0x470c1d6f179b1112!2s53%20Bd%20Bineau%2C%2092200%20Neuilly-sur-Seine!5e0!3m2!1sfr!2sfr!4v1729352172745!5m2!1sfr!2sfr" width="600" height="600" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="home-end-maps"></iframe>
        
        <div class="home-end-container">
            <form action="#" method="POST" class="home-end-form">

                <div class="form-group">
                    <label for="lastname">Nom complet</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="subject">Sujet</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>
                
                <button type="submit" class="home-end-bt">Envoyer</button>
            </form>
        </div>
    </div>
</main>

<?php require 'view_end.php'; ?>