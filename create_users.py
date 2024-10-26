import random
import string
from datetime import datetime, timedelta

# Listes prédéfinies de prénoms et noms pour générer des données factices
first_names = [
    'Jean', 'Marie', 'Pierre', 'Sophie', 'Luc', 'Julie', 'Paul', 'Laura', 'Marc', 'Emma',
    'Thomas', 'Camille', 'Antoine', 'Inès', 'Julien', 'Chloé', 'Nicolas', 'Léa', 'Mathieu', 'Manon'
]

last_names = [
    'Martin', 'Bernard', 'Thomas', 'Petit', 'Robert', 'Richard', 'Durand', 'Dubois', 'Moreau', 'Laurent',
    'Simon', 'Michel', 'Lefebvre', 'Leroy', 'Roux', 'David', 'Fontaine', 'Girard', 'Bonnet', 'Garnier'
]

def generate_random_email(first_name, last_name, existing_emails):
    """
    Génère un email unique basé sur le prénom, le nom et un numéro aléatoire.
    """
    while True:
        number = random.randint(1, 9999)
        email = f"{first_name.lower()}.{last_name.lower()}{number}@example.com"
        if email not in existing_emails:
            existing_emails.add(email)
            return email

def generate_random_string(min_length, max_length):
    """
    Génère une chaîne alphanumérique de longueur aléatoire entre min_length et max_length.
    """
    length = random.randint(min_length, max_length)
    return ''.join(random.choices(string.ascii_letters + string.digits, k=length))

def generate_random_date(start_year=1940, end_year=2005):
    """
    Génère une date de naissance aléatoire entre start_year et end_year.
    """
    start_date = datetime(start_year, 1, 1)
    end_date = datetime(end_year, 12, 31)
    delta = end_date - start_date
    random_days = random.randint(0, delta.days)
    random_date = start_date + timedelta(days=random_days)
    return random_date.strftime('%Y-%m-%d')

def generate_expiration_date():
    """
    Génère une date d'expiration de passeport aléatoire entre 1 et 10 ans dans le futur.
    """
    today = datetime.today()
    start_date = today + timedelta(days=365)         # 1 an à partir d'aujourd'hui
    end_date = today + timedelta(days=365*10)       # 10 ans à partir d'aujourd'hui
    delta = end_date - start_date
    random_days = random.randint(0, delta.days)
    random_date = start_date + timedelta(days=random_days)
    return random_date.strftime('%Y-%m-%d')

def main():
    existing_emails = set()
    insert_statements = []
    id_nation_min = 1
    id_nation_max = 195

    for _ in range(100):
        first_name = random.choice(first_names)
        last_name = random.choice(last_names)
        email = generate_random_email(first_name, last_name, existing_emails)
        nationalite = str(random.randint(id_nation_min, id_nation_max))
        numPass = generate_random_string(6, 14)  # Numéro de passeport avec 6 à 14 caractères
        dateExpPass = generate_expiration_date()
        dateNaissance = generate_random_date()
        password = generate_random_string(8, 14)  # Mot de passe avec 8 à 14 caractères
        loterie = 1
        role = 'user'

        # Échapper les apostrophes dans les chaînes pour éviter les erreurs SQL
        nom_escaped = last_name.replace("'", "''")
        prenom_escaped = first_name.replace("'", "''")
        email_escaped = email.replace("'", "''")
        nationalite_escaped = nationalite.replace("'", "''")
        numPass_escaped = numPass.replace("'", "''")
        password_escaped = password.replace("'", "''")
        role_escaped = role.replace("'", "''")

        insert = f"INSERT INTO utilisateurs (nom, prenom, email, id_nation, numPass, dateExpPass, dateNaissance, password, loterie, role) VALUES ('{nom_escaped}', '{prenom_escaped}', '{email_escaped}', '{nationalite_escaped}', '{numPass_escaped}', '{dateExpPass}', '{dateNaissance}', '{password_escaped}', {loterie}, '{role_escaped}');"
        insert_statements.append(insert)

    # Écrire les requêtes dans un fichier .sql
    with open('insert_users.sql', 'w', encoding='utf-8') as f:
        for stmt in insert_statements:
            f.write(stmt + '\n')

    print("100 requêtes INSERT INTO ont été écrites dans le fichier 'insert_users.sql'.")

if __name__ == "__main__":
    main()
