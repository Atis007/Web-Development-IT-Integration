# Dokumentáció

## A feladat és az alkalmazott technológiák leírása
Az alkalmazás egy Levenshtein-algoritmusra épülő szókereső, amely egy felhasználó által megadott kifejezéshez keres legközelebbi szót a bonuszwords szólistában. A feladat célja, hogy bemutassa, miként lehet PHP (8.4) és MySQL alapokon nagy elemszámú szótárban gyors hasonlóság-keresést megvalósítani, opcionális hosszkorlátozással. A backend komponensek tiszta PHP-ban, PDO-val és Faker-rel készültek, a frontend pedig Bootstrap 5.3 CDN-re és egyedi dark témájú CSS-re támaszkodik.

## Az adatbázis szerkezetének és a főbb SQL lekérdezések ismertetése
Három fő tábla létezik:
- `bonuszwords (id_word, word, date_time_added)`: az alap szólista.
- `bonuszwords_indexed (id_word, word, date_time_added, word_length)`: a hossz szerint indexelt tükörtábla, amely `word_length` mezőt tartalmaz a gyorsabb szűréshez.
- `bonuszresults (id_result, id_word, input, distance, date_time, runtime_ms, length_constraint)`: a keresések naplója, ahol a `length_constraint` jelzi, hogy volt-e hosszszűrés. Ezáltal tudjuk melyik adatbázis volt használva.

A főbb lekérdezések:
- `SELECT id_word, word FROM bonuszwords` – teljes szótár beolvasása, amikor nincs hosszkorlát.
- `SELECT id_word, word FROM bonuszwords_indexed WHERE word_length BETWEEN :min AND :max` – szűrt beolvasás a gyorsított táblából.
- `INSERT IGNORE INTO bonuszwords (word) VALUES (:word)` és ennek indexelt párja – a Fakerből származó vagy a `words/20k.txt` fájlból importált szavak feltöltése.
- `INSERT INTO bonuszresults (...) VALUES (...)` – a futtatások naplózása, amely későbbi elemzéshez szolgál.

## Teljesítményelemzés az optimalizálás előtt és után
A `bonuszresults.sql` dump alapján jól látszik, hogy hosszszűrés nélkül (például `id_result=1`, `runtime_ms≈356 ms`) a teljes táblát kellett végigolvasni. Amikor bekapcsoltuk a `use_length` opciót, ugyanazon bemenet (`usergroupsuserg`) esetén a futásidő 0.72–0.82 ms tartományra csökkent, mert a lekérdezés már a `bonuszwords_indexed` táblát használta. A `thee` bemenetre mért 630 ms → 110 ms javulás is megmutatja, hogy a hossz szerinti előszűrés nagyságrendi gyorsulást eredményez. Az optimalizálás tehát a keresési tér leszűkítésével és az indexelt tábla használatával érte el a célját.

## A kód felépítésének és működésének magyarázata
- `index.php` jelenít meg egy Bootstrap alapú űrlapot, ahol megadható a keresett szó és opcionálisan a min/max hossz.
- `check.php` ellenőrzi a bemenetet, dönti el, hogy szükséges-e a hosszszűrés, majd meghívja a `levenshteinDistance()` függvényt, végül táblázatban mutatja az eredményt és naplózza azt.
- `includes/functions.php` tartalmazza az adatbázis-kapcsolatot, a szólisták beolvasását, a Levenshtein-számítást, valamint az eredmények mentését. A futásidőt `microtime(true)` alapú mérés rögzíti.
- `generate_words.php` opcionálisan betölti a `words/20k.txt` állományt a `bonuszwords` táblába, Fakerrel generált operátorokkal variálva.
- A `style.css` biztosítja az egységes, fekete hátteres, fehér betűs megjelenést, míg a `header.php` és `footer.php` a közös HTML keretet adják.

## Következtetések és továbbfejlesztési javaslatok
A projekt igazolta, hogy a Levenshtein-távolság számítása hatékonyan gyorsítható adatbázis-szintű előszűréssel és jól megválasztott indexekkel. További fejlesztési lehetőségek:
1. A `bonuszwords_indexed` táblára összetett index (`word_length`, `word`) és partícionálás bevezetése, ha még nagyobb adatállománnyal dolgozunk.
2. A felületre eredmény-halmaz (top N legközelebbi találat) és grafikus teljesítménymérő diagram, hogy a felhasználó is lássa a hosszszűrés hatását.
3. REST API endpoint készítése, így más rendszerek is igénybe tudják venni a szolgáltatást.
4. Háttérfeladat a szólista rendszeres frissítésére és normalizálására (kisbetűsítés, diakritikus jelek kezelése).