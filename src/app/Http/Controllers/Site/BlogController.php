<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\BlogArticles;
use Illuminate\Contracts\View\View;

class BlogController extends Controller
{
    private array $articles;

    public function __construct()
    {
        // Load articles once per request.
        $this->articles = BlogArticles::orderBy('published_date', 'desc')->get()->toArray();
    }

    public function showBlog(): View
    {
        $articles = $this->articles;
        $currentArticleIndex = 0;

        return view('site.blog', compact('articles', 'currentArticleIndex'));
    }

    public function nextArticle(int $currentArticleIndex): array
    {
        if ($currentArticleIndex < count($this->articles) - 1) {
            $currentArticleIndex++;
        } else {
            $currentArticleIndex = 0;
        }

        return ['article' => $this->articles[$currentArticleIndex], 'index' => $currentArticleIndex];
    }

    public function previousArticle(int $currentArticleIndex): array
    {
        if ($currentArticleIndex > 0) {
            $currentArticleIndex--;
        } else {
            $currentArticleIndex = count($this->articles) - 1;
        }

        return ['article' => $this->articles[$currentArticleIndex], 'index' => $currentArticleIndex];
    }

    public function showArticle(string $slug): View
    {
        $filteredArticles = array_filter($this->articles, fn ($article) => $article['slug'] === $slug);

        if (empty($filteredArticles)) {
            abort(404);
        }

        $article = array_values($filteredArticles)[0];
        $article['readTime'] = $this->getReadTime($article['content']);

        // Find the index of the current article.
        $index = array_search($article['slug'], array_column($this->articles, 'slug'), true);

        // Get the next article (loop back to first if at the end).
        if ($index !== false && $index < count($this->articles) - 1) {
            $nextArticle = $this->articles[$index + 1];
        } else {
            $nextArticle = $this->articles[0] ?? null;
        }

        return view('site.blog.singleArticle', compact('article', 'nextArticle'));
    }

    private function getReadTime(string $articleContent): string
    {
        $readTime = str_word_count($articleContent) / 300;

        if ($readTime < 1) {
            return '1 minute';
        }

        return round($readTime) . ' minutes';
    }
}

