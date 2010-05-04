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
     * @Column(type="string", name="slug", nullable="false")
     */
    protected $slug;

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
     * @Column(type="datetime", name="date", nullable="false")
     */
    protected $date;

    /**
     * @var boolean
     * @Column(type="boolean", name="published", nullable="false")
     */
    protected $published;

    /**
     * @param string $title
     * @param string $content
     * @param DateTime $date
     * @param boolean $published
     */
    public function __construct($title, $content = '', $date = null, $published = false)
    {
        $this->setTitle($title);
        $this->setSlug(self::slug($title));
        $this->setContent($content);
        $this->setDate($date);
        $this->setPublished($published);
    }

    /**
     * @param string $title
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param DateTime $date
     * @return Article
     */
    public function setDate(\DateTime $date = null)
    {
        if (null === $date) {
            $date = new \DateTime();
        }
        $this->date = $date;
        return $this;
    }

    /**
     * @param boolean $published
     * @return Article
     */
    public function setPublished($published = true)
    {
        $this->published = $published;
        return $this;
    }

    /**
     * Returns the url to view the inidividual article
     *
     * @return string
     */
    public function getUrl()
    {
        $d = $this->getDate();
        return '/view/' . $d->format('Y')
             . '/' . $d->format('n')
             . '/' . $d->format('j')
             . '/' . $this->getSlug() . '/';
    }

    /**
     * Creates a URL friendly slug (NOT UNIQUE)
     *
     * @param string $str
     * @return string
     */
    public static function slug($str)
    {
        $str = strtolower(trim($str));
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        return preg_replace('/-+/', "-", $str);
    }
}