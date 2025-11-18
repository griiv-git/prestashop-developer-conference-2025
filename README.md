# PrestaShop Developer Conference 2025

Dépôt de démonstration pour la conférence PrestaShop Developer 2025, présentant l'utilisation de la bibliothèque [griiv/prestashop-module-contracts](https://github.com/griiv-dev/prestashop-module-contracts) pour le développement de modules PrestaShop modernes.

## Description

Ce projet contient des exemples pratiques illustrant comment développer des modules PrestaShop en suivant les bonnes pratiques modernes avec une architecture orientée services, l'injection de dépendances et une gestion automatisée des hooks.

## Exemples inclus

Le dépôt est organisé en deux exemples progressifs :

### Exemple 1 : Module gcategory (version simple)

Module de démonstration pour la modification des catégories PrestaShop.

**Chemin**: [`exemple1/gcategory/`](exemple1/gcategory/)

**Fonctionnalités démontrées**:
- Extension de `ModuleAbstract`
- Utilisation du trait `ModuleTrait`
- Enregistrement de hooks d'action pour le grid et les formulaires de catégories
- Hooks de modification de produits

**Hooks implémentés**:
- Modification du grid des catégories
- Modification des formulaires de catégories
- Gestion après création/mise à jour de catégories
- Modification des produits et de leurs propriétés

**Fichier principal**: [`exemple1/gcategory/gcategory.php`](exemple1/gcategory/gcategory.php)

### Exemple 2 : Modules gcustomer et gcategory (version complète)

Version plus élaborée avec deux modules complets incluant des services, des contrôleurs, des formulaires et des handlers de commandes.

**Chemin**: [`exemple2/`](exemple2/)

#### Module gcustomer

**Fonctionnalités démontrées**:
- Architecture complète avec services Symfony
- Command Handlers (CQRS pattern)
- Formulaires de configuration
- Controllers administrateur
- Hooks d'affichage front-office
- Gestion des upgrades de module

**Structure**:
```
exemple2/gcustomer/
├── config/
│   ├── admin/services.yml
│   ├── front/services.yml
│   └── services.yml
├── src/
│   ├── Adapter/Customer/CommandHandler/
│   │   ├── AddCustomerHandler.php
│   │   └── EditCustomerHandler.php
│   ├── Controller/Admin/
│   │   └── ConfigurationController.php
│   ├── Enum/
│   │   └── AddressType.php
│   ├── Form/Configuration/
│   │   ├── ConfigurationForm.php
│   │   ├── ConfigurationFormDataPersister.php
│   │   └── ConfigurationFormDataProvider.php
│   ├── Hook/Display/
│   │   └── DisplayTop.php
│   └── Service/
│       └── MyService.php
└── upgrade/
    └── upgrade-1.0.x.php
```

**Fichier principal**: [`exemple2/gcustomer/gcustomer.php`](exemple2/gcustomer/gcustomer.php)

#### Module gcategory

Version avancée du module de catégories avec vues Twig personnalisées.

**Fonctionnalités supplémentaires**:
- Templates Twig pour le back-office
- Services configurés par environnement (admin/front)
- Scripts de mise à jour

**Structure**:
```
exemple2/gcategory/
├── config/
│   ├── admin/services.yml
│   ├── front/services.yml
│   └── services.yml
├── src/
│   ├── Hook/Display/
│   │   └── DisplayTop.php
│   └── Service/
│       └── MyService.php
├── views/PrestaShop/Admin/Sell/Catalog/Categories/Blocks/
│   └── form.html.twig
└── upgrade/
    └── upgrade-1.0.1.php
```

**Fichier principal**: [`exemple2/gcategory/gcategory.php`](exemple2/gcategory/gcategory.php)

## Concepts clés démontrés

### 1. Architecture modulaire
- Utilisation de `ModuleAbstract` comme classe de base
- Séparation des responsabilités (hooks, services, contrôleurs)
- Organisation PSR-4

### 2. Gestion automatique des hooks
- Convention de nommage automatique
- Classes de hooks typées (Display, Action, Filter)
- Résolution dynamique basée sur les namespaces

### 3. Intégration Symfony
- Conteneur de services avec injection de dépendances
- Configuration YAML des services
- Formulaires Symfony
- Templates Twig

### 4. Patterns modernes
- Command/Handler pattern (CQRS)
- Data Provider/Persister pattern
- Énumérations typées
- Séparation admin/front

## Prérequis

- PHP >= 7.2
- PrestaShop 1.7.5+
- Composer
- Compréhension de base de Symfony (conteneur de services, formulaires)

## Installation

### Cloner le dépôt

```bash
git clone https://github.com/griiv-dev/prestashop-developer-conference-2025.git
cd prestashop-developer-conference-2025
```

### Installer les dépendances

Pour l'exemple 1 :
```bash
cd exemple1/gcategory
composer install
```

Pour l'exemple 2 :
```bash
cd exemple2/gcustomer
composer install

cd ../gcategory
composer install
```

### Déployer dans PrestaShop

Copiez les modules dans le répertoire `modules/` de votre installation PrestaShop :

