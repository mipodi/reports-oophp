<?php

namespace Mipodi\Movies;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
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
class MoviesController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";



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

        // Use $this->app to access the framework services.
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : object
    {
        // Deal with the action and return a response.
        // echo "HELLOOO";
        // return __METHOD__ . ", \$db is {$this->db}";

        $title = "Movie database";

        $this->app->db->connect();
        $sql = "SELECT * FROM movie;";
        $res = $this->app->db->executeFetchAll($sql);

        $this->app->page->add("movies/header");
        $this->app->page->add("movies/index", [
            "res" => $res,
        ]);

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
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function searchtitleActionGet() : object
    {
        $this->app->db->connect();
        // $searchTitle = "Pulp";

        $request = new \Anax\Request\Request();
        $request->init();

        $searchTitle = $request->getGet("searchTitle");
        $resultset = 0;

        if ($searchTitle) {
            $sql = "SELECT * FROM movie WHERE title LIKE ?;";
            $resultset = $this->app->db->executeFetchAll($sql, [$searchTitle]);
        }

        $this->app->page->add("movies/header");
        $this->app->page->add("movies/search-title", [
            // "resultset" => $resultset,
            "searchTitle" => $searchTitle
        ]);
        $this->app->page->add("movies/show-all", [
            "resultset" => $resultset,
            "searchTitle" => $searchTitle
        ]);

        return $this->app->page->render([
            // "title" => $title,
        ]);
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function searchyearActionGet() : object
    {
        $this->app->db->connect();
        $request = new \Anax\Request\Request();
        $request->init();

        $year1 = $request->getGet("year1");
        $year2 = $request->getGet("year2");

        $resultset = 0;

        if ($year1 && $year2) {
            $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
            $resultset = $this->app->db->executeFetchAll($sql, [$year1, $year2]);
        } elseif ($year1) {
            $sql = "SELECT * FROM movie WHERE year >= ?;";
            $resultset = $this->app->db->executeFetchAll($sql, [$year1]);
        } elseif ($year2) {
            $sql = "SELECT * FROM movie WHERE year <= ?;";
            $resultset = $this->app->db->executeFetchAll($sql, [$year2]);
        }

        $this->app->page->add("movies/header");
        $this->app->page->add("movies/search-year", [
            // "resultset" => $resultset,
            // "searchTitle" => $searchTitle
        ]);
        $this->app->page->add("movies/show-all", [
            "resultset" => $resultset,
        ]);

        return $this->app->page->render([
            // "title" => $title,
        ]);
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function movieselectActionGet() : object
    {
        $this->app->db->connect();
        $request = new \Anax\Request\Request();
        $request->init();

        $movieId = $request->getGet("movieId");
        // var_dump($movieId);

        $sql = "SELECT id, title FROM movie;";
        $movies = $this->app->db->executeFetchAll($sql);

        $this->app->session->set("movieId", $movieId);
        // var_dump($movieId);

        $this->app->page->add("movies/header");
        $this->app->page->add("movies/movie-select", [
            // "resultset" => $resultset,
            "movies" => $movies
        ]);

        return $this->app->page->render([
            // "title" => $title,
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
    public function movieselectActionPost() : object
    {
        $this->app->db->connect();
        $request = new \Anax\Request\Request();
        $request->init();

        $movieId = $this->app->session->get("movieId");

        $movieId = $request->getPost("movieId");
        $doEdit = $request->getPost("doEdit");
        $doDelete = $request->getPost("doDelete");
        $doAdd = $request->getPost("doAdd");
        $doSave = $request->getPost("doSave");

        if ($doSave) {
            $movieId    = $request->getPost("movieId");
            $movieTitle = $request->getPost("movieTitle");
            $movieYear  = $request->getPost("movieYear");
            $movieImage = $request->getPost("movieImage");

            $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
            $this->app->db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
        } elseif ($doDelete) {
            $sql = "DELETE FROM movie WHERE id = ?;";
            $this->app->db->execute($sql, [$movieId]);
            return $this->app->response->redirect("movies/movie-select");
        } elseif ($doAdd) {
            $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
            $this->app->db->execute($sql, ["A title", 2017, "img/noimage.png"]);
            $movieId = $this->app->db->lastInsertId();
        }

        $sql = "SELECT * FROM movie WHERE id = ?;";
        $movie = $this->app->db->executeFetchAll($sql, [$movieId]);
        $movie = $movie[0];

        $this->app->page->add("movies/header");
        $this->app->page->add("movies/movie-edit", [
            "movie" => $movie
        ]);

        return $this->app->page->render([
            // "title" => $title,
        ]);
    }




    /**
     * This sample method dumps the content of $app.
     * GET mountpoint/dump-app
     *
     * @return string
     */
    public function dumpAppActionGet() : string
    {
        // Deal with the action and return a response.
        $services = implode(", ", $this->app->getServices());
        return __METHOD__ . "<p>\$app contains: $services";
    }



    /**
     * Add the request method to the method name to limit what request methods
     * the handler supports.
     * GET mountpoint/info
     *
     * @return string
     */
    public function infoActionGet() : string
    {
        // Deal with the action and return a response.
        return __METHOD__ . ", \$db is {$this->db}";
    }



    /**
     * This sample method action it the handler for route:
     * GET mountpoint/create
     *
     * @return string
     */
    public function createActionGet() : string
    {
        // Deal with the action and return a response.
        return __METHOD__ . ", \$db is {$this->db}";
    }



    /**
     * This sample method action it the handler for route:
     * POST mountpoint/create
     *
     * @return string
     */
    public function createActionPost() : string
    {
        // Deal with the action and return a response.
        return __METHOD__ . ", \$db is {$this->db}";
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
