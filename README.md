# Garage automobile Vincent PARROT web app

Le projet Garage automobile Vincent Parrot c'est une application web réalisé pour une évaluation en cours de formation.

## Fonctionnalités

Le chef d'entreprise Vincent Parrot détient un compte administrateur qui lui permet de gérer les comptes utilisateurs pour les employés (creation, modification, visualisation, effacement), des gérer les modifications de la section services de réparation au niveau de la page d'accueil (creation, modification, visualisation, effacement), de gérer les modification au niveau de l'horaire d'ouverture/fermeture du garage present dans chaque page du site dans le pied de la page.

Le site web affiche de manière claire et concise les différents services de réparation automobile proposés par le garage sur la page d'accueil.

Le site web présent les véhicules d'occasion disponibles à la vente, avec des photos, des descriptions détaillées et des informations techniques.

Un système de filtres facilite la recherche de véhicules en ajustant les résultats en fonction d'une fourchette de prix, d'un nombre de kilomètres parcourus ou d'une année de mise en circulation.

Seuls les employés ont la possibilité de: ajouter, modifier, visualiser et effacer les voitures d'occasion propose à la vente sur le site internet. 

Les employés ont la possibilité de: ajouter, modifier, visualiser, effacer les témoignages ansi que de modérés les témoignages des visiteurs pour éviter tout contenu inapproprié ou offensant avant la publication sur la page d'accueil des ces témoignage.

L'connexion a l'espace dédié a l'administration se fait via une adresse e-mail et un mot de passe a partir du meme formulaire de connexion pour les deux type d'utilisateurs.

Les visiteurs du site internet ont la possibilité de contacter le garage à tout moment, par téléphone ou en remplissant un formulaire de contact en ligne.

Les informations de contact, formulaire compris, sont également visibles en bas de chaque annonce d'un véhicule d'occasion avec le sujet du formulaire automatiquement ajusté en fonction du titre de l'annonce du véhicule.

## Configuration de l'environnement de travail

