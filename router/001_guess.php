<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * init game and redirect to play game
 */
$app->router->get("guess/init", function () use ($app) {
    session_name("guess");
    session_start();

    // $game = new Ylvan\Guess\Guess();
    if (!isset($_SESSION["guess"])) {
        $_SESSION["guess"] = new Ylvan\Guess\Guess();
        // $game = $_SESSION["guess"];
        // $_SESSION["number"] = $game->secretNumber;
        // $_SESSION["number"] = $game->number();
    }
    // $guess = $_SESSION["guess"];
    // set the variables
    // $triesLeft = $guess->triesLeft;
    // $winnNumber = $guess->number();
    //init session for gamestart
    return $app->response->redirect("guess/play");
});



/**
 * Rplay the game
 */
$app->router->post("guess/play", function () use ($app) {

    $game = $_SESSION["guess"];

    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->triesLeft;


    $guessNum = $_POST["guess"] ?? null;
    $doGuess = $_POST["doGuess"] ?? null;
    $doCheat = $_POST["doCheat"] ?? null;
    $doReset = $_POST["doReset"] ?? null;
    $res = null;
    $cheat = null;

    // set the variables
    $triesLeft = $_SESSION["tries"] ?? null;
    $winnNumber = $_SESSION["number"] ?? null;
    // $res = $_SESSION["res"] ?? null;

    // get the guessed number
    if ($doGuess) {
        // if (!is_numeric($guessNum)) {
        //     $line1 = "Not a number ";
        //     $line2 = "<br>Please guess a number between 1-100";
        //     $res = $line1 . $line2;
        //     $_SESSION["res"] = $res;
        //     $_SESSION["guessNum"] = $guessNum;
        //     // throw new GuessException($guessNum . " is not a valid number");
        // } else {
        $res = $game->guessResult($guessNum);
        $_SESSION["guessNum"] = $guessNum;
        $_SESSION["res"] = $res;
        $_SESSION["tries"] = $game->triesLeft;
        // }
    }

    // start a new game
    if ($doReset || $winnNumber === null) {
        // start new game
        $game->reset();
        $game = new Ylvan\Guess\Guess();
        // $_SESSION["number"] = $game->secretNumber;
        $_SESSION["number"] = $game->number();
        $_SESSION["tries"] = $game->triesLeft;
    }


    if ($doCheat) {
        $cheat = $game->number();
        $_SESSION["cheat"] = $cheat;
    }

    return $app->response->redirect("guess/play");
});



/**
* Showing message Hello World, rendered within the standard page layout.
 */
 $app->router->get("guess/play", function () use ($app) {

     $triesLeft = $_SESSION["tries"] ?? null;
     $guessNum = $_SESSION["guessNum"] ?? null;
     $cheat = $_SESSION["cheat"] ?? null;
     $_SESSION["cheat"] = null;
     $res = $_SESSION["res"] ?? null;
     $_SESSION["res"] = null;

     $title = "Play the game";
     $data = [
         "guess" => $guessNum,
         "tries" => $triesLeft,
         "number" => $cheat,
         "res" => $res,
         "doGuess" => $doGuess ?? null,
         "doReset" => $doReset ?? null,
         "doCheat" => $doCheat ?? null,
     ];

     $app->page->add("guess/play", $data);
     // $app->page->add("guess/debug");

     return $app->page->render([
         "title" => $title,
     ]);
 });






/**
* Showing message Hello World, rendered within the standard page layout.
 */
// $app->router->get("lek/hello-world-page", function () use ($app) {
//     $title = "Hello World as a page";
//     $data = [
//         "class" => "hello-world",
//         "content" => "Hello World in " . __FILE__,
//     ];
//
//     $app->page->add("anax/v2/article/default", $data);
//
//     return $app->page->render([
//         "title" => $title,
//     ]);
// });
