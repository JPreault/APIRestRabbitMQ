# APIRestRabbitMQ

## Getting Started

### Installation du projet

 - S'assurer que l'on utilise une version de php ou la ligne 
```extension=sockets```
est décommenté dans le fichier *php.ini*
 - Télécharger le projet dans un dossier accessible par votre logiciel de web serveur local (local important car il vous faut lancer le worker en mode client).
 - Modifier la function *getConnexion()* du fichier *bddConnection.php* à la racine du projet afin de vous connecter a votre propre base de donnée locale.
 - Créer votre base de donnée.
 - Importez la table **orders** grâce au fichier sql présent à la racine du projet

### Commandes et requêtes :

#### [POST] -> localhost/APIRestRabbitMQ/orderAPI/createOrder

*Cette requête créer la commande en base de donnée avec le flag : "Commande en cours de traitement"*

Cette requête POST doit fournir les paramètres suivants :
 - object : un string correspondant au nom de l'objet que l'on a commandé
 - address : un string correspondant a l'adresse de livraison de la commande
Cette requête POST renvoie un string dans laquelle on retrouve notre ID de commande



#### localhost/APIRestRabbitMQ/watcherAPI/getOrderInfo?uid=order640cc45ceed97

*Cette requête récupère les infos de la commande que l'on souhaite*

Cette requête GET doit fournir le paramètre suivant :
 - uid : un string correspondant à l'ID de la commande dont on souhaite recevoir les infos
Cette requête GET renvoie un objet JSON avec les infos de la commande demandée



#### localhost/APIRestRabbitMQ/watcherAPI/listOrder

*Cette requête récupère les infos de toute les commandes*

Cette requête GET renvoie un objet JSON avec les infos de toutes les commandes


