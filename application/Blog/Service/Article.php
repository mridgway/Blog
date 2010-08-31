<?php

namespace Blog\Service;

class Article extends \Core\Service\AbstractService
{
    public static function updateArticle(\Blog\Model\Article $article, array $data)
    {
        if (array_key_exists('slug', $data)) {
            $article->setSlug($data['slug']);
        }

        if (array_key_exists('title', $data)) {
            $article->setTitle($data['title']);
        }

        if (array_key_exists('description', $data)) {
            $article->setDescription($data['description']);
        }

        if (array_key_exists('content', $data)) {
            $article->setContent($data['content']);
        }

        if (array_key_exists('date', $data)) {
            $date = new \DateTime($data['date']);
            $article->setDate($date);
        }

        if (array_key_exists('published', $data)) {
            $article->setPublished($data['published'] ? true : false);
        }
    }
}