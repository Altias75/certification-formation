<?php
/**
 * Kadence Child — Certification Formation
 * Version minimaliste : enqueue + SEO basique
 * Chaque hook isolé dans une fonction nommée pour faciliter le debug.
 */

if (!defined('ABSPATH')) {
    exit;
}

/* ============================================================================
   1. ENQUEUE STYLE — la priorité absolue, isolée en début de fichier
   ============================================================================ */

function cf_enqueue_child_style() {
    wp_enqueue_style(
        'kadence-child-css',
        get_stylesheet_directory_uri() . '/style.css',
        array(),
        '1.1.2' // Bump version : force cache-bust navigateur + LiteSpeed
    );
}
add_action('wp_enqueue_scripts', 'cf_enqueue_child_style', 99);

/* ============================================================================
   2. JSON-LD : ProfessionalService global
   ============================================================================ */

function cf_json_ld_professional_service() {
    $schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'ProfessionalService',
        '@id'         => home_url('/#organization'),
        'name'        => 'Cédric Le Meur — Consultant Qualiopi',
        'url'         => home_url('/'),
        'description' => 'Accompagnement Qualiopi 100% en ligne pour formateurs indépendants. Certifié Qualiopi en solo depuis 2025.',
        'areaServed'  => array('@type' => 'Country', 'name' => 'France'),
        'founder'     => array('@type' => 'Person', 'name' => 'Cédric Le Meur'),
        'knowsAbout'  => array('Qualiopi', 'Certification formation professionnelle', 'Audit Qualiopi'),
    );
    echo "\n" . '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}
add_action('wp_head', 'cf_json_ld_professional_service', 30);

/* ============================================================================
   3. JSON-LD : FAQPage (homepage seulement)
   ============================================================================ */

function cf_json_ld_faqpage_homepage() {
    if (!is_front_page()) {
        return;
    }

    $faq = array(
        array(
            'q' => 'Combien de temps pour obtenir la certification Qualiopi ?',
            'a' => 'En accompagnement complet, comptez 2 à 3 mois entre le diagnostic initial et la validation du dossier. L\'audit officiel intervient ensuite selon les délais du certificateur (souvent 4 à 6 semaines).',
        ),
        array(
            'q' => 'Puis-je obtenir Qualiopi seul, sans salarié ni service qualité ?',
            'a' => 'Oui. J\'en suis moi-même la preuve : Qualiopi obtenu en solo en 2025, sans salarié. Le référentiel autorise 22 des 32 indicateurs aux structures indépendantes.',
        ),
        array(
            'q' => 'L\'accompagnement est-il 100% en ligne ?',
            'a' => 'Oui. Toutes les séances se font en visio, partout en France. Les documents s\'échangent par mail ou drive sécurisé. Aucun déplacement nécessaire.',
        ),
        array(
            'q' => 'Combien coûte la certification Qualiopi elle-même ?',
            'a' => 'Hors accompagnement, l\'audit officiel coûte généralement entre 1 200€ et 2 500€ HT, plus 600€ à 1 200€ pour l\'audit de surveillance à 18 mois.',
        ),
        array(
            'q' => 'Que se passe-t-il si je rate l\'audit officiel ?',
            'a' => 'Un audit non concluant donne lieu à un délai de mise en conformité de 3 mois. En accompagnement complet, ce cas reste très rare car l\'audit blanc inclus simule fidèlement les vraies questions.',
        ),
        array(
            'q' => 'Différence entre accompagnement complet et audit blanc ?',
            'a' => 'L\'accompagnement complet (1 490€) couvre tout : diagnostic, dossier, modèles, préparation entretien, audit blanc inclus. L\'audit blanc seul (490€) s\'adresse à ceux déjà préparés voulant valider en 3h.',
        ),
    );

    $entities = array();
    foreach ($faq as $item) {
        $entities[] = array(
            '@type'          => 'Question',
            'name'           => $item['q'],
            'acceptedAnswer' => array('@type' => 'Answer', 'text' => $item['a']),
        );
    }

    $schema = array(
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => $entities,
    );

    echo "\n" . '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}
add_action('wp_head', 'cf_json_ld_faqpage_homepage', 31);

/* ============================================================================
   4. META TITLE + DESCRIPTION homepage (si pas géré par plugin SEO)
   ============================================================================ */

function cf_homepage_title($title) {
    if (is_front_page()) {
        return 'Accompagnement Qualiopi formateur indépendant · Cédric Le Meur';
    }
    return $title;
}
add_filter('pre_get_document_title', 'cf_homepage_title', 5);

function cf_homepage_meta_description() {
    if (!is_front_page()) {
        return;
    }
    echo '<meta name="description" content="Certifié Qualiopi en solo, 15 ans d\'expérience formation. Accompagnement 100% en ligne pour formateurs indépendants. Premier appel gratuit.">' . "\n";
}
add_action('wp_head', 'cf_homepage_meta_description', 3);

/* ============================================================================
   5. AUTO-CLASS sur lien menu "CTA" (header)
   ----------------------------------------------------------------------------
   Ajouter la classe CSS "menu-cta" au lien "Réserver un appel" dans
   wp-admin > Apparence > Menus > Options de l'écran > cocher "Classes CSS".
   ============================================================================ */

function cf_menu_cta_class($atts, $item) {
    if (!is_object($item) || empty($item->classes) || !is_array($item->classes)) {
        return $atts;
    }
    if (in_array('menu-cta', $item->classes, true)) {
        $existing = isset($atts['class']) ? $atts['class'] : '';
        $atts['class'] = trim($existing . ' cf-btn cf-btn-primary');
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'cf_menu_cta_class', 10, 2);
