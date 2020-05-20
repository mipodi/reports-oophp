<?php

namespace Mipodi\Cms;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

use Anax\Route\Exception\ForbiddenException;
use Anax\Route\Exception\NotFoundException;

// use Anax\Route\Exception\InternalErrorException;

/**
 * A controller for Movies application.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class CmsController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     * @var object $cms stores access to the class.
     */
    private $db = "not active";
    private $cms;
    private $request;



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->db = "active";

        $this->cms = new Content($this->app->db);

        $this->request = new \Anax\Request\Request();
        $this->request->init();

        // Use $this->app to access the framework services.
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function indexAction() : object
    {
        $title = "Show All Content";

        // $this->app->db->connect();
        // $sql = "SELECT * FROM content;";
        // $resultset = $this->app->db->executeFetchAll($sql);

        // $cms = new Content($this->app->db);
        $resultset = $this->cms->showAll();

        $this->app->page->add("content/header");
        $this->app->page->add("content/show-all", [
            "resultset" => $resultset,
        ]);
        $this->app->page->add("content/footer");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the admin method action, gives overview and
     * links to further action such as edit and delete.
     *
     *
     * @return object
     */
    public function adminActionGet() : object
    {
        $title = "Administrate content";

        $resultset = $this->cms->showAll();

        $this->app->page->add("content/header");
        $this->app->page->add("content/admin", [
            "resultset" => $resultset,
        ]);
        $this->app->page->add("content/footer");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the admin method action, gives overview and
     * links to further action such as edit and delete.
     *
     *
     * @return object
     */
    public function createActionGet() : object
    {
        $title = "Create content";

        $this->app->page->add("content/header");
        $this->app->page->add("content/create");
        $this->app->page->add("content/footer");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the admin method action, gives overview and
     * links to further action such as edit and delete.
     *
     *
     * @return object
     */
    public function createActionPost() : object
    {
        $title = $this->request->getPost("contentTitle");

        $id = $this->cms->createContent($title);
        return $this->app->response->redirect("cms/edit/$id");
    }

    /**
     * This is the admin method action, gives overview and
     * links to further action such as edit and delete.
     *
     *
     * @return object
     */
    public function deleteActionGet($id) : object
    {
        $title = "Delete content";

        $content = $this->cms->getContentTitle($id);

        $this->app->page->add("content/header");
        $this->app->page->add("content/delete", [
            "content" => $content,
        ]);
        $this->app->page->add("content/footer");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the admin method action, gives overview and
     * links to further action such as edit and delete.
     *
     *
     * @return object
     */
    public function deleteActionPost($contentId) : object
    {
        // $contentId = $this->request->getPost("contentId");
        // var_dump($contentId);
        $this->cms->deleteContent($contentId);
        return $this->app->response->redirect("cms/admin");
    }

    /**
     * This method action handles getting specific content.
     *
     * @return object
     */
    public function editActionGet($contentId) : object
    {
        $title = "Edit content";

        if (!is_numeric($contentId)) {
            // die("Not valid for content id.");
            throw new ForbiddenException();
        }

        $content = $this->cms->getContent($contentId);

        $this->app->page->add("content/header");
        $this->app->page->add("content/edit", [
            "content" => $content,
        ]);
        $this->app->page->add("content/footer");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This method action handles:
     *
     * @return object
     */
    public function editActionPost($id) : object
    {
        $title = "Edit content";


        $postParams = $this->cms->getPost($this->app, [
            "contentTitle",
            "contentPath",
            "contentSlug",
            "contentData",
            "contentType",
            "contentFilter",
            "contentPublish",
            "contentId"
        ]);

        // print_r($postParams);

        $this->cms->updateContent($postParams);
        $content = $this->cms->getContent($id);

        $this->app->page->add("content/header");
        $this->app->page->add("content/edit", [
            "content" => $content,
        ]);
        $this->app->page->add("content/footer");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the admin method action, gives overview and
     * links to further action such as edit and delete.
     *
     *
     * @return object
     */
    public function showpagesActionGet() : object
    {
        $title = "Pages";

        $resultset = $this->cms->showPages();

        $this->app->page->add("content/header");
        $this->app->page->add("content/pages", [
            "resultset" => $resultset,
        ]);
        $this->app->page->add("content/footer");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }


    /**
     * This is the admin method action, gives overview and
     * links to further action such as edit and delete.
     *
     *
     * @return object
     */
    public function pageActionGet($path) : object
    {
        $title = "Page";

        // var_dump($path);

        $content = $this->cms->showPage($path);

        $this->app->page->add("content/header");

        if (!$content) {
            $this->app->page->add("content/404");
        } elseif ($content) {
            $this->app->page->add("content/page", [
                "content" => $content,
            ]);
        }
        $this->app->page->add("content/footer");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the admin method action, gives overview and
     * links to further action such as edit and delete.
     *
     *
     * @return object
     */
    public function blogActionGet() : object
    {
        $title = "Blog";

        $resultset = $this->cms->showBlog();

        $this->app->page->add("content/header");
        $this->app->page->add("content/blog", [
            "resultset" => $resultset,
        ]);
        $this->app->page->add("content/footer");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the admin method action, gives overview and
     * links to further action such as edit and delete.
     *
     *
     * @return object
     */
    public function postActionGet($slug) : object
    {
        $title = "Blog post";

        // var_dump($slug);

        $content = $this->cms->showBlogpost($slug);

        $this->app->page->add("content/header");

        if (!$content) {
            $this->app->page->add("content/404");
        } elseif ($content) {
            $this->app->page->add("content/blogpost", [
                "content" => $content,
            ]);
        }
        $this->app->page->add("content/footer");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function debugAction() : string
    {
        // Deal with the action and return a response.
        return "debugging works";
        // return __METHOD__ . ", \$db is {$this->db}";
    }


    /**
     * This sample method action takes one argument:
     * GET mountpoint/argument/<value>
     *
     * @param mixed $value
     *
     * @return string
     */
    public function argumentActionGet($value) : string
    {
        // Deal with the action and return a response.
        return __METHOD__ . ", \$db is {$this->db}, got argument '$value'";
    }



    /**
     * This sample method action takes zero or one argument and you can use - as a separator which will then be removed:
     * GET mountpoint/defaultargument/
     * GET mountpoint/defaultargument/<value>
     * GET mountpoint/default-argument/
     * GET mountpoint/default-argument/<value>
     *
     * @param mixed $value with a default string.
     *
     * @return string
     */
    public function defaultArgumentActionGet($value = "default") : string
    {
        // Deal with the action and return a response.
        return __METHOD__ . ", \$db is {$this->db}, got argument '$value'";
    }



    /**
     * This sample method action takes two typed arguments:
     * GET mountpoint/typed-argument/<string>/<int>
     *
     * NOTE. Its recommended to not use int as type since it will still
     * accept numbers such as 2hundred givving a PHP NOTICE. So, its better to
     * deal with type check within the action method and throuw exceptions
     * when the expected type is not met.
     *
     * @param mixed $value with a default string.
     *
     * @return string
     */
    public function typedArgumentActionGet(string $str, int $int) : string
    {
        // Deal with the action and return a response.
        return __METHOD__ . ", \$db is {$this->db}, got string argument '$str' and int argument '$int'.";
    }



    /**
     * This sample method action takes a variadic list of arguments:
     * GET mountpoint/variadic/
     * GET mountpoint/variadic/<value>
     * GET mountpoint/variadic/<value>/<value>
     * GET mountpoint/variadic/<value>/<value>/<value>
     * etc.
     *
     * @param array $value as a variadic parameter.
     *
     * @return string
     */
    public function variadicActionGet(...$value) : string
    {
        // Deal with the action and return a response.
        return __METHOD__ . ", \$db is {$this->db}, got '" . count($value) . "' arguments: " . implode(", ", $value);
    }



    /**
     * Adding an optional catchAll() method will catch all actions sent to the
     * router. You can then reply with an actual response or return void to
     * allow for the router to move on to next handler.
     * A catchAll() handles the following, if a specific action method is not
     * created:
     * ANY METHOD mountpoint/**
     *
     * @param array $args as a variadic parameter.
     *
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function catchAll(...$args)
    {
        // Deal with the request and send an actual response, or not.
        //return __METHOD__ . ", \$db is {$this->db}, got '" . count($args) . "' arguments: " . implode(", ", $args);
        return;
    }
}
