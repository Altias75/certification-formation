# Kadence Child — certification-formation.fr

Child theme pour refondre certification-formation.fr en s'inspirant de tutosurexcel.com, avec la palette QualiManager.

---

## 📦 Contenu

```
kadence-child/
├── style.css                  # Variables + sections + responsive (~600 lignes)
├── functions.php              # Enqueue + JSON-LD ProfessionalService + FAQPage
├── HOMEPAGE_STRUCTURE.html    # Structure HTML à coller dans la homepage
├── README.md                  # Ce fichier
└── (à ajouter plus tard)
    ├── screenshot.png         # Capture du résultat pour wp-admin (1200×900)
    └── inc/seo-helpers.php    # SEO programmatique des autres pages (étape 2)
```

---

## 🚀 Installation (étape 1 : homepage)

### A. Uploader le child theme

1. Via FileZilla, **uploader le dossier complet** `kadence-child/` dans :
   ```
   /home/courhbmk/certification-formation.fr/wp-content/themes/
   ```
   Résultat : tu dois avoir côte-à-côte :
   - `/wp-content/themes/kadence/` (parent, ne touche pas)
   - `/wp-content/themes/kadence-child/` (nouveau)

2. Dans `wp-admin > Apparence > Thèmes`, **active** « Kadence Child — Certification Formation ».
   - Le parent Kadence reste installé (le child en dépend).
   - Tu peux désactiver les Starter Templates Kadence.

3. Vide les caches :
   - Plugin LiteSpeed Cache > Purger tout
   - Cache navigateur : `Ctrl+Shift+R`

### B. Refondre la homepage

1. `wp-admin > Pages > toutes les pages > Accueil > Modifier`
2. **Sauvegarde ton contenu actuel** dans un brouillon ou un export avant.
3. Dans l'éditeur :
   - **Option simple** : ajoute un bloc **Custom HTML** et colle tout le contenu de `HOMEPAGE_STRUCTURE.html`.
   - **Option propre (recommandée)** : recrée chaque section avec les blocs Kadence natifs (Row Layout, Advanced Heading, Button, Icon) et **ajoute les classes `cf-*` correspondantes** dans le champ "Additional CSS Class(es)" du panneau Avancé de chaque bloc.
4. **Publie**.

### C. Vérifier

Ouvre `https://certification-formation.fr/` en navigation privée (pour éviter les caches authentifiés) :

- [ ] Header en blanc, menu visible
- [ ] Hero avec H1 grand, sous-titre, deux CTA (vert + fantôme)
- [ ] Section preuves sociales (gris clair) avec 4 cards et chiffres XL verts
- [ ] Section "Vous reconnaissez-vous ?" (blanc) avec 4 cards à bordure verte
- [ ] Section offres (gris clair) avec card "Accompagnement complet" marquée "Le plus complet"
- [ ] Section bio (blanc) avec photo + badges
- [ ] Process (gris clair) avec 4 cercles verts numérotés
- [ ] FAQ (blanc) avec accordéon natif (chevron + → −)
- [ ] CTA final (vert plein) avec bouton blanc
- [ ] Footer sombre

### D. Mobile

Sur ton téléphone (ou DevTools → 375px) :
- Sidebar du dashboard masquée
- Toutes les grilles passent en 1 colonne
- Boutons en pleine largeur
- Bio empilée (photo en haut)
- FAQ → padding ajusté

---

## 🎨 Palette utilisée (variables CSS)

```css
--cf-primary:    #2ecc71   /* vert principal CTA */
--cf-primary-dk: #27ae60   /* hover */
--cf-primary-lt: #e8f8ef   /* accents légers */
--cf-dark:       #1a1a2e   /* titres */
--cf-text:       #1a1a2e   /* body */
--cf-text-mute:  #6b7280   /* sous-titres */
--cf-bg:         #ffffff   /* sections claires */
--cf-bg-alt:     #f8f9fa   /* sections alternées */
```

Si tu veux changer une couleur partout, modifie juste la variable dans `style.css` ligne 17.

---

## 🔍 SEO automatique

Le child theme injecte deux JSON-LD sans toucher au plugin SEO :

1. **ProfessionalService** sur toutes les pages (info entité Cédric)
2. **FAQPage** sur la homepage (6 questions/réponses)

Vérification :
- Source de la page > recherche `application/ld+json`
- [Google Rich Results Test](https://search.google.com/test/rich-results) sur l'URL

Le **meta title** + **meta description** de la homepage sont aussi injectés. Si tu installes Yoast ou Rank Math, ils auront la priorité et ces ajouts seront ignorés (pas de conflit).

---

## 📝 À faire ensuite (étape 2, après validation visuelle)

- [ ] Créer la page `/accompagnement-complet/` avec sa structure (à fournir)
- [ ] Refondre `/audit-blanc-qualiopi/`
- [ ] Refondre les 4 pages-guides
- [ ] Refondre À propos
- [ ] Refondre Contact
- [ ] Refondre Diagnostic (juste enveloppe visuelle)
- [ ] Ajouter `/accompagnement-complet/` au menu principal (wp-admin > Apparence > Menus)
- [ ] Chercher/remplacer "2022" → "2025" dans le contenu WP (DB search via plugin Better Search Replace, ou manuel)
- [ ] Générer un `screenshot.png` 1200×900 et le déposer dans `kadence-child/`

---

## 🛠️ Compatibilité LiteSpeed Cache

Aucune action requise. Le CSS du child theme :
- Est statique, donc cachable (~ 18 KB minifié)
- Compatible avec la fonction **CSS combine** de LiteSpeed (peut être combiné avec les autres CSS du site)
- N'utilise pas de variables JS dynamiques qui casseraient le critical CSS auto

Recommandations LiteSpeed :
- Activer **CSS Optimize** (combine + minify)
- Activer **Generate Critical CSS** pour le hero
- Activer **Lazy Load Images** (déjà natif WP, LiteSpeed renforce)

---

## ⚠️ Si quelque chose casse

1. Désactive le child theme → réactive Kadence parent. Le site retrouve son état d'avant.
2. Le `style.css` du parent n'a JAMAIS été modifié → aucun risque côté parent.
3. Les blocs Kadence sur la homepage restent intacts si tu as juste ajouté un bloc HTML par-dessus.

---

## 🤝 Modifications futures

Pour toute modif visuelle :
- **NE touche jamais** au dossier `kadence/` (parent). Il sera écrasé au prochain update.
- Modifie uniquement `kadence-child/style.css` ou `functions.php`.
- Garde une version sous `git` si tu veux suivre l'historique.
