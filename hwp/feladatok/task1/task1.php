<?php
/*
 FELADAT 1
Írjon egy PHP programot, amely három függvényt tartalmaz:
• hello() – kiírja az üzenetet: „Hello from VTŠ!”
• goodbye() – kiírja az üzenetet: „Goodbye from VTŠ!”
• info($name, $year) – egy Heredoc formátumú sztringet ad vissza, amely megjeleníti a nevet és
a tanulmányi évet.
A program fő részében:
1. Hozzon létre egy $var változót, amelynek értéke egy függvény neve (pl. „hello” vagy
„goodbye”).
2. Hívja meg a függvényt dinamikusan a $var() segítségével.
3. Hozzon létre egy új sztringet Nowdoc szintaxis segítségével, amely PHP kódot tartalmaz
szövegként (változók értelmezése nélkül).
4. Végül hívja meg az info() függvényt, és írja ki az eredményt Heredoc formátumban.
 */

function hello(){
    print("Hello from VTS!");
}
function goodbye(){
    print("Goodbye from VTS!");
}

function info($name, $year){
    $text= <<<INFO
<div>
Name: {$name}
Year: {$year}
</div>
INFO;

    echo $text;

}

$function_var = 'hello';
$function_var();

echo "<br>";

$function_var = 'goodbye';
$function_var();

echo "<br>";

$function_var = 'info';
$function_var('Attila', 3);