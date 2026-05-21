Application web de reservation de billet et de gestion des agences.

##  Objectif
Développer une application web permettant la visualisation des voyages et la réservation de billets en ligneet ainsi qu"en presentiel.  
Le système offre une interface moderne et intuitive pour les clients, les caissiers et les administrateurs, avec une gestion complète des agences, bus, chauffeurs, trajets et paiements.

---

##  Entités principales
- **Client** : inscription, connexion, réservation, profil.
- **Caissier** : gestion des paiements, impression des billets, suivi des passagers.
- **Administrateur** : gestion des agences, bus, chauffeurs, trajets, utilisateurs.
- **Voyage** : source, destination, horaire, prix, distance.
- **Billet** : réservation, paiement, génération PDF avec QR code.
- **Agence** : locale ou principale, avec gestion des trajets et chauffeurs.

---

##  Fonctionnalités
###  Visiteur
- Page d’accueil avec présentation des trajets disponibles.
- Formulaire de recherche rapide (source, destination, date).
- Visualisation des voyages disponibles.

###  Client
- Inscription et connexion sécurisée.
- Réservation de billets avec choix du siège.
- Paiement en ligne ou via caissier.
- Téléchargement du billet en PDF (FPDF).
- Gestion du profil et historique des réservations.

###  Caissier
- Tableau de bord pour gérer les paiements.
- Impression des billets avec QR code.
- Liste des passagers par voyage.
- Recherche et suivi des réservations.

###  Administrateur
- Gestion des agences, bus, chauffeurs et trajets.
- Gestion des utilisateurs (activation/désactivation).
- Validation et suivi des réservations.
- Tableau de bord global (statistiques, paiements, voyages).

---

##  Technologies utilisées
- **Back-End** : PHP (Programmation Orientée Objet, MVC)
- **Base de données** : MySQL
- **Front-End** : Bootstrap 5 / Tailwind CSS, JavaScript, Ajax
- **PDF** : FPDF pour la génération des billets
- **Sécurité** : Sessions PHP, requêtes préparées (PDO), `.gitignore` pour protéger les fichiers sensibles

---

##  Sécurité
- Authentification sécurisée avec gestion des sessions.
- Protection contre les injections SQL via requêtes préparées.
- Fichiers sensibles (`config.php`) exclus du dépôt grâce à `.gitignore`.
- Gestion des rôles (admin, caissier, client) avec accès restreint.

---

##  Installation
1. Cloner le dépôt :
   ```bash
   git clone https://github.com/franckouam17/gestion_reservation_de_billet.
