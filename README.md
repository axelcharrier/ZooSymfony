# Zoo Symfony
Cette application est un rendu d'évaluation en Symfony

## Mise en place

### 0) Installez symfony
https://symfony.com/doc/current/setup.html

### 1) Création de la base de données 
Sur votre serveur de BDD, créé simplement une base de donnéesvide et un user qui peut avoir accès à cette BDD

### 2) Clone du projet 
Lancez la commande
``` bash
git clone https://github.com/axelcharrier/ZooSymfony.git
```
### 3) Paramètrage du projet
Rendez vous dans le fichier .env.local.sample et suivez les instructions qui y sont données

### 4) Migrations 
Lancez la commande 
```bash
symfony console doctrine:migrations:migrate
```

### 5) Démarrez le serveur symfony 
```bash
symfony server:start
```
