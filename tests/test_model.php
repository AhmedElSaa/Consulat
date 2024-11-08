<?php

require_once '../Models/model.php'; 

$model = Model::getModel();

// Test de la méthode getNation()
try {
    echo "Test de la méthode getNation()<br>";
    $nations = $model->getNation();
    if (!empty($nations)) {
        echo "Succès : getNation() a retourné " . count($nations) . " nations.<br>";
    } else {
        echo "Échec : getNation() a retourné un tableau vide.<br>";
    }
} catch (Exception $e) {
    echo "Erreur dans getNation() : " . $e->getMessage() . "<br>";
}

echo "<br>";echo "<br>";


// Test de la méthode createUser()
try {
    echo "Test de la méthode createUser()<br>";

    // Données de test
    $nom = 'Test';
    $prenom = 'User';
    $email = 'test.user@example.com';
    $id_nation = 1;
    $numPass = 'AB1234567';
    $dateExpPass = '2030-12-31';
    $dateNaissance = '1990-01-01';
    $password = password_hash('motdepasse', PASSWORD_DEFAULT);
    $loterie = 0;
    $role = 'user';

    // Vérifier si l'email existe déjà
    if ($model->emailExists($email)) {
        echo "L'email $email est déjà utilisé. Suppression de l'utilisateur existant pour le test.<br>";
        $existingUser = $model->findUserByEmail($email);
        $model->removeUsers($existingUser['id_utilisateur']);
    }

    // Créer l'utilisateur
    $id_utilisateur = $model->createUser($nom, $prenom, $email, $id_nation, $numPass, $dateExpPass, $dateNaissance, $password, $loterie, $role);
    echo "Utilisateur créé avec succès. ID : $id_utilisateur<br>";

    // Vérifier que l'utilisateur a été créé
    $user = $model->findUserById($id_utilisateur);
    if ($user) {
        echo "Utilisateur trouvé : " . $user['nom'] . " " . $user['prenom'] . "<br>";
    } else {
        echo "Erreur : L'utilisateur créé n'a pas été trouvé.<br>";
    }

    // Supprimer de  la base de données
    $model->removeUsers($id_utilisateur);
    echo "Utilisateur de test supprimé.<br>";
} catch (Exception $e) {
    echo "Erreur dans createUser() : " . $e->getMessage() . "<br>";
}

echo "<br>";echo "<br>";


// Test de la méthode findUserByEmail()
try {
    echo "Test de la méthode findUserByEmail()<br>";

    // Créer un utilisateur pour le test
    $email = 'testsss.find@example.com';
    $email2 = 'testsssss.find@example.com';
    $id_utilisateur = $model->createUser('Find', 'User', $email, 1, 'CD7654321', '2030-12-31', '1995-05-15', password_hash('password', PASSWORD_DEFAULT), 0, 'user');

    // Rechercher l'utilisateur
    $user = $model->findUserByEmail($email);
    if ($user) {
        echo "Utilisateur trouvé : " . $user['nom'] . " " . $user['prenom'] . "<br>";
    } else {
        echo "Échec : Aucun utilisateur trouvé avec l'email $email.<br>";
    }

    // Supprimer de  la base de données
    $model->removeUsers($id_utilisateur);
    echo "Utilisateur de test supprimé.<br>";
} catch (Exception $e) {
    echo "Erreur dans findUserByEmail() : " . $e->getMessage() . "<br>";
}

echo "<br>";echo "<br>";


// Test de la méthode findUserById()
try {
    echo "Test de la méthode findUserById()<br>";

    // Créer un utilisateur pour le test
    $email = 'test.findid@example.com';
    $id_utilisateur = $model->createUser('FindID', 'User', $email, 1, 'EF1234567', '2030-12-31', '1992-03-10', password_hash('password', PASSWORD_DEFAULT), 0, 'user');

    // Rechercher l'utilisateur par ID
    $user = $model->findUserById($id_utilisateur);
    if ($user) {
        echo "Utilisateur trouvé : " . $user['nom'] . " " . $user['prenom'] . "<br>";
    } else {
        echo "Échec : Aucun utilisateur trouvé avec l'ID $id_utilisateur.<br>";
    }

    // Supprimer de  la base de données
    $model->removeUsers($id_utilisateur);
    echo "Utilisateur de test supprimé.<br>";
} catch (Exception $e) {
    echo "Erreur dans findUserById() : " . $e->getMessage() . "<br>";
}

echo "<br>";echo "<br>";


