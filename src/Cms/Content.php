<?php

namespace Mipodi\Cms;

use Anax\Route\Exception\ForbiddenException;
use Anax\Route\Exception\NotFoundException;

/**
 * Class for handling content in the cms by interacting w database.
 */

class Content
{
    /**
     * @var object $db        Database object.
     */
    private $db;


    /**
     * Constructor to initiate the Content class.
     *
     * @param object $db     Database object.
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Show all in database.
     *
     * @return object.
     */
    public function showAll()
    {
        $this->db->connect();
        $sql = "SELECT * FROM content;";
        $resultset = $this->db->executeFetchAll($sql);
        return $resultset;
    }

    /**
     * Edit particular item in database.
     *
     * @return object.
     */
    public function getContent($contentId)
    {
        if (!is_numeric($contentId)) {
            // die("Not valid for content id.");
            throw new ForbiddenException();
        }

        $this->db->connect();
        $sql = "SELECT * FROM content WHERE id = ?;";

        $content = $this->db->executeFetch($sql, [$contentId]);
        return $content;
    }

    /**
     * Edit particular item in database.
     *
     * @return object.
     */
    public function getContentTitle($contentId)
    {
        if (!is_numeric($contentId)) {
            // die("Not valid for content id.");
            throw new ForbiddenException();
        }

        $this->db->connect();
        $sql = "SELECT id, title FROM content WHERE id = ?;";

        $content = $this->db->executeFetch($sql, [$contentId]);
        return $content;
    }

    /**
     * Edit particular item in database.
     *
     * @return object.
     */
    public function deleteContent($contentId)
    {
        if (!is_numeric($contentId)) {
            // die("Not valid for content id.");
            throw new ForbiddenException();
        }

        $this->db->connect();
        $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";

        $this->db->execute($sql, [$contentId]);
    }

    /**
     * Edit particular item in database.
     *
     * @return object.
     */
    public function createContent($title)
    {
        $sql = "INSERT INTO content (title) VALUES (?);";
        $this->db->connect();
        $this->db->execute($sql, [$title]);
        $id = $this->db->lastInsertId();

        return $id;
    }

    /**
     * Edit particular item in database.
     *
     * @return object.
     */
    public function showPages()
    {
        $sql = 'SELECT *, CASE WHEN (deleted <= NOW()) THEN "isDeleted" WHEN (published <= NOW()) THEN "isPublished" ELSE "notPublished" END AS status FROM content WHERE type=?;';
        $this->db->connect();
        $resultset = $this->db->executeFetchAll($sql, ["page"]);
        return $resultset;
    }


    /**
     * Fetch particular page with attached info.
     *
     * @return object.
     */
    public function showPage($path)
    {
        // var_dump($path);
        $sql = 'SELECT *, DATE_FORMAT(COALESCE(updated, published), "%Y-%m-%dT%TZ") AS modified_iso8601, DATE_FORMAT(COALESCE(updated, published), "%Y-%m-%d") AS modified FROM content WHERE path = ? AND type = ? AND (deleted IS NULL OR deleted > NOW()) AND published <= NOW();';
        // var_dump($sql);
        $this->db->connect();
        $resultset = $this->db->executeFetch($sql, [$path, "page"]);
        return $resultset;
    }

    /**
     * Edit particular item in database.
     *
     * @return object.
     */
    public function showBlog()
    {
        $sql = 'SELECT *, DATE_FORMAT(COALESCE(updated, published), "%Y-%m-%dT%TZ") AS published_iso8601, DATE_FORMAT(COALESCE(updated, published), "%Y-%m-%d") AS published FROM content WHERE type=? AND (deleted IS NULL OR deleted > NOW()) AND published <= NOW() ORDER BY published DESC;';
        $this->db->connect();
        $resultset = $this->db->executeFetchAll($sql, ["post"]);
        return $resultset;
    }

    /**
     * Fetch particular page with attached info.
     *
     * @return object.
     */
    public function showBlogpost($slug)
    {
        // var_dump($slug);
        $sql = 'SELECT *, DATE_FORMAT(COALESCE(updated, published), "%Y-%m-%dT%TZ") AS published_iso8601, DATE_FORMAT(COALESCE(updated, published), "%Y-%m-%d") AS published FROM content WHERE slug = ? AND type = ? AND (deleted IS NULL OR deleted > NOW()) AND published <= NOW() ORDER BY published DESC;';
        // var_dump($sql);
        $this->db->connect();
        $resultset = $this->db->executeFetch($sql, [$slug, "post"]);
        return $resultset;
    }

    /**
     * Update particular item in database.
     *
     * @return void.
     */
    public function updateContent($postParams)
    {

        // if (!is_numeric($contentId)) {
        //     die("Not valid for content id.");
        // }

        $this->db->connect();


        if (!$postParams["contentSlug"]) {
            $postParams["contentSlug"] = $this->slugify($postParams["contentTitle"]);
        }

        if (!$postParams["contentPath"]) {
            $postParams["contentPath"] = null;
        }

        $sql = "UPDATE IGNORE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
        $this->db->execute($sql, array_values($postParams));
    }

    /**
     * Create a slug of a string, to be used as url.
     *
     * @param string $str the string to format as slug.
     *
     * @return str the formatted slug.
     */
    public function getPost($app, $key, $default = null)
    {
        $post = [];
        if (is_array($key)) {
            foreach ($key as $val) {
                $post[$val] = $this->getPost($app, $val);
            }
            return $post;
        }

        return null != $app->request->getPost($key)
            ? $app->request->getPost($key)
            : $default;
    }

    /**
     * Create a slug of a string, to be used as url.
     *
     * @param string $str the string to format as slug.
     *
     * @return str the formatted slug.
     */
    public function slugify($str)
    {
        $str = mb_strtolower(trim($str));
        $str = str_replace(['å','ä'], 'a', $str);
        $str = str_replace('ö', 'o', $str);
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = trim(preg_replace('/-+/', '-', $str), '-');
        return $str;
    }
}
