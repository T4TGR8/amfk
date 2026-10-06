Telepítés: wp-content/plugins/hetvegi-kalandmento mappában elhelyezni a repo tartalmát vagy a beépített telepítőt használva.
Indítás: Plugin bekapcsolása, majd a hostnak megfelelően a beállítások oldal (/wp-admin/admin.php?page=hkm-settings) kitöltése az apival ahonnan a json érkezik (/wp-json/hetvegi-kalandmento/v1/programs). Ezután használható a shortcode a szerkesztőből.

A programs.json elérhető Wordpress api-n keresztül (/wp-json/hetvegi-kalandmento/v1/programs), én úgy gondoltam hogy mivel a shortcode php oldalon dolgozza fel az adatokat és nem volt igény frontenden a dinamukis frissítésre így, mint egy külső api-ként beköthető elem lett. Ebben a felállásban ez ugye nem a leggyorsabb megoldás de mint külső rendszer használatának szimulációjaként gondoltam.

Több idővel folytatás:
Hibás kapott adatok pontosabb vizsgálata
Fájl hivatkozások tisztítása
Class rendszerek helyes elvégzése, most az részesült előnyben hogy működjön az időn belül ezért nem feltétlen egységes, array helyett objektumként kezelve átláthatóbb és kontrollálhatóbb lenne a programok kezelése/normalizálása
Design elhelyezkedések finomítása

Feladattal töltött idő körülbelül 3 óra + a readme megírása

AI használat:
ChatGPT
Beállítások oldal elkészítése, egyszerű form  gyorsabb elkészítése
Programok template elkészítése, módosítás a frontend szűrési logika feltételeiben
Programok sorrendezése backend oldalon és annak üzleti logikája