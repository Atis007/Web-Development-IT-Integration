<?php
declare(strict_types=1);
/*FELADAT 2
Készítsen egy PHP szkriptet, amely a következő sorral kezdődik:
declare(strict_types=1);
Ez a beállítás lehetővé teszi az adatok típusainak szigorú ellenőrzését.
A szkriptben három függvényt kell definiálni, amelyek egész számokat tartalmazó tömbökkel
dolgoznak. Minden függvényhez pontosan meg kell adni a paraméterek és a visszatérési érték
típusát, valamint egy PHPDoc megjegyzést, amely leírja, mit csinál a függvény, milyen
paramétereket kap, és milyen értéket ad vissza.
Az első függvény neve legyen getMinValue(), és a tömb legkisebb értékét keresse meg, majd
térjen vissza ezzel az értékkel (int).
A második függvény neve legyen getMaxValue(), és a tömb legnagyobb értékét keresse meg,
majd térjen vissza ezzel az értékkel (int).
A harmadik függvény neve legyen getSumAndAverage(), amely kiszámítja a tömb elemeinek
összegét és azok számtani átlagát, majd az eredményt formázott szövegként adja vissza,
például:
„Sum = 40, Average = 8”.
A függvények definiálása után:
1. Hozzon létre egy példatömböt számokkal,
2. Hívja meg mindhárom függvényt,
3. Jelenítse meg az eredményeket a képernyőn echo segítségével.
Használjon kizárólag beépített PHP függvényeket, például:
min(), max(), array_sum(), count() és hasonlókat.
Referenciák:
https://www.php.net/manual/en/function.min.php
https://www.php.net/manual/en/function.max.php
https://www.php.net/manual/en/function.array-sum.php
https://www.php.net/manual/en/function.count.php*/

function getMinValue(array $array): int {
    return (int)min($array);
}
function getMaxValue(array $array): int {
    return (int)max($array);
}
function getSumAndAverage(array $array): string{
    $sum = array_sum($array);
    $average = count($array) > 0 ? array_sum($array)/count($array) : 0;

    return "Sum = $sum Average = $average";
}

print('Numbers in the array: ');
for($i=0;$i<6;$i++){
    $array[$i]=rand(5,30);
    print($array[$i] . ',');
}
echo "<br>";
print('Min value is: ');
$function_var = 'getMinValue';
echo $function_var($array);

echo "<br>";

print('Max value is: ');
$function_var = 'getMaxValue';
echo $function_var($array);

echo "<br>";

$function_var = 'getSumAndAverage';
echo $function_var($array);