// Test de la méthode emailExists()
try {
    echo "Test de la méthode emailExists()<br>";

    $email = 'test.exists@example.com';

    // S'assurer que l'email n'existe pas
    if ($model->emailExists($email)) {
        $existingUser = $model->findUserByEmail($email);
        $model->removeUsers($existingUser['id_utilisateur']);
        echo "Utilisateur existant avec l'email $email supprimé pour le test.<br>";
    }

    // Vérifier que l'email n'existe pas
    if (!$model->emailExists($email)) {
        echo "Succès : L'email $email n'existe pas.<br>";
    } else {
        echo "Échec : L'email $email devrait ne pas exister.<br>";
    }

    // Créer un utilisateur avec cet email
    $id_utilisateur = $model->createUser('Exists', 'User', $email, 1, 'GH7654321', '2030-12-31', '1990-12-01', password_hash('password', PASSWORD_DEFAULT), 0, 'user');

    // Vérifier que l'email existe maintenant
    if ($model->emailExists($email)) {
        echo "Succès : L'email $email existe maintenant.<br>";
    } else {
        echo "Échec : L'email $email devrait exister.<br>";
    }

    // Supprimer de  la base de données
    $model->removeUsers($id_utilisateur);
    echo "Utilisateur de test supprimé.<br>";
} catch (Exception $e) {
    echo "Erreur dans emailExists() : " . $e->getMessage() . "<br>";
}

echo "<br>";echo "<br>";


// Test de la méthode numPassExists()
try {
    echo "Test de la méthode numPassExists()<br>";

    $numPass = 'IJ1234567';

    // S'assurer que le numéro de passeport n'existe pas
    if ($model->numPassExists($numPass)) {
        $req = $model->db->prepare('SELECT id_utilisateur FROM utilisateurs WHERE numPass = ?');
        $req->execute([$numPass]);
        $id_utilisateur = $req->fetchColumn();
        $model->removeUsers($id_utilisateur);
        echo "Utilisateur existant avec le passeport $numPass supprimé pour le test.<br>";
    }

    // Vérifier que le passeport n'existe pas
    if (!$model->numPassExists($numPass)) {
        echo "Succès : Le passeport $numPass n'existe pas.<br>";
    } else {
        echo "Échec : Le passeport $numPass devrait ne pas exister.<br>";
    }

    // Créer un utilisateur avec ce passeport
    $id_utilisateur = $model->createUser('PassExists', 'User', 'test.pass@example.com', 1, $numPass, '2030-12-31', '1991-06-15', password_hash('password', PASSWORD_DEFAULT), 0, 'user');

    // Vérifier que le passeport existe maintenant
    if ($model->numPassExists($numPass)) {
        echo "Succès : Le passeport $numPass existe maintenant.<br>";
    } else {
        echo "Échec : Le passeport $numPass devrait exister.<br>";
    }

    // Supprimer de  la base de données
    $model->removeUsers($id_utilisateur);
    echo "Utilisateur de test supprimé.<br>";
} catch (Exception $e) {
    echo "Erreur dans numPassExists() : " . $e->getMessage() . "<br>";
}

echo "<br>";echo "<br>";

// Test de la méthode listUsers()
try {
    echo "Test de la méthode listUsers()<br>";

    $users = $model->listUsers();
    if (!empty($users)) {
        echo "Succès : listUsers() a retourné " . count($users) . " utilisateurs.<br>";
    } else {
        echo "Échec : listUsers() a retourné un tableau vide.<br>";
    }
} catch (Exception $e) {
    echo "Erreur dans listUsers() : " . $e->getMessage() . "<br>";
}

echo "<br>";echo "<br>";

// Test de la méthode removeUsers()
try {
    echo "Test de la méthode removeUsers()<br>";

    // Créer un utilisateur pour le test
    $id_utilisateur = $model->createUser('Remove', 'User', 'test.remove@example.com', 1, 'KL1234567', '2030-12-31', '1988-09-09', password_hash('password', PASSWORD_DEFAULT), 0, 'user');

    // Supprimer l'utilisateur
    $result = $model->removeUsers($id_utilisateur);
    if ($result) {
        echo "Succès : Utilisateur avec l'ID $id_utilisateur supprimé.<br>";
    } else {
        echo "Échec : L'utilisateur avec l'ID $id_utilisateur n'a pas pu être supprimé.<br>";
    }
} catch (Exception $e) {
    echo "Erreur dans removeUsers() : " . $e->getMessage() . "<br>";
}

echo "<br>";echo "<br>";

