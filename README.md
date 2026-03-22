# Frontend HelloAsso pour WordPress

Ce projet est une interface React moderne, construite avec Vite et TypeScript, permettant d'afficher une grille de formulaires HelloAsso. Il est spécifiquement conçu pour être packagé et utilisé comme une extension WordPress.

## Objectifs du projet

- Récupérer les formulaires HelloAsso via une API dédiée.
- Afficher les formulaires sous forme de cartes dans une grille responsive.
- Permettre une intégration facile dans WordPress.
- Utiliser un proxy pour l'affichage des images (bannières) afin d'éviter les problèmes de CORS.

## Dépôts associés

- **Backend** : [mlnck-helloasso](https://github.com/Bigyohann/mlnck-helloasso) - L'API en Go qui gère la communication avec HelloAsso et le proxy d'images.

## Technologies utilisées

- **React 19** : Bibliothèque pour l'interface utilisateur.
- **TypeScript** : Pour un typage statique et une meilleure maintenabilité.
- **Vite** : Outil de build ultra-rapide.
- **CSS Modules** : Pour une gestion isolée des styles.

## Configuration

Le projet utilise des variables d'environnement pour la configuration. Créez un fichier `.env` (ou utilisez `.env.development` / `.env.production`) avec :

```env
VITE_API_URL=https://votre-api-helloasso.com
```

## Développement

Pour lancer le serveur de développement :

```bash
pnpm install
pnpm dev
```

## Déploiement WordPress

Le projet inclut un script spécifique pour générer l'extension WordPress :

```bash
pnpm run build:wp
```

Cette commande effectue les étapes suivantes :

1. Compile le projet React.
2. Copie les fichiers générés dans le dossier `wp-plugin/mlnck-helloasso-plugin/dist`.
3. Compresse le dossier de l'extension dans un fichier `.zip` prêt à être installé sur WordPress.

L'extension WordPress se trouve ensuite dans le dossier `wp-plugin/`.
