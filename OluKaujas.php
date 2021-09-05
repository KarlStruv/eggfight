<?php
//- Vairākas olas ar dažādiem spēkiem
//- Randomā ģenerējas olas ar dažādiem spēkiem spēlētājam
//- Olām ir daudzums (var būt vienādas olas ar lielāku daudzumu)
//- Uzvaras gadījumā Tu saņem pretinieka olu.
//- Zaudējuma gadījumā Tev pazūd ola
//- Neizšķirta gadījumā abiem pazūd ola
//- Kaujas simulācija beidzas tad, kad vienam no spēlētājiem beidzas olas


///////Nav ielikta funkcija, ka tiek iedalītas random olas, bet iepriekš gan spēlētājam, gan datoram ir iedalītas
/// konkrētas olas.
///
/// Kaujas simulācija nav pilnībā automātiska - ir iespēja izvēlēties ar kuru olu gribi cīnīties pret
/// datora(nejauši izvēlētu) olu.




$playerMe = 0;
$playerPC = 0;
$firstWinner = "";
$secondWinner = "";

function createEgg(string $eggName, int $eggPower, int $eggKey, int $eggAmount) : stdClass{
    $egg = new stdClass();
    $egg->eggName = $eggName;
    $egg->eggPower = $eggPower;
    $egg->eggKey = $eggKey;
    $egg->eggAmount = $eggAmount;

    return $egg;
}

$playerEggs = [
    createEgg("Hen Egg from Maxima", 50, 1, 0),
    createEgg("Hen Egg from Rimi", 55, 2, 1),
    createEgg("Wooden Egg", 75, 3, 1),
    createEgg("Hen Egg of Doom", 150, 4, 1),
];

$computerEggs = [
    createEgg("Hen Egg from Maxima", 50, 1, 1),
    createEgg("Hen Egg from Rimi", 55, 2, 1),
    createEgg("Wooden Egg", 75, 3, 1),
    createEgg("Hen Egg of Doom", 150, 4, 0),
];
$gameIsOn = true;



//Display my egg stash
echo "Your eggs: " . PHP_EOL;
foreach ($playerEggs as $eggs) {
    echo "$eggs->eggKey. $eggs->eggName($eggs->eggPower) x $eggs->eggAmount" . PHP_EOL;
}