- ordinateur: [Apple Mac Mini - Apple M2 Pro](https://www.apple.com/newsroom/2023/01/apple-introduces-new-mac-mini-with-m2-and-m2-pro-more-powerful-capable-and-versatile-than-ever/)

- IDE: [Visual Studio Code 1.80.1](https://code.visualstudio.com/)

- IDE: [PhpStorm 2023.1.4](https://www.jetbrains.com/phpstorm/download)

- serveur Web local: [XAMPP 8.2.4-0](https://www.apachefriends.org/download.html)

- langage de scripts généraliste: [PHP 8.2.7](https://www.php.net/downloads)

- gestion des dépendances en PHP: [Composer version 2.5.8](https://getcomposer.org/download/)

- moteur d'exécution JavaScript: [Node.js 18.16.1](https://nodejs.org/en/download)

- npx package runner: [npx 9.8.0](https://docs.npmjs.com/cli/v9/commands/npx)

- gestionnaire de packages: [yarn 1.22.19](https://classic.yarnpkg.com/lang/en/docs/install/)

- navigateur Web: [Google Chrome 115.0.5790.102](https://www.google.com/intl/fr/chrome/)

- système de contrôle de version: [Git version 2.41.0](https://git-scm.com/)

## Installation

Vous pouvez cloner ce dépôt pour créer une copie locale sur votre ordinateur:

    git clone git@github.com:danian3wa/VParrotwebapp.git

Après la configuration de l'environnement du travail vous pouvez passer à l'installation des composants nécessaire. Vous devez ouvrir le projet cloné dans votre IDE. Dans le terminal de votre IDE vous devez vous rendre dans le dossier du projet nouvellement crée après le clonage si ce n'est pas deja le cas:

```bash
cd VParrotwebapp
```

Avec cette commande, dans le terminal vous installez les dépendances du projet présentes dans [composer.json](composer.json):

```bash
composer install
```

Si composer n'est pas installé sur votre environnement de travail vous trouvere a cette adresse des information vous permetant l'instalation:

* [https://getcomposer.org/download/](https://getcomposer.org/download/)

Avec cette commande, dans le terminal vous installez les dépendances du projet présentes dans [yarn.lock](yarn.lock):

```bash
yarn
```

Si yarn n'est pas installé sur votre environnement de travail vous trouvere a cette adresse des information vous permetant l'instalation:

* [https://classic.yarnpkg.com/lang/en/docs/install/](https://classic.yarnpkg.com/lang/en/docs/install/)

Si node.js n'est pas installé sur votre environnement de travail vous trouvere a cette adresse des information vous permetant l'instalation:

* [https://nodejs.org/en/download](https://nodejs.org/en/download)

Dans le fichie [.env](.env) on doit définir les informations concernant l'access a la base des données.'mysql' -> pour le type de base de données, 'root' -> pour l'utilisateur, sans mot de passe en locale, '127.0.0.1:3306' -> l'adresse IP et le numero du port, 'bdparrot' -> le nom de la base de données, '10.4.28-MariaDB' -> version et type du serveur, 'utf8mb4' -> pour le type d'encodage des characters.

    DATABASE_URL="mysql://root:@127.0.0.1:3306/bdparrot?serverVersion=10.4.28-MariaDB&charset=utf8mb4"

Il faut démarrer les serveurs Apache Web Server et MySQL Database dans l'application XAMPP dans la section Manage Servers

Avec cette commande, dans le terminal de votre IDE, vous créez la base de données bdparrot

```bash
symfony console doctrine:database:create
```

Avec cette commande, dans le terminal vous créez la migration des entites :

```bash
symfony console make:migration
```

Avec cette commande, dans le terminal, vous effectuez la migration vers la base de données :

```bash
symfony console doctrine:migration:migrate
```

Avec cette commande, dans le terminal de votre IDE, vous installez des certificats pour pouvoir naviguer en https :

```bash
symfony server:ca:install
```

Vous pouvez ouvrir phpMyAdmin dans votre navigateur pour visualiser la nouvelle base de données.
[http://127.0.0.1/phpmyadmin/index.php?route=/](http://127.0.0.1/phpmyadmin/index.php?route=/)

Il faut inserer dans la base de données au niveau de la table employes un employe avec le roles = ["ROLE_ADMIN"] et un mot de passe haché pour Vincent Parrot.

Avec cette commande, dans le terminal de votre IDE, vous pouvez hacher un mot de passe:

```bash
symfony console security:hash-password
```

Symfony vous renvoie le mot de passe haché, vous devez le copier.

Dans phpMyAdmin dans la base de données dbparrot, dans la table des employés dans l'onglet SQL, vous devez insérer l'employé en remplaçant  \_mot_de_passe_haché\_   par le mot de passe que vous avez copié, vous pouvez remplacer admin@gmail.com par une adresse e-mail de votre choix, elle servira d'identifiant de connexion pour l'administrateur Parrot Vincent.

```bash
INSERT INTO `employes` (`id`, `nom`, `prenom`, `email`, `roles`, `password`) VALUES
(1, 'Parrot', 'Vincent', 'admin@gmail.com', '[\"ROLE_ADMIN\"]', '_mot_de_passe_haché_');
```

L'attribute $roles de l'entité [Employes](/src/Entity/Employes.php) est initialisé avec la valeur ["ROLE_EMPLOYE"], donc a chaque creation d'un Employes le role est prédéfini et il ne peut pas être changé dans l'espace de creation d'un nouveau employe par l'administrateur. Le changement peut être realise seulement dans la base de données via phpMyAdmin.

Au moment de la connexion selon le rôle, l'utilisateur est redirigé vers l'espace d'administration le concernant.

Concernant l'envoie des données provenant des formulaires de contact l'application utilise l'envoi d'e-mails. Ces données ne sont pas enregistrées dans la base de données.

Pour ce faire, vous devez disposer d'une adresse Gmail, avec la [Validation en deux étapes Activée](https://myaccount.google.com/signinoptions/two-step-verification) sur le compte et il faut ajouter une [clé de sécurité pour l'application](https://myaccount.google.com/two-step-verification/security-keys). 

Ensuite dans le fichier [.env](.env) au niveau du MAILER_DSN=gmail://USERNAME:PASSWORD@default vous devez remplacer l'USERNAME par votre nom d'utilisateur Gmail et le PASSWORD par votre clé de sécurité que vous avez crée.

Dans les fichiers [ContactController.php](/src/Controller/ContactController.php) ligne numero 30 et [OccasionsPageController.php](/src/Controller/OccasionsPageController.php) ligne 99 vous devez remplacer test@gmail.com avec votre adresse e-mail.


Avec cette commande, dans le terminal de votre IDE, vous démarrez le serveur de développement

```bash
npx encore dev-server --hot
```

Avec cette commande, dans un nouveau terminal de votre IDE, vous lancez le serveur interne de Symfony en arrière-plan.

```bash
symfony serve -d
```

Le serveur Symfony vous informe qu'il est en écoute à l'adresse https://127.0.0.1:8000
Vous pouvez ouvrir ce lien dans votre navigateur.

Vous avez désormais la possibilité de vous connecter à l'espace d'administration avec le compte crée pour Vincent PARROT et d'ajouter des identifiants pour les employés, l'horaire d'ouverture/fermeture du garage, les services de réparation automobile proposés par le garage.

En vous connectant avec un identifiant d'un employe vous pourrez ajouter des voitures d'occasion pour la vente, d'ajouter, modérer et approuver des témoignages.

Avec cette commande, dans le terminal de votre IDE, vous arrêtez le serveur intern de Symfony

```bash
symfony server:stop
```

Pour arrêter le serveur de développement, utilisez la commande Control+C pour MacOS ou CTRL+C pour Windows.

**Note:**

> Il s'agit d'une application web en mode développement et non pas d'une application web en mode production.