<?php
/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */


class Guess
{
    /**
     * @var int $number   The current secret number.
     * @var int $tries    Number of tries a guess has been made.
     */

    private $secretNumber;
    public $triesLeft;
     // public $guessNumber;

    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $number The current secret number, default -1 to initiate
     *                    the number from start.
     * @param int $tries  Number of tries a guess has been made,
     *                    default 6.
     */

    public function __construct(int $tries = 6)
    {
        // $this->secretNumber = $this->random();
        $this->secretNumber = mt_rand(1, 100);
        $this->triesLeft = $tries;
    }

    public function setTriesLeft(int $value)
    {
        $this->triesLeft = $value;
    }

    public function guessMade()
    {
        $this->triesLeft = $this->triesLeft - 1;
    }

    public function reset()
    {
        $this->setTriesLeft(6);
        $this->random();
    }
    /**
     * Randomize the secret number between 1 and 100 to initiate a new game.
     *
     * @return void
     */

    public function random()
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
     * Make a guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high or if no guesses remains.
     *
     * @throws GuessException when guessed number is out of bounds.
     *
     * @return string to show the status of the guess made.
     */

    public function makeGuess($guessNumber)
    {
        echo "<br> You have guessed on: " . $guessNumber;
        // --$this->triesLeft;
        // echo $this->triesLeft;
        if ($this->triesLeft == 0) {
            return "Sorry, you lose <br> You have no tries left";
        } elseif ($this->triesLeft >= 6) {
            --$this->triesLeft;
            // echo "du har några försök kvar";
            if ($guessNumber == $this->secretNumber) {
                return ("<br>Congratulations, it's the correct number");
            } elseif ($guessNumber < $this->secretNumber | $guessNumber >=1) {
                return ("<br>Wrong number: The number were too low <br> You have " . $this->triesLeft . " tries left");
            } elseif ($guessNumber > $this->secretNumber | $guessNumber <= 100) {
                return ("<br>Wrong number: The number were too high <br> Tou have " . $this->triesLeft . " tries left");
            }
        }
    }
}