while ($gameIsOn = true) {
    //Determine which egg the player chose
    $playerEggKey = (int)readline("Choose your egg: ");
    $playerEgg = "";
    $playerEggPower = 0;

    foreach ($playerEggs as $currentPlayerEgg) {
        if ($playerEggKey === $currentPlayerEgg->eggKey) {
            if ($currentPlayerEgg->eggAmount < 1){
                echo "You don't have any more eggs of this type..." . PHP_EOL;
                exit;
            }
            $playerEgg = $currentPlayerEgg->eggName;
            $playerEggPower = $currentPlayerEgg->eggPower;
        }

    }
    echo "You chose $playerEgg with power: $playerEggPower" . PHP_EOL;
    sleep(2);

    //Determine which egg the computer chose


    $computerEgg = "";
    $computerEggPower = 0;
    $pcChoseEgg = 1;
    while($pcChoseEgg > 0){
        $computerEggKey = rand(1, count($computerEggs));
        var_dump($computerEggKey);
        foreach ($computerEggs as $currentComputerEgg) {

                if ($computerEggKey === $currentComputerEgg->eggKey) {
                    if ($currentComputerEgg->eggAmount > 0) {
                        $computerEgg = $currentComputerEgg->eggName;
                        $computerEggPower = $currentComputerEgg->eggPower;
                        $pcChoseEgg = 0;
                    }
                }
        }
    }
    echo "Computer chose $computerEgg with power: $computerEggPower" . PHP_EOL;
    sleep(1);

    //My chance to win
    $chances = [];
    for ($m = 0; $m < $playerEggPower; $m++) {
        array_push($chances, "You");
    }
    ///Computer chance to win
    for ($i = $playerEggPower + 1; $i < ($playerEggPower + $computerEggPower + 1); $i++) {
        array_push($chances, "PC");
    }

    $fightsLeft = 2;
    /// Fight
    while ($fightsLeft > 0) {
        $winnerRaffle = rand(0, count($chances) - 1);


        if ($fightsLeft === 2) {
            echo "Round 1" . PHP_EOL;
            sleep(1);
            echo "Boom!" . PHP_EOL;
            sleep(1);
            echo "Pow!" . PHP_EOL;
            sleep(1);
            echo "Crack..." . PHP_EOL;
            sleep(1);
            echo $firstWinner = $chances[$winnerRaffle];
            echo " won the first round!" . PHP_EOL;
;

        } else {
            echo "Round 2" . PHP_EOL;
            sleep(1);
            echo "Boom!" . PHP_EOL;
            sleep(1);
            echo "Pow!" . PHP_EOL;
            sleep(1);
            echo "Crack..." . PHP_EOL;
            sleep(1);
            echo $secondWinner = $chances[$winnerRaffle];
            echo " won the second round!" . PHP_EOL;

        }
        $fightsLeft--;
    }


    /////After game

    if ($firstWinner === "You" && $secondWinner === "You") {
        echo "You won the PC's egg!" . PHP_EOL;
        foreach ($computerEggs as $eggs) {

            if ($eggs->eggKey === $computerEggKey) {
                $eggs->eggAmount -= 1;
            }
        }
        foreach ($playerEggs as $eggs) {

            if ($eggs->eggKey === $computerEggKey) {
                $eggs->eggAmount += 1;
            }
        }

    } else if ($firstWinner === "PC" && $secondWinner === "PC") {
        echo "You lost your egg to PC!" . PHP_EOL;
        foreach ($playerEggs as $eggs) {

            if ($eggs->eggKey === $playerEggKey) {
                $eggs->eggAmount -= 1;
            }
        }
        foreach ($computerEggs as $eggs) {

            if ($eggs->eggKey === $computerEggKey) {
                $eggs->eggAmount += 1;
            }
        }
    } else {
        echo "It's a draw - you both lose your eggs!" . PHP_EOL;
        var_dump($firstWinner);
        var_dump($secondWinner);
        foreach ($playerEggs as $eggs) {

            if ($eggs->eggKey === $playerEggKey) {
                $eggs->eggAmount -= 1;
            }
        }
        foreach ($computerEggs as $eggs) {

            if ($eggs->eggKey === $computerEggKey) {
                $eggs->eggAmount -= 1;
            }
        }
    }


    ///Display player egg basket after fight
    echo PHP_EOL;
    echo "Your egg basket: " . PHP_EOL;
    foreach ($playerEggs as $eggs) {
        echo "$eggs->eggKey. $eggs->eggName($eggs->eggPower) x $eggs->eggAmount" . PHP_EOL;
    }
    echo PHP_EOL;

    echo "Computer egg basket: " . PHP_EOL;
    ///Display PC egg basket after fight
    foreach ($computerEggs as $eggs) {
        echo "$eggs->eggKey. $eggs->eggName($eggs->eggPower) x $eggs->eggAmount" . PHP_EOL;
    }

    /// check both baskets - if a player is out of eggs
    $playerNegativeEggAmount = 0;
    $computerNegativeEggAmount = 0;
    foreach ($playerEggs as $egg){
        if ($egg->eggAmount === 0){
            $playerNegativeEggAmount++;
        }
        if($playerNegativeEggAmount === count($playerEggs)){
            echo "You ran out of eggs. Computer WINS!" . PHP_EOL;
            exit;
        }
    }
    foreach ($computerEggs as $egg){
        if ($egg->eggAmount === 0){
            $computerNegativeEggAmount++;
        }
        if($computerNegativeEggAmount === count($computerEggs)){
            echo "Computer ran out of eggs. You WIN!" . PHP_EOL;
            exit;
        }
    }

}
