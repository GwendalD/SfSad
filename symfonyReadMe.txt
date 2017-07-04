ACTIVER MODE REWRITE APACHE2

Création du virtual host symfony exemple :

<VirtualHost *:80>
    ServerName symfony.loc
    ServerAlias www.symfony.loc

    DocumentRoot "/home/gwendal/localweb/symfony3/Symfony/web"
    <Directory "/home/gwendal/localweb/symfony3/Symfony/web">
        AllowOverride None
        Order Allow,Deny
        Allow from All
        Require all granted

        <IfModule mod_rewrite.c>
            Options -MultiViews
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^(.*)$ app.php [QSA,L]
        </IfModule>
    </Directory>

    # uncomment the following lines if you install assets as symlinks
    # or run into problems when compiling LESS/Sass/CoffeeScript assets
    # <Directory /var/www/project>
    #     Options FollowSymlinks
    # </Directory>

    # optionally disable the RewriteEngine for the asset directories
    # which will allow apache to simply reply with a 404 when files are
    # not found instead of passing the request into the full symfony stack
    <Directory "/home/gwendal/localweb/symfony3/Symfony/web/bundles">
        <IfModule mod_rewrite.c>
            RewriteEngine On
        </IfModule>
    </Directory>
    ErrorLog /var/log/apache2/symfony_error.log
    CustomLog /var/log/apache2/symfony_access.log combined
</VirtualHost>


console symfony : 

php bin/console generate:bundle -> génère un bundle, ajouter un slash pour etre dans un namespace voulu : SF/UserBundle

php bin/console doctrine:database:create -> créer la bdd

php bin/console cache:clear -> vide le cache en dev

php bin/console cache:clear --env=prod -> vide le cache en prod

php bin/console doctrine:schema:update --dump-sql -> afficher les requetes sql pour créer les tables par rapports aux entities

php bin/console doctrine:schema:update --force -> applique les requetes

php bin/console doctrine:generate:entity -> génère une entité

php bin/console doctrine:generate:entities SFPlatformBundle:Advert -> mets à jour l'entitié

php bin/console generate:doctrine:crud -> genère un crud basé sur une entité avec les forms etc ... certainement à modifier une fois créer

php bin/console doctrine:fixtures:load -> ajoute des données en bdd mais purge la bdd

php bin/console doctrine:fixtures:load --append -> ajoute des données en bdd sans purger la bdd

php bin/console doctrine:query:dql "SELECT a FROM OCPlatformBundle:Advert a" -> permet de tester rapidement des requetes DQL

php bin/console doctrine:generate:form SFPlatformBundle:Advert -> prermet de créer le nécéssaires pour le formulaire associé à l'objet souhaité et réutilisable partout

php bin/console debug:container -> permet d'avoir la liste des services

php bin/console debug:router -> affiche les routes (url) de l'appli

php bin/console debug:container --tag=twig.extension -> Pour connaître tous les services implémentant un certain tag ; ici : twig.extension

php bin/console generate:command -> pour créer une commande exemple : remplir la bdd

php bin/console doctrine:query:sql "SELECT * FROM category"

