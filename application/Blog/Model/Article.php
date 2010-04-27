<?php

namespace Blog\Model;

/**
 * @Entity(repositoryClass="Blog\Repository\Article")
 * @Table(name="BlogArticle")
 */
class Article extends \Core\Model\AbstractModel
{

    /**
     * @var integer
     * @Id
     * @Column(type="integer", name="article_id")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string", name="title", nullable="false")
     */
    protected $title;

    /**
     * @var string
     * @Column(type="text", name="content", nullable="false")
     */
    protected $content;

    /**
     * @var DateTime
     * @Column(type="datetime", name="date", nullable="true")
     */
    protected $date;

    public function __construct($title, $content = '', $date = null)
    {
        $this->setTitle($title);
        $this->setContent($content);
        $this->setDate($date);
    }

}