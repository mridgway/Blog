<?php

namespace Blog\Service;

class Article extends \Core\Service\AbstractService
{
    /**
     * Creates an article from an array of data
     *
     * @param array $data
     * @return Blog\Model\Article
     */
    public static function createArticle(array $data)
    {
        if (!array_key_exists('title', $data)) {
            throw new \Exception('Title must be set.');
        }

        $article = null;
        if (array_key_exists('content', $data)
            && array_key_exists('date', $data)
            && $data['date'] != ''
        ) {
            $date = new \DateTime($data['date']);
            $article = new \Blog\Model\Article($data['title'], $data['content'], $date);
        } else if (array_key_exists('content', $data)) {
            $article = new \Blog\Model\Article($data['title'], $data['content']);
        } else {
            $article = new \Blog\Model\Article($data['title']);
        }

        if (array_key_exists('published', $data) && $data['published'] == 1) {
            $article->setPublished(true);
        }

        if (array_key_exists('description', $data)) {
            $article->setDescription($data['description']);
        }

        return $article;
    }

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