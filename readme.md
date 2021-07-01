# But du projet

Proposer une api web simple afin de pouvoir faire des tests un peu plus poussés via Angular ! :-)

## But secondaire

Découvrir API Platform qui permet de monter des apis rapidement, simplement et efficacement en respectant les standards et s'appuyant sur les concepts et technologies proposés par Symfony.



# Installation

## Montage infrastructure

Il suffit de se placer à la racine du projet et de monter l'infrastructure docker via docker-compose...
Si vous désirez parametrer les mots de passe et les ports d'écoute, vous pouvez créer un .env à la racine du projet

```bash
$ cd apiserver
$ docker-compose up -d
```

## Installation des dépendances

Avant de fonctionner, le projet nécessite l'installation de librairies tiers, à commencer par Symfony.
Composer va faire cela pour nous !

```bash
$ docker exec apiserver-php composer install
```


## Mise en place de la base de données

Si vous venez de construire l'infrastructure pour la première fois, le service de données dispose de son propre volume, mais la base de données est vide (pas de structure, pas de données).

Nous devons donc exécuter l'intégralité des migrations pour construire le schéma de la base de données.
```bash
$ docker exec apiserver-php php bin/console doctrine:migration:migrate -n
```

Vous pouvez ensuite créer un jeu de données de test via les fixtures (cela créera des livres, des tags, des auteurs, ...).
(Attention, cette commande est lancée en mode non-interactif, et affecte de facon irréversible le contenu de la base de données !)
```bash
$ docker exec apiserver-php php bin/console doctrine:fixtures:load - n
```

## Configuration spécifique

Si vous exposez votre api sur un serveur et que vous faites tourner les clients qui consomment votre api sur d'autres postes, vous pouvez rencontrer des problemes de CORS.
Conformément à la documentation Symfony (https://symfony.com/doc/current/the-fast-track/en/26-api.html#configuring-cors), vous devriez adapter le paramètre CORS_ALLOW_ORIGIN via les fichiers d'environnement de Symfony.
Personnelement, pour mes développements, j'ai simplement créé un fichier app/.env.local contenant:
```
CORS_ALLOW_ORIGIN='*'
```

## Enjoy it!

Vous pouvez utiliser dès à présent l'api et expérimenter à votre convenance... :-) 
Visitez:
- http://localhost:8080/api : pour accéder à la documentation Swagger de l'api
- http://localhost:8089 : pour accéder à PhpMyAdmin et voir la base de données et sa structure.
- Et surtout, utilisez postman, insomnia, ou tout autre client Rest pour tester l'api !


# Historique

## Mise en place de l'infrastructure docker (service web frontal, service applicatif (PHP), service de données, service Phpmyadmin,...)

Pas de commentaires particuliers, j'ai adapté une infrastructure Docker existante aux besoins de ce serveur d'api...


## Mise en place du framework Symfony v5.3, version stable actuelle.

La encore, pas de nouveautés, installation de Symfony via composer ou l'outils symfony décrit dans la documentation officielle.


## Création de quelques entités et de leur fixtures associées (livres).

Création d'une entité Book représentant un livre via la commande make:entity de Symfony, puis génération du fichier correspondant.
Création d'un fichier fixtures pour générer des centaines de livres dans notre base de données à l'aide du paquet Faker.


## Intégration de Api Platform au projet Symfony existant

Installation du paquet api (Api Platform).
Annotation de l'entité Book pour créer une nouvelle ressource (au sens Api Platform).
Ce qui a pour conséquence:
- d'exposer automatiquement des webs services standardisés proposant une interface CRUD (creation, lecture, mise à jour, et suppression) pour manipuler nos livres.
- de mettre à jour la documentation de l'api (outil Swagger) que nous sommes en train de construire.


## Elargissement du jeu de donnée et complexification du schéma de la base de données

On ajoute un champ auteur et des tags aux livres.
