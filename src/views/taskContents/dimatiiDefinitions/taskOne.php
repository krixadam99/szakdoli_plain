<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Osztás egészek körében maradék nélkül
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Adottak a, b <?="\u{2208}"?> <?="\u{2124}"?> számok. Azt mondjuk, hogy az <b>a szám osztható b-vel</b>, vagy <b>b osztója a-nak</b>, vagy <b>b osztja az a</b>-t, ha létezik olyan <b>c <?="\u{2208}"?> <?="\u{2124}"?></b> szám, hogy <b>b * c = a</b> (a többszöröse b-nek). 
            Ha a osztható b-vel, akkor erre a <i>b</i> | <i>a</i> jelölést használjuk
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Oszthatóság tulajdonságai (ezek könnyen beláthatók az előbbi definíció felhasználásával):
        </label>
        <ul class="definition_list">
            <li><label>(<?="\u{2200}"?> a <?="\u{2208}"?> <?="\u{2124}"?>): a | a (reflexivitás); </label></li>
            <li><label>(<?="\u{2200}"?> a, b <?="\u{2208}"?> <?="\u{2124}"?>): a | b <?="\u{2227}"?> b | a <?="\u{2194}"?> a = <?="\u{00B1}"?> b; </label></li>
            <li><label>(<?="\u{2200}"?> a, b, c <?="\u{2208}"?> <?="\u{2124}"?>): a | b <?="\u{2227}"?> b | c <?="\u{2194}"?> a | c (tranzitivitás); </label></li>
            <li><label>(<?="\u{2200}"?> a, b, c <?="\u{2208}"?> <?="\u{2124}"?>): a | b <?="\u{2227}"?> a | c <?="\u{2194}"?> a | b <?="\u{00B1}"?> c; </label></li>
            <li><label>(<?="\u{2200}"?> a, b, c <?="\u{2208}"?> <?="\u{2124}"?>): a | b <?="\u{2227}"?> a | b <?="\u{00B1}"?> c <?="\u{2192}"?> a | c; </label></li>
            <li><label>(<?="\u{2200}"?> a, b, c <?="\u{2208}"?> <?="\u{2124}"?>): a | b <?="\u{2227}"?> c | d <?="\u{2192}"?> a * c | b * d; </label></li>
            <li><label>(<?="\u{2200}"?> a, b, c <?="\u{2208}"?> <?="\u{2124}"?>): a | b <?="\u{2192}"?> a | b * c. </label></li>
        </ul>
    </div>
    <div class="definition">
        <label class="definition_label">
            Keressük meg azokat a számokat, amelyek osztják a 0, azaz olyan <i>a</i> egészeket, amelyekre teljesül, hogy (c <?="\u{2208}"?> <?="\u{2124}"?>): a * c = 0. Természetesen bármely a egész esetén ott van a 0, mint egész, amellyel az egészet megszorozva 0-t kapjunk, vagyis <b>minden egész szám osztója a 0-nak</b>.
            Most keressük meg azokat a számokat, amelyeknek osztója a 0, azaz olyan <i>a</i> egészeket, amelyekre teljesül, hogy (c <?="\u{2208}"?> <?="\u{2124}"?>): 0 * c = a. Itt a bal oldal mindig 0, így csak az a = 0 esetén kapunk egyenlőséget, vagyis <b>a 0 csak a 0-nak osztója</b>.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Keressük meg azokat a számokat, amelyek osztják az 1-gyet, azaz olyan <i>a</i> egészeket, amelyekre teljesül, hogy (c <?="\u{2208}"?> <?="\u{2124}"?>): a * c = 1. Látható, hogy ekkor az egészek körében csak az 1 és -1 esetén lesz ilyen c egész szám. Tehát <b>csak <?="\u{00B1}"?> 1 osztója az 1-nek</b>.
            Most keressük meg azokat a számokat, amelyeknek osztója a <?="\u{00B1}"?>1, azaz olyan <i>a</i> egészeket, amelyekre teljesül, hogy (c <?="\u{2208}"?> <?="\u{2124}"?>): <?="\u{00B1}"?>1 * c = a. Ha c = a, akkor mindig teljesül az egyenlőség, tehát <b>bármely számnak osztója a <?="\u{00B1}"?>1</b>.
            <b>Az egység egy olyan szám, amely bármely másik számnak osztója.</b> Ezért a <?="\u{00B1}"?>1-et egységnek nevezzük. Egészek körében csak ezek az egységek (ugyanis 1-nél nagyobb <i>a</i> egészek estén nincsen olyan <i>c</i> egész szám, hogy azzal megszorozva <i>a</i>-t pl.: 1-et kapjunk).
            <b>Két számot egymás asszociáltjának nevezzük, ha egymás egységszorosai.</b>
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            A p <?="\u{2208}"?> <?="\u{2124}"?> számot <b>prím</b>nek (vagy törzsszámnak) nevezzük amennyiben teljesül rá, hogy <b>p = a * b  <?="\u{2192}"?> p = a  <?="\u{2228}"?> p = b (a, b <?="\u{2208}"?> <?="\u{2124}"?>)</b>.
            <b>A felbonthatatlan (irreducibilis) szám olyan szám, amelynek az egység(ek)en és az asszociáltakon kívül nincsen más osztója.</b> 
            Egészek körében az is igaz, hogy a prímszámoknak nincsen az egységeken és asszociáltjukon kívül más osztójuk, így felbonthatatlan számok.
            A 0-nak végtelen sok osztója van, a <?="\u{00B1}"?>1-nek pedig csak az asszociáltjaik. Összetett számnak nevezzük az olyan egész számokat, amelyek nem prímszámok, nem az egységek és nem 0. 
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>
<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Maradékos osztás egészek körében
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Adottak az a, b <?="\u{2208}"?> <?="\u{2124}"?> számok. A feladat az, hogy osszuk el az a-t maradékosan a b-vel az egészek körében.
            Ekkor egyértelműen tudunk adni olyan q és r számokat, hogy <b>a = q * b + r ((r <?="\u{2208}"?> <?="\u{2124}"?>): 0 <?="\u{2264}"?> r < |b| <?="\u{2227}"?> q <?="\u{2208}"?> <?="\u{2124}"?>)</b>.
            A q a kvóciens (hányados), az r a maradék.
            Ha az <b>r = 0</b>, akkor visszakapjuk a maradék nélküli osztás képletét, ekkor <b>b | a</b>.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Adottak a, b <?="\u{2208}"?> <?="\u{2124}"?> és m <?="\u{2208}"?> <?="\u{2124}"?><sup><?="\u{2265}"?>2</sup>. Azt mondjuk, hogy az a és b szám kongruens egymással m modulusra, ha ugyanazt a maradékot adják az m-mel való maradékos osztás során.
            Ezt <i> a <?="\u{2263}"?> b (mod m)</i> fogjuk jelölni. Legyen a és b kongruens m-mel osztva.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Adottak a, b <?="\u{2208}"?> <?="\u{2124}"?> és m <?="\u{2208}"?> <?="\u{2124}"?><sup><?="\u{2265}"?>2</sup>.
            Legyen a és b kongruens m-mel osztva. Ekkor korábbi definíciónk szerint a = q<sub>a</sub> * m + r és b = q<sub>b</sub> * m + r.
            Vegyük a két egyenlet különbségét, azaz a - b = q<sub>a</sub> * m + r - q<sub>b</sub> * m - r = (q<sub>a</sub> - q<sub>b</sub>) * m. 
            Mivel a q<sub>a</sub> és q<sub>b</sub> egészek, így a különbségük is az, ezért létezik olyan egész, amellyel m-et megszorozva a - b-t kapunk, azaz m | a - b.
            Röviden: <b>a <?="\u{2263}"?> b (mod m) <?="\u{2194}"?> a = b + m * k (k <?="\u{2208}"?> <?="\u{2124}"?>) <?="\u{2194}"?>  m | a - b</b>.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>
