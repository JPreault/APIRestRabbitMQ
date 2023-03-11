# APIRestRabbitMQ

## Getting Started

 - S'assurer que l'on utilise une version de php ou la ligne 
```extension=sockets```
est décommenté dans le fichier *php.ini*
 - Télécharger le projet dans un dossier accessible par votre logiciel de web serveur local (local important car il vous faut lancer le worker en mode client).
 - Modifier la function *getConnexion()* du fichier *bddConnection.php* à la racine du projet afin de vous connecter a votre propre base de donnée locale.
 - Créer votre base de donnée.
 - Importez la table **orders** grâce au fichier sql présent à la racine du projet
