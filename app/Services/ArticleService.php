<?php

namespace App\Services;

use App\Models\Article;

class ArticleService
{
    public function create(array $data)
    {
        $article = Article::create($data);

        return $article;
    }

    public function list()
    {
        $articles = Article::all();

        return $articles;
    }

    public function listById(string $id)
    {
        $article = Article::findOrFail($id);

        return $article;
    }

    public function delete($id)
    {
        $article = Article::findOrFail($id);

        return $article->delete();
    }

    public function update(string $id, array $data)
    {
        $article = Article::findOrFail($id);
        $article->update($data);

        return $article;
    }
}
