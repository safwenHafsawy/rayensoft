<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogArticles;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BlogArticles::create([
            'title' => "Rayen Soft : L’Agence Web Pensée pour les Prestataires de Services et les Petites Entreprises",
            'slug' => 'rayensoft-agence-web-services-pme',
            'preview' => "Découvrez Rayen Soft, l’agence web pensée pour les prestataires de services et les petites entreprises. Nous créons des sites web performants, adaptés à vos besoins et à votre budget.",
            'mobile_preview' => "Rayen Soft : L’Agence Web Pensée pour les Prestataires de Services et les Petites Entreprises",
            'content' => file_get_contents(database_path('seeders/content/article0.html')),
            'image' => 'assets/articles/rayensoft-agence-web.webp',
            'published_date' => '2025-07-31',
            'meta_title' => "Rayen Soft : L’Agence Web Pensée pour les Prestataires de Services et les Petites Entreprises",
        ]);

        BlogArticles::create([
            'title' => 'Votre petite entreprise échoue peut-être à cause d’un détail simple : votre site web',
            'slug' => 'votre-petite-entreprise-echoue-peut-etre-a-cause-dun-detail-simple-votre-site-web',
            'preview' => 'Votre site web est bien plus qu’une vitrine : c’est un levier de crédibilité, de conversion et de clarté. Découvrez comment il peut transformer votre petite entreprise.',
            'mobile_preview' => 'Et si votre site web était la cause de vos difficultés ?',
            'content' => file_get_contents(database_path('seeders/content/article1.html')),
            'image' => 'assets/articles/petite-entreprise-site-web.webp',
            'published_date' => '2025-01-25',
            'meta_title' => 'Pourquoi votre site web peut freiner votre petite entreprise',
            'meta_description' => 'Découvrez comment un site web bien conçu peut renforcer la crédibilité de votre entreprise et améliorer vos ventes.',
        ]);

        BlogArticles::create([
            'title' => 'Créer un site web e-commerce performant : 5 astuces pour booster vos ventes',
            'slug' => 'creer-un-site-web-e-commerce-performant',
            'preview' => 'Votre site e-commerce ne doit pas juste exister — il doit vendre. Voici 5 astuces concrètes pour transformer vos visiteurs en acheteurs fidèles.',
            'mobile_preview' => '5 astuces simples pour faire décoller votre boutique en ligne.',
            'content' => file_get_contents(database_path('seeders/content/article2.html')),
            'image' => 'assets/articles/ecommerce-site-web.webp',
            'published_date' => '2025-02-12',
            'meta_title' => 'Créer un site e-commerce performant : 5 conseils clés',
            'meta_description' => 'Optimisez votre boutique en ligne grâce à ces 5 astuces essentielles : descriptions, vitesse, paiement, SEO et plus encore.',
        ]);
    }
}
