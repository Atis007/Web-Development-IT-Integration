Az index.php oldalon található textarea-ba beírt szöveget átadja a form a process.phpnek, az fogadja,
a fogadott szöveget a functions.php fileból meghívott processText feldologozza a feladatnak megfelelően, majd visszaadja tömbként
az eredeti- és módosított szöveget, valamint a módosított szöveg hosszát. 
A process.php-ben meghívott insertData elmenti ezeket az adatbázisba.
A getData function visszatérő értékét elmentem a $data változóba, majd foreach-csel végigmegyek az adatokon es egy table-ben megjelenítem őket,
a legutolsó időponttal kezdve. 