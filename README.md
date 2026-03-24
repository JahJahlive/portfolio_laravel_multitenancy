🚚 Logistics Master — Transport Sud-Ouest
Logistics Master est une plateforme SaaS de gestion logistique conçue pour les entreprises de transport. Elle permet une isolation totale des données grâce à une architecture Multi-Tenant, offrant à chaque client son propre espace de travail via un sous-domaine dédié.

🏗️ Architecture & Stack Technique
Le projet utilise une approche Single Database Multi-Tenancy, garantissant une maintenance simplifiée et des performances optimales.

Backend : Laravel 11.x (PHP 8.3)

Multi-Tenancy : Stancl/Tenancy (Identification par domaine)

Frontend : Blade, Tailwind CSS et intégration du template Tabler

Authentification : Laravel Breeze (Multi-tenant Ready)

Environnement : WSL2 (Ubuntu) sur Windows 11

🚀 Fonctionnalités (Semaine 1 : Ready)
[x] Gestion de sous-domaines dynamiques : Isolation par URL (ex: alpha.logistics.test).

[x] Infrastructure Multi-Tenant : Middleware de détection automatique du client.

[x] Isolation des Modèles : Global Scoping via tenant_id sur les tables partagées.

[x] Routes Étanches : Séparation entre le domaine central (web.php) et l'espace client (tenant.php).

🛠️ Installation & Configuration (WSL)
1. Clonage et dépendances
Bash
git clone https://github.com/votre-username/logistics-master.git
cd logistics-master
composer install
2. Environnement
Bash
cp .env.example .env
php artisan key:generate
Note : Pensez à configurer vos accès MySQL dans le .env.

3. Migrations
Bash
php artisan migrate
4. Configuration Hosts (Windows)
Pour que les sous-domaines fonctionnent en local sous WSL, ajoutez l'IP de votre instance à votre fichier hosts Windows :

Plaintext
# IP obtenue via 'hostname -I' dans WSL
172.xx.xx.xx   logistics.test
172.xx.xx.xx   alpha.logistics.test
172.xx.xx.xx   beta.logistics.test
🧪 Création d'un Tenant de test
Pour tester l'isolation, créez un client via Tinker :

PHP
// Lancer Tinker
php artisan tinker

// Exécuter les commandes
$tenant = App\Models\Tenant::create(['id' => 'alpha']);
$tenant->domains()->create(['domain' => 'alpha.logistics.test']);
Accès : http://alpha.logistics.test:8000

📅 Roadmap de développement
[x] Semaine 1 : Setup, Multi-Tenancy et isolation DB.

[ ] Semaine 2 : Intégration complète de l'UI Tabler et Module Véhicules (Ford Transit, Toyota RAV4, etc.).

[ ] Semaine 3 : Gestion des expéditions et suivi en temps réel.

[ ] Semaine 4 : Facturation, reporting et déploiement.

Développé avec passion par Yannick Kobe Mbaikwo Senior Full Stack Developer 