// Test de la méthode getNationIdByName()
try {
    echo "Test de la méthode getNationIdByName()<br>";

    $nationName = 'France';
    $id_nation = $model->getNationIdByName($nationName);

    if ($id_nation) {
        echo "Succès : L'ID de la nation '$nationName' est $id_nation.<br>";
    } else {
        echo "Échec : Nation '$nationName' non trouvée.<br>";
    }
} catch (Exception $e) {
    echo "Erreur dans getNationIdByName() : " . $e->getMessage() . "<br>";
}

echo "<br>";echo "<br>";

// Test de la méthode countParticipants()
try {
    echo "Test de la méthode countParticipants()<br>";

    // Créer des utilisateurs participants à la loterie
    $emails = ['participant1@example.com', 'participant2@example.com'];
    foreach ($emails as $email) {
        $model->createUser('Participant', 'User', $email, 2, 'MN' . rand(1000000, 9999999), '2030-12-31', '1990-01-01', password_hash('password', PASSWORD_DEFAULT), 1, 'user');
    }

    $count = $model->countParticipants();
    echo "Nombre de participants à la loterie : $count<br>";

    // Supprimer de  la base de données
    foreach ($emails as $email) {
        $user = $model->findUserByEmail($email);
        $model->removeUsers($user['id_utilisateur']);
    }
    echo "Utilisateurs de test supprimés.<br>";
} catch (Exception $e) {
    echo "Erreur dans countParticipants() : " . $e->getMessage() . "<br>";
}

echo "<br>";echo "<br>";

// Test de la méthode selectRandomWinner()
try {
    echo "Test de la méthode selectRandomWinner()<br>";

    // Créer des utilisateurs participants à la loterie
    $emails = ['winner1@example.com', 'winner2@example.com', 'winner3@example.com'];
    foreach ($emails as $email) {
        $model->createUser('Winner', 'User', $email, 2, 'OP' . rand(1000000, 9999999), '2030-12-31', '1990-01-01', password_hash('password', PASSWORD_DEFAULT), 1, 'user');
    }

    // Sélectionner un gagnant
    $winner = $model->selectRandomWinner();
    if ($winner) {
        echo "Le gagnant est : " . $winner['nom'] . " " . $winner['prenom'] . " (" . $winner['email'] . ")<br>";
    } else {
        echo "Échec : Aucun gagnant n'a été sélectionné.<br>";
    }

    // Supprimer de  la base de données
    foreach ($emails as $email) {
        $user = $model->findUserByEmail($email);
        $model->removeUsers($user['id_utilisateur']);
    }
    echo "Utilisateurs de test supprimés.<br>";
} catch (Exception $e) {
    echo "Erreur dans selectRandomWinner() : " . $e->getMessage() . "<br>";
}

echo "<br>";echo "<br>";

// Test de la méthode updateUserNationality()
try {
    echo "Test de la méthode updateUserNationality()<br>";

    // Créer un utilisateur pour le test
    $id_utilisateur = $model->createUser('UpdateNation', 'User', 'test.updatenation@example.com', 1, 'QR1234567', '2030-12-31', '1985-11-20', password_hash('password', PASSWORD_DEFAULT), 0, 'user');

    // Nouvelle nation
    $newNationId = $model->getNationIdByName('Égypte');

    // Mettre à jour la nationalité
    $model->updateUserNationality($id_utilisateur, $newNationId);

    // Vérifier la mise à jour
    $user = $model->findUserById($id_utilisateur);
    if ($user && $user['id_nation'] == $newNationId) {
        echo "Succès : La nationalité de l'utilisateur a été mise à jour.<br>";
    } else {
        echo "Échec : La nationalité de l'utilisateur n'a pas été mise à jour.<br>";
    }

    // Supprimer de la base de données
    $model->removeUsers($id_utilisateur);
    echo "Utilisateur de test supprimé.<br>";
} catch (Exception $e) {
    echo "Erreur dans updateUserNationality() : " . $e->getMessage() . "<br>";
}

echo "<br>";echo "<br>";

// Test de la méthode isNationalityBanned()
try {
    echo "Test de la méthode isNationalityBanned()<br>";

    // Supposons que l'ID de la nation à tester est 3
    $id_nation = 3;

    // Vérifier si la nationalité est bannie
    if ($model->isNationalityBanned($id_nation)) {
        echo "La nationalité avec l'ID $id_nation est bannie.<br>";
    } else {
        echo "La nationalité avec l'ID $id_nation n'est pas bannie.<br>";
    }
} catch (Exception $e) {
    echo "Erreur dans isNationalityBanned() : " . $e->getMessage() . "<br>";
}

