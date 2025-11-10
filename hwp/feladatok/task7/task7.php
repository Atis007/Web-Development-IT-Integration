<?php
declare(strict_types=1);

/*
Készítsen egy getDropDownMenu függvényt a következő paraméterekkel: label, start, end,
name és default (ahol a default opcionális paraméter). A függvény szigorúan fogadja ezeket a
paramétereket. Készítsen PHPDoc-ot a függvényhez.
Ez a függvény legördülő listát generál.
Hívja meg ezt a függvényt háromszor:
1. A napok listájának generálásához (1-31).
2. A hónapok listájának generálásához (1-12).
3. Az évek listájának generálásához (1945-2021).
Ha a start paraméter nagyobb, mint az end paraméter, cserélje fel az értékeiket (azaz start lesz
az end, és end lesz a start).
*/

/**
 * Legördülő lista generálása adott tartományból.
 *
 * @param string $label   A dropdown felirata.
 * @param int    $start   Kezdőérték.
 * @param int    $end     Végérték.
 * @param string $name    A select name attribútuma.
 * @param int    $default Alapértelmezett kijelölt érték (opcionális).
 *
 * @return string HTML select elem.
 */
function getDropDownMenu(string $label, int $start, int $end, string $name, ?int $default = null): string
{
    if ($start > $end) {
        $temp = $start;
        $start = $end;
        $end = $temp;
    }

    $html = "<label>$label</label>";
    $html .= "<select name=\"$name\">";

    for ($i = $start; $i <= $end; $i++) {
        $selected = ($default !== null && $i === $default) ? "selected" : "";
        $html .= "<option value=\"$i\" $selected>$i</option>";
    }

    $html .= "</select>";

    return $html;
}

echo getDropDownMenu("Year: ", 1945, 2021, 'year');
echo getDropDownMenu("Month: ", 12, 1, 'month');
echo getDropDownMenu("Day: ", 1, 31, 'day');
