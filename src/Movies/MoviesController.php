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

        $title = "Movie database | oophp";

        $this->app->db->connect();
        $sql = "SELECT * FROM movie;";
        $res = $this->app->db->executeFetchAll($sql);

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
     * @return string
     */
    public function initAction() : object
    {
        // Deal with the action and return a response.
        // echo "HELLOOO";
        // return __METHOD__ . ", \$db is {$this->db}";
        $this->app->session->set("diceGame", null);
        $this->app->session->set("doRoll", null);
        $this->app->session->set("doSave", null);
        $this->app->session->set("doInit", null);
        $this->app->session->set("res", null);


        $diceGame = null;
        $diceGame = new DiceGame();

        $this->app->session->set("diceGame", $diceGame);

        return $this->app->response->redirect("dice2/play");
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function playActionGet() : object
    {
        $title = "Play the game 2";
        // $computerLatestRoll = null;
        $humanLatestRoll = null;
        $diceGame = $this->app->session->get("diceGame");

        $gameStatus = $this->app->session->get("doRoll") ?? $this->app->session->get("doSave");
        $diceGame->play($gameStatus);

        $doInit = $this->app->session->get("doInit");
        if ($doInit) {
            return $this->app->response->redirect("dice2/init");
        }

        $tempScore = $diceGame->tempScore();
        $humanScore = $diceGame->humanScore();
        $computerScore = $diceGame->computerScore();
        $humanLatestRoll = $diceGame->getHumanLatestRoll() ?? null;
        $computerLatestRoll = $diceGame->getComputerLatestRoll() ?? null;
        $winner = $diceGame->isWinner() ?? null;
        $humanHistogram = null;
        $computerHistogram = null;

        // $histogram = $diceGame->testInterface() ?? null;
        $doSave = $this->app->session->get("doSave");
        $doRoll = $this->app->session->get("doRoll");

        if ($doSave || $doRoll) {
            $humanHistogram = $diceGame->printHumanHistogram(1, 8) ?? null;
            $computerHistogram = $diceGame->printComputerHistogram(1, 8) ?? null;
        } else {
            $humanHistogram = null;
            $computerHistogram = null;
            // $histogram = null;
        }

        $data = [
            "humanScore" => $humanScore,
            "computerScore" => $computerScore,
            "tempScore" => $tempScore,
            "computerLatestRoll" => $computerLatestRoll,
            "humanLatestRoll" => $humanLatestRoll,
            "winner" => $winner,
            "humanHistogram" => $humanHistogram,
            "computerHistogram" => $computerHistogram
        ];

        $this->app->page->add("dice2/play", $data);
        // $this->app->page->add("dice/debug");

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
    public function playActionPost() : object
    {
        $doSave = $this->app->request->getPost("doSave");
        $doRoll = $this->app->request->getPost("doRoll");
        $doInit = $this->app->request->getPost("doInit");

        $this->app->session->set("doSave", $doSave);
        $this->app->session->set("doRoll", $doRoll);
        $this->app->session->set("doInit", $doInit);

        return $this->app->response->redirect("dice2/play");
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