<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Kanonikus alak, osztók száma és prímfelbontás
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Számelmélet alaptétele: bármely nem-nulla, nem egység egész szám felbontható prímszámok szorzatára, ahol a sorrendtől, az egységektől, valamint az asszociáltaktól eltekintve a felbontás egyértelmű (létezés és egyértelműség).
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Legyen a <?="\u{2208}"?> <?="\u{2124}"?> \ {-1, 0, 1}, ekkor az előző szerint a = <?="\u{220F}"?><sup>m</sup><sub>i=1</sub>p<sub>i</sub><sup><?="\u{03B1}"?><sub>i</sub></sup> (m <?="\u{2265}"?> 1, (i <?="\u{2208}"?> {1,...,m} <?="\u{2282}"?> <?="\u{2115}"?>): <?="\u{2124}"?><sup>+</sup> <?="\u{220B}"?> p<sub>i</sub> páronként különböző prím <?="\u{2227}"?> <?="\u{03B1}"?><sub>i</sub> <?="\u{2265}"?> 0 (a prímszám előfordulása a prímfelbontásban)). Ezt nevezzük az a szám <b>kanonikus felbontásának</b>.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Legyen a <?="\u{2208}"?> <?="\u{2124}"?> \ {-1, 0, 1}. Előbbi szerint: a = <?="\u{220F}"?><sup>m</sup><sub>i=1</sub>p<sub>i</sub><sup><?="\u{03B1}"?><sub>i</sub></sup> (m <?="\u{2265}"?> 1, (i <?="\u{2208}"?> {1,...,m} <?="\u{2282}"?> <?="\u{2115}"?>): <?="\u{2124}"?><sup>+</sup> <?="\u{220B}"?> p<sub>i</sub> páronként különböző prím <?="\u{2227}"?> <?="\u{03B1}"?><sub>i</sub> <?="\u{2265}"?> 0 (a prímszám előfordulása a prímfelbontásban)).
            Ekkor az a szám pozitív osztóinak számát egy egyszerű variációval megkapjuk. A kanonikus alakban lévő kitevőket változtatva, különböző osztókat kapunk meg. Ezeken túl pedig más osztó nem lehetséges, mivel a prímfelbontás egyértelmű. Így pedig az <b>összes pozitív osztó száma: d(a) =  <?="\u{220F}"?><sup>m</sup><sub>i=1</sub>(<?="\u{03B1}"?><sub>i</sub> + 1)</b> (ahol <?="\u{03B1}"?><sub>i</sub> <?="\u{2265}"?> 0 (a prímszám előfordulása a prímfelbontásban).
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>