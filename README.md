# MAORIE_test_KANZA

##1°) Installation du projet
- Cloner le projet en local
- Se place à la racine du projet et lancer *php bin/console composer install*
- Créer votre base de donnée côté postgresql
- Préfixez votre fichier .env avec les bons paramètres.
- Créez votre schéma via la console : *php bin/console doctrine:schema:update --force*

##2°) Pour lancer l'application 
php -S localhost:8000 -t public

##3°) Pour installer un jeu de test (fixtures)
php bin/console doctrine:fixtures:load

## DOCUMENTATION API
Utilisez POSTMAN DE PREFERENCE POUR TESTER

## Pour se connecter et générer un token
URL: php -S localhost:8000/loggon \
METHODE: POST \
RETOUR: string \
Avec les paramètres  "email" et "mot de passe". Les utilisateurs sont créés grâce au jeu de test des fixtures. \
Exemple de compte pour tester, saisir le couple login et mot de passe : user_1 et password.  
CHAMPS:\
email : string : obligatoire : adresse email \
password: string : obligatoire : mot de passe \


## Api user
###Listing des utilisateurs
URL: http://127.0.0.1:8000/api/user/ \
METHODE: GET \
RETOUR: array json

###Détail d'un utilisateur
URL: http://127.0.0.1:8000/api/user/{idUser} \
METHODE: GET \
RETOUR: array json \
CHAMPS:\
**idUser**: string : obligatoire : Id de l'utilisateur \


###Création d'un utilisateur
URL: http://127.0.0.1:8000/api/user/ \
METHODE: POST \
PARAMETRES : \
RETOUR: array json \
CHAMPS:\
**civility**: integer : obligatoire : civilité \
**username**: string : obligatoire : pseudo \
**email**: string : obligatoire : adresse email \
**password**: string : obligatoire : mot de passe \
**is_active**: boolean : obligatoire : statut \
**roles**: string json : obligatoire : mot de passe \
**photo**: string : non obligatoire : photo \
**category_id**: string_json : non obligatoire : categorie de l'utilisateur

###Mise à jour d'un utilisateur
URL: http://127.0.0.1:8000/api/user/ \
METHODE: PUT \
PARAMETRES : \
RETOUR:  \
CHAMPS:\
**id**: string : obligatoire : Identifiant de l'utilisateur \
**email**: string : obligatoire : adresse email \
**password**: string : obligatoire : mot de passe \
**email**: string : obligatoire : adresse email \
**password**: string : obligatoire : mot de passe \
**email**: string : obligatoire : adresse email \
**password**: string : obligatoire : mot de passe \
**email**: string : obligatoire : adresse email \
**password**: string : obligatoire : mot de passe \
**email**: string : obligatoire : adresse email \
**password**: string : obligatoire : mot de passe \


## Badge CODACY
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/e16a35379da849328921c9bc1549d39b)](https://www.codacy.com/gh/CAMILLE-KANZA-TEAM/MAORIE_test_KANZA/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=CAMILLE-KANZA-TEAM/MAORIE_test_KANZA&amp;utm_campaign=Badge_Grade)