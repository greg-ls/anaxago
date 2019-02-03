Anaxago symfony-starter-kit
===================

# Description

Ce projet est un kit de démarage avec :
- Symfony 3.4 minimum
- php 7.1 minimum

La base de données contient deux tables :
- user => pour la gestion et la connexion des utilisateurs 
- project => pour la liste des projets

Les données préchargés sont
- pour les users 

| email     | password    | Role |
| ----------|-------------|--------|
| john@local.com  | john   | ROLE_USER    |
| admin@local.com | admin | ROLE_ADMIN   | 

 - une liste de 3 projets
 
La connexion et l'enregistrement des utilisateurs sont déjà configurés et opérationnels


# Installation
- ```composer install```
- ```composer init-db ```

    - Script personnalisé permet de créer la base de données, de lancer la création du schéma et de précharger les données
    - Ce script peut être réutilisé pour ré-initialiser la base de données à son état initial à tout moment

# Mise à jour

Important : ne pas oublier de faire un 
- ```composer init-db ```
car des modifications en base de données ont été directement intégrées à l'initialisation du kit

Les webservices suivants ont été rajoutés : 

- [GET] /api/interest => retourne la liste des marques d'interêt d'un utilisateur
- [POST] /api/projects/interest => crée une marque d'interêt pour un utilisateur. 
Il faut passer 2 paramètres idProject et amount.
ex : idProject=1&amount=500 avec un Content-Type : application/x-www-form-urlencoded

Les 2 webservices nécessitent d'être authentifiés pour être utilisés.

- [GET] /api/projects => retourne la liste des projets en cours.
1 champs founded indique si le projet est financé ou pas.


# Remarques 

- Un problème non résolu m'a empêché d'utiliser la même route pour les 2 webservices interest.
Normalement le fait de spécifier une méthode différente pour les deux aurait du fonctionner, mais j'ai du changer l'url de celle en post car j'avais une erreur url inconnue.

- Je n'ai pas pu finir l'option bonus.
J'avais créé un listener pour calculer si la somme des montants atteignaient le seuil pour savoir si un projet est financé ou pas, mais un problème d'injection des services m'a empêché de le finir à temps.
J'ai ajouté tout de même le listener dans le dernier commit