```bash
# Depuis la racine du dépôt
cp -r exemple1/gcategory /path/to/prestashop/modules/
# ou
cp -r exemple2/gcustomer /path/to/prestashop/modules/
cp -r exemple2/gcategory /path/to/prestashop/modules/
```

### Installer dans le back-office

1. Connectez-vous au back-office PrestaShop
2. Allez dans **Modules > Module Manager**
3. Recherchez les modules "Griiv"
4. Cliquez sur **Installer** puis **Configurer**

## Utilisation

### Développer un nouveau hook

1. Déclarez le hook dans la méthode `getHooks()` :
```php
public function getHooks(): array
{
    return ['displayTop', 'actionProductUpdate'];
}
```

2. Créez la classe correspondante :
```php
namespace Griiv\Customer\Hook\Display;

use Griiv\Prestashop\Module\Contracts\Hook\Hook;
use Griiv\Prestashop\Module\Contracts\Hook\Contracts\DisplayHookInterface;

class DisplayTop extends Hook implements DisplayHookInterface
{
    public function display($params): string
    {
        // Votre logique ici
        return $this->getModule()->display(__FILE__, 'views/templates/hook/top.tpl');
    }
}
```

### Créer un service

1. Ajoutez votre service dans `config/services.yml` :
```yaml
services:
  griiv.customer.service.my_service:
    class: Griiv\Customer\Service\MyService
    public: true
```

2. Utilisez-le dans vos hooks ou contrôleurs :
```php
$service = $this->getService('griiv.customer.service.my_service');
```

### Ajouter un formulaire de configuration

Consultez l'exemple complet dans [`exemple2/gcustomer/src/Form/Configuration/`](exemple2/gcustomer/src/Form/Configuration/) pour voir comment créer :
- Un FormType
- Un DataProvider
- Un DataPersister
- Le contrôleur associé

## Structure recommandée

```
monmodule/
├── composer.json
├── monmodule.php                    # Classe principale du module
├── config/
│   ├── services.yml                 # Services communs
│   ├── admin/
│   │   └── services.yml             # Services back-office
│   └── front/
│       └── services.yml             # Services front-office
├── src/
│   ├── Hook/
│   │   ├── Display/                 # Hooks d'affichage
│   │   ├── Action/                  # Hooks d'action
│   │   └── Filter/                  # Hooks de filtrage
│   ├── Controller/                  # Contrôleurs
│   ├── Service/                     # Services métier
│   ├── Form/                        # Formulaires Symfony
│   ├── Adapter/                     # Adapters (Command/Query handlers)
│   └── Enum/                        # Énumérations
├── upgrade/                         # Scripts de mise à jour
│   └── upgrade-x.x.x.php
└── views/
    ├── templates/
    │   └── hook/                    # Templates Smarty
    └── PrestaShop/                  # Templates Twig (back-office)
```

## Bibliothèque prestashop-module-contracts

Ce dépôt s'appuie sur la bibliothèque [`griiv/prestashop-module-contracts`](https://github.com/griiv-dev/prestashop-module-contracts) qui fournit :

- Une classe abstraite `ModuleAbstract` pour structurer vos modules
- Des interfaces typées pour les hooks (`DisplayHookInterface`, `ActionHookInterface`, etc.)
- Un système de résolution automatique des hooks
- L'accès au kernel Symfony et aux services
- Des traits utilitaires pour les traductions et tokens

Pour plus de détails, consultez la [documentation complète](https://github.com/griiv-dev/prestashop-module-contracts).

## Avantages de cette approche

- **Code maintenable** : Structure claire et organisation logique
- **Testable** : Injection de dépendances facilitant les tests unitaires
- **Extensible** : Facile d'ajouter de nouveaux hooks et services
- **Standards modernes** : Respect des conventions PHP et Symfony
- **Type-safe** : Interfaces garantissant les signatures de méthodes
- **Productivité** : Moins de code boilerplate grâce aux conventions

## Ressources

- [Documentation PrestaShop](https://devdocs.prestashop-project.org/)
- [Symfony Documentation](https://symfony.com/doc/current/index.html)
- [PSR-4 Autoloading](https://www.php-fig.org/psr/psr-4/)
- [SOLID Principles](https://en.wikipedia.org/wiki/SOLID)

## Auteur

**Arnaud Scoté** - Griiv
- Email: arnaud@griiv.fr
- GitHub: [@griiv-dev](https://github.com/griiv-dev)

## Licence

Ce projet est sous licence MIT - voir le fichier [LICENSE](LICENSE) pour plus de détails.

## Contributions

Les contributions sont les bienvenues ! N'hésitez pas à :
- Ouvrir une issue pour signaler un bug ou suggérer une amélioration
- Soumettre une pull request
- Partager vos retours d'expérience

## Support

Pour toute question concernant :
- **Ces exemples** : Ouvrez une issue sur ce dépôt
- **La bibliothèque contracts** : Consultez le [dépôt prestashop-module-contracts](https://github.com/griiv-dev/prestashop-module-contracts)
- **PrestaShop** : Consultez les [forums officiels](https://www.prestashop.com/forums/)
