<?php
include(__DIR__ . "/config.php");
include(__DIR__ . "/src/Guess.php");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Guess</title>
</head>
    <body onKeyPress="return keyPressed(event)">
        <h1>Guess my number (POST)</h1>

        <p>Guess a number between 1 and 100</p>
        <form class="guessNumber" method="post">
            Guess: <input type="int" name="guessNum">
            <input type="submit" name="submitGuess" value="Make guess" onKeyPress=”return keyPressed(event)”>
        </form>
        <form class="giveup" method="post">
            <input type="submit" name="giveUp" value="give up" onKeyPress="return keyPressed(event)">
        </form>
        <form class="reset" method="post">
            <input type="submit" name="reset" value="Reset" onKeyPress="return keyPressed(event)">
        </form>

<?php

session_name("guess");
session_start();


if (!isset($_SESSION["guess"])) {
    $_SESSION["guess"] = new Guess();
}

$guess = $_SESSION["guess"];
// set the variables
$triesLeft = $guess->triesLeft;
$winnNumber = $guess->number();

// get the guessed number
if (isset($_POST['submitGuess'])) {
    $guessNum = $_POST['guessNum'];
    $guess->guessMade();
    guessResult($guessNum, $triesLeft, $winnNumber);
    // echo '<p> you guessed: '. $guessNum . '</p>';
}

// set global vars
global $guess;
global $triesLeft;
global $winnNumber;
global $guessNum;
// $wrong = $guess->wrongGuess();
// $guessNum = $guessNumber;

// reset game by destroying the session and reset the session vars
if (isset($_POST['reset'])) {
    // reset data and parameters
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    // destroy the session.
    session_destroy();
    // echo "The session is destroyed.";
}

function guessResult($guessNum, $triesLeft, $winnNumber)
{

    if (is_numeric($guessNum)) {
        if ($triesLeft == 0) {
            echo "<br><p>  You have guessed on: " . $guessNum . '</p>';
            echo "<h2> No tries left, you lose</h2> ";
            echo "<p>Press reset for a new game</p>";

        // } elseif ($triesLeft > 0) {
        } elseif ($triesLeft < 0) {
            echo "<h2> No tries left, you lose</h2> ";
            echo "<p>Press reset for a new game</p>";
        } else {
            if ($guessNum > 100 || $guessNum < 0) {
                throw new GuessException("number be a positive integer between 1-100.");
            } else {
                if ($guessNum == $winnNumber) {
                    echo "<br><p>  You have guessed on: " . $guessNum . '</p>';
                    echo "<br><h2> Congratulations, it's the correct number</h2> ";
                } elseif ($guessNum < $winnNumber) {
                    // $guess->wrongGuess();
                    echo "<br><p>  You have guessed on: " . $guessNum . '</p>';
                    echo "<p><br>Wrong number: The number were too low </p>";
                    echo "<p> You have " . $triesLeft . " tries left</p> ";
                } elseif ($guessNum > $winnNumber) {
                    // $guess->wrongGuess();
                    echo "<br><p>  You have guessed on: " . $guessNum . '</p>';
                    echo "<p><br> Wrong number: The number were too high <br> Tou have " . $triesLeft . " tries left</p> ";
                }
            }
        }
    } else {
        echo "<br><p>  You have guessed on: " . $guessNum . '</p>';
        echo "<p>Please guess a number between 1-100</p>";
    }
}
if (isset($_POST['giveUp'])) {
    echo "<p>The correct number is </p> <h2> " . $winnNumber . "</h2>";
}

?>

    </body>
    <script type="text/javascript">
        function keyPressed(e) {
            var key;
            if (window.event)
            {
                key = window.event.keyCode; //IE
            } else
            {
                key = e.which; //firefox
            }
            return (key != 13);
        }
    </script>
</html>
