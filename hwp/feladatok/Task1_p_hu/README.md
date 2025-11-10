Fájlok és működés:

config.php
- PDO adatbázis kapcsolat beállításai
- getPDO() függvény visszaad egy PDO objektumot

functions.php
- generateSentence(): véletlen mondat generálása
- generateText(): 1–3 mondatos szöveg generálása
- generateRandomDate(): véletlen dátum generálása az elmúlt 30 napból
- insertText(): beszúr egy új rekordot a text_data táblába
- searchWords(): LIKE operátorral keres minden szóra, visszaadja a találatok id-jait (duplikátum nélkül, rendezve)

index.php
- űrlapot megjeleníti
- POST-tal küldi a keresés tartalmát a search.php-nek
- van Submit és Reset gomb

generate.php
- 250 véletlenszerű text_data rekordot hoz létre és beszúrja az adatbázisba

search.php
- fogadja a POST adatot
- eltávolítja a felesleges szóközöket
- felosztja szavakra
- LIKE keresést végez minden szóra
- összegyűjti az id_text_data értékeket
- duplikátum nélkül növekvő sorrendbe rendezi
- results mentése a search táblába
- megjeleníti a találatokat

Adatbázis struktúra:
- text_data(id_text_data, text, date_time)
- search(id_search, search_content, results)

