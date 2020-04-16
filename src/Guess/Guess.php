<?php
namespace Ylvan\Guess;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */


class Guess
{
    /**
     * @var int $secretNumber   The current secret number.
     * @var int $triesLeft    Number of tries a guess has been made.
     * @var bool $youWon    is set to true if game is won
     */

    private $secretNumber;
    public $triesLeft;
    public $youWon = false;

    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $tries  Number of tries a guess has been made,
     *                    default 6.
     */

    public function __construct(int $tries = 6)
    {
        // $this->secretNumber = $this->random();
        $this->secretNumber = mt_rand(1, 100);
        $this->triesLeft = $tries;
    }

    /**
     * change amount of tries left
     *
     * @return void
     */
    public function setTriesLeft(int $value)
    {
        $this->triesLeft = $value;
    }

    /**
     * lower count of triesleft
     *
     * @return void
     */
    public function guessMade()
    {
        $this->triesLeft = $this->triesLeft - 1;
    }

    /**
     * set a new random number
     * reset youwon to false
     * reset triesleft
     *
     * @return void
     */
    public function reset()
    {
        $this->youWon = false;
        $this->setTriesLeft(6);
        $this->random();
    }

    /**
     * Randomize the secret number between 1 and 100
     *
     * @return void
     */
    private function random()
    {
        // $randomNum = mt_rand(1, 100);
        $this->secretNumber = mt_rand(1, 100);
    }

    /**
     * Get number of tries left.
     *
     * @return int as number of tries made.
     */

    public function tries()
    {
        return $this->triesLeft;
    }

    /**
     * Get the secret number.
     *
     * @return int as the secret number.
     */

    public function number()
    {
        return $this->secretNumber;
    }


    /**
     * decrease remaining guesses and return a string stating
     * and check the guess value
     *
     *
     * @return string to show the status of the guess made.
     */
    public function guessResult($guessNum)
    {
        /*eslint-disable-complexity*/
        $this->guessMade();

        if (is_numeric($guessNum)) {
            if ($this->youWon == true) {
                $line1 = "Not valid. ";
                $line2 = "<br> You already won. ";
                $line3 = "<br>Press reset for a new game";
                return $line1 . $line2 . $line3;
            } elseif ($guessNum == $this->secretNumber && $this->triesLeft == 0) {
                $this->youWon = true;
                return "Correct";
            } elseif ($this->triesLeft <= 0) {
                $line1 = "Wrong";
                $line2 = "<br> You have no tries left, you lose.";
                $line3 = "<brPress reset for a new game";
                return $line1 . $line2 . $line3;
            } else {
                return $this->checkGuess($guessNum);
            }
        } else {
                $line1 = "Not a number ";
                $line2 = "<br>Please guess a number between 1-100";
                return $line1 . $line2;
        }
    }

    /**
     *
     * check if the guess was correct, too low or to high or if no guesses remains.
     *
     * @throws GuessException when guessed number is out of bounds or not an integer.
     *
     * @return string to show the status of the guess made.
     */
    private function checkGuess($guessNum)
    {
        if ($guessNum > 100 || $guessNum < 0) {
            throw new GuessException("number be a positive integer between 1-100.");
        } else {
            if ($guessNum == $this->secretNumber) {
                $this->youWon = true;
                return "Correct";
            } elseif ($guessNum < $this->secretNumber) {
                return "Too low";
            } elseif ($guessNum > $this->secretNumber) {
                return "Too high";
            }
        }
    }



    // /**
    //  * Make a guess, decrease remaining guesses and return a string stating
    //  * if the guess was correct, too low or to high or if no guesses remains.
    //  *
    //  * @throws GuessException when guessed number is out of bounds or not an integer.
    //  *
    //  * @return string to show the status of the guess made.
    //  */
    // public function guessResult($guessNum)
    // {
    //
    //     if (is_numeric($guessNum)) {
    //         if ($this->triesLeft == 0) {
    //             $line1 = "<br><p>  You have guessed on: " . $guessNum . '</p>';
    //             $line2 = "<h2> No tries left, you lose</h2> ";
    //             $line3 = "<p>Press reset for a new game</p>";
    //             return $line1 . $line2 . $line3;
    //         } elseif ($this->triesLeft < 0) {
    //             $line1 = "<h2> No tries left, you lose</h2> ";
    //             $line2 = "<p>Press reset for a new game</p>";
    //             return $line1 . $line2;
    //         } else {
    //             if ($guessNum > 100 || $guessNum < 0) {
    //                 throw new Ylvan\Guess\GuessException("number be a positive integer between 1-100.");
    //             } else {
    //                 if ($guessNum == $this->secretNumber) {
    //                     $line1 = "<br><p>  You have guessed on: " . $guessNum . '</p>';
    //                     $line2 = "<br><h2> Congratulations, it's the correct number</h2> ";
    //                     return $line1 . $line2;
    //                 } elseif ($guessNum < $this->secretNumber) {
    //                     // $guess->wrongGuess();
    //                     $line1 = "<br><p>  You have guessed on: " . $guessNum . '</p>';
    //                     $line2 = "<p><br>Wrong number: The number were too low </p>";
    //                     $line3 = "<p> You have " . $triesLeft . " tries left</p> ";
    //                     return $line1 . $line2 . $line3;
    //                 } elseif ($guessNum > $this->secretNumber) {
    //                     // $guess->wrongGuess();
    //                     $line1 = "<br><p>  You have guessed on: " . $guessNum . '</p>';
    //                     $line2 = "<p><br> Wrong number: The number were too high <br> Tou have " . $triesLeft . " tries left</p> ";
    //                     return $line1 . $line2;
    //                 }
    //             }
    //         }
    //     } else {
    //         // $line1 = "<br><p>  You have guessed on: " . $guessNum . '</p>';
    //         // $line2 = "<p>Please guess a number between 1-100</p>";
    //         // return $line1 . $line2;
    //         throw new Ylvan\Guess\GuessException($guessNum . " is not a valid number");
    //     }
    // }
}
