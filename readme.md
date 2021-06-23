# But du projet

Proposer une api web simple afin de pouvoir faire des tests un peu plus poussés via Angular ! :-)

## But secondaire

Découvrir API Platform qui permet de monter des apis rapidement, simplement et efficacement en respectant les standards et s'appuyant sur les concepts et technologies proposés par Symfony.



# Installation

## Montage infrastructure

Il suffit de se placer à la racine du projet et de monter l'infrastructure docker via docker-compose...
Si vous désirez parametrer les mots de passe et port d'écoute, vous pouvez créer un .env à la racine du projet

```bash
$ cd apiserver
$ docker-compose up -d
```

*Soyez patient... Docker doit télécharger les images qu'il ne connait pas, et le premier démarrage du serveur Mysql peut s'éterniser...*

## Mise en place de la base de données

Si vous venez de construire l'infrastructure pour la première fois, le service de données dispose de son propre volume, mais la base de données est vide (pas de structure, pas de données).

Nous devons donc exécuter l'intégralité des migrations pour construire le schéma de la base de données.
```bash
$ docker exec apiserver-php php bin/console doctrine:migration:migrate -n
```

Vous pouvez ensuite créer un jeu de données de test via les fixtures...
```bash
$ docker exec apiserver-php php bin/console doctrine:fixtures:load
```

## Enjoy it!

Vous pouvez utiliser dès à présent l'api et expérimenter à votre convenance... :-) 



# Historique

- Mise en place de l'infrastructure docker (service web frontal, service applicatif (PHP), service de données, service Phpmyadmin,...)
- Mise en place du framework Symfony v5.3, version stable actuelle.
- Création de quelques entités.
