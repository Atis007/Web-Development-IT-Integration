<?php
declare(strict_types=1);
/*FELADAT 3
Írjon egy getNumbersFromArray nevű függvényt, amely szigorúan két paramétert fogad:
• int $parity – egy egész szám, amely lehet páros vagy páratlan,
• array $numbers – egy adatokból álló tömb.
A függvénynek egy tömböt kell visszaadnia.
Ha a $parity értéke páros szám, akkor a függvény a $numbers tömbből válogassa ki az összes
páros számot, és ezeket adja vissza új tömbként.
Ha a $parity értéke páratlan szám, akkor ugyanezt tegye meg, de a páratlan számokkal.
A függvény meghívása előtt írja ki a $numbers tömb elemeit.
A függvény meghívása után írja ki a visszakapott tömb elemeit.
A $numbers tömb különböző típusú adatokat tartalmazhat (nem csak egész számokat), ezért a
függvényben ellenőrizni kell, hogy az adott érték egész szám-e, az is_int() függvény segítségével.
Készítsen megfelelő PHPDoc-dokumentációt is a függvényhez.
Példa tömb:
$numbers = [1, 45, 67, 80.2, "vts", 50];
 */

/**
 * Visszaadja a paritásnak megfelelő egész számokat a tömbből.
 *
 * @param int $parity Páros vagy páratlan szám (páros -> páros elemeket ad vissza, páratlan -> páratlanokat).
 * @param array $numbers Tetszőleges adatokat tartalmazó tömb.
 * @return array Az összes integer, amely megfelel a kívánt paritásnak.
 */
function getNumbersFromArray(int $parity, array $numbers): array{
    $neededParity = $parity % 2;
    $sortedArray = [];
    foreach ($numbers as $number){
        if(is_int($number) && $number % 2 === $neededParity){
            $sortedArray[] = $number;
        }
    }
    return $sortedArray;
}

$array = [1, 45, 67, 80.2, "vts", 50];
echo "A tomb elemei fuggvenyhivas elott: ";
foreach ($array as $a){
    echo $a . " ";
}

//paratlan
/*echo "<br>";
$numbers = getNumbersFromArray(1, $array);
echo "A tomb elemei fuggvenyhivas utan: ";
foreach ($numbers as $number){
    echo $number . " ";
}*/

//paros
echo "<br>";
$numbers = getNumbersFromArray(2, $array);
echo "A tomb elemei fuggvenyhivas utan: ";
foreach ($numbers as $number){
    echo $number . " ";
}