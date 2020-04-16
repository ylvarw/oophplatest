<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());



?><h1>Play the game</h1>

    <p>Guess a number between 1 and 100. You have <?= $tries ?> tries left</p>
    <!-- <form class="guessNumber" method="post">
        Guess: <input type="int" name="guessNum">
        <input type="submit" name="doGuess" value="Make guess" onKeyPress=”return keyPressed(event)”>
    </form>
    <form class="giveup" method="post">
        <input type="submit" name="giveUp" value="give up" onKeyPress="return keyPressed(event)">
    </form>
    <form class="reset" method="post">
        <input type="submit" name="reset" value="Reset" onKeyPress="return keyPressed(event)">
    </form> -->

    <form method="post">
        Guess: <input type="int" name="guess">
        <input type="submit" name="doGuess" value="Make guess">
        <input type="submit" name="doReset" value="Reset game">
        <input type="submit" name="doCheat" value="Cheat">
    </form>

<?php if ($res) : ?>
    <p>You guessed <?= $guess ?>, your guess is <?= $res ?> </>
<?php endif; ?>


<?php if ($number) : ?>
    <p>The correct number is <?= $number ?> </p>
<?php endif; ?>
