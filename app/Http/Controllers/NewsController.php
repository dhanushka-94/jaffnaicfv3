<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $articles = News::query()
            ->published()
            ->latest('published_at')
            ->paginate(9);

        return view('news.index', [
            'articles' => $articles,
        ]);
    }

    public function show(News $news): View
    {
        abort_unless($news->isPublished(), 404);

        $related = News::query()
            ->published()
            ->whereKeyNot($news->getKey())
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('news.show', [
            'article' => $news,
            'related' => $related,
        ]);
    }
}
