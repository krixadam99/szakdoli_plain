<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Kongruenciák tulajdonságai
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Korábban már vettünk kongruenciákat. Azt mondtuk, hogy az a és b számok kongruensek m modulussal, amennyiben azonos maradékot adnak m-mel osztva.
            Azt is beláttuk, hogy (a, b <?="\u{2208}"?> <?="\u{2124}"?>)(m <?="\u{2208}"?> <?="\u{2124}"?><sup><?="\u{2265}"?>2</sup>):a <?="\u{2261}"?> b (mod m) <?="\u{2194}"?> a = b + m * k (k <?="\u{2208}"?> <?="\u{2124}"?>) <?="\u{2194}"?> m | a - b. Jöjjön a kongruenciák néhány tulajdonsága.
        </label>
    </div>
    <div class="definition">
        <ul class="definition_list">
            <li><label>(<?="\u{2200}"?> a <?="\u{2208}"?> <?="\u{2124}"?>)(<?="\u{2200}"?> m <?="\u{2208}"?> <?="\u{2124}"?><sup><?="\u{2265}"?>2</sup>): a <?="\u{2261}"?> a (mod m) (ugyanis: m | 0 = a - a) (reflexivitás);</label></li>
            <li><label>(<?="\u{2200}"?> a, b <?="\u{2208}"?> <?="\u{2124}"?>)(<?="\u{2200}"?> m <?="\u{2208}"?> <?="\u{2124}"?><sup><?="\u{2265}"?>2</sup>): a <?="\u{2261}"?> b (mod m) <?="\u{2194}"?> b <?="\u{2261}"?> a (mod m) (ugyanis: m | a - b <?="\u{2194}"?> m | b - a) (szimmetria);</label></li>
            <li><label>(<?="\u{2200}"?> a, b, c <?="\u{2208}"?> <?="\u{2124}"?>)(<?="\u{2200}"?> m <?="\u{2208}"?> <?="\u{2124}"?><sup><?="\u{2265}"?>2</sup>): a <?="\u{2261}"?> b (mod m) <?="\u{2227}"?> b <?="\u{2261}"?> c (mod m) <?="\u{2192}"?> a <?="\u{2261}"?> c (mod m) (ugyanis: (m | a - b <?="\u{2227}"?> m | b - c) <?="\u{2194}"?> (m * k + b = a (k <?="\u{2208}"?> <?="\u{2124}"?>) <?="\u{2227}"?> m * l + c = b (l <?="\u{2208}"?> <?="\u{2124}"?>)) <?="\u{2194}"?> (m * (k + l) = a - c) <?="\u{2194}"?> m | a - c) (tranzitivitás);</label></li>
            <li><label>(<?="\u{2200}"?> a, b, c <?="\u{2208}"?> <?="\u{2124}"?>)(<?="\u{2200}"?> m <?="\u{2208}"?> <?="\u{2124}"?><sup><?="\u{2265}"?>2</sup>): a <?="\u{2261}"?> b (mod m) <?="\u{2194}"?> a <?="\u{00B1}"?> c <?="\u{2261}"?> b <?="\u{00B1}"?> c (mod m) (ugyanis: m | a - b <?="\u{2194}"?> m | a <?="\u{00B1}"?> c - (b <?="\u{00B1}"?> c) = a <?="\u{00B1}"?> c - b <?="\u{2213}"?> c = a - b);</label></li>
            <li><label>(<?="\u{2200}"?> a, b, c <?="\u{2208}"?> <?="\u{2124}"?>)(<?="\u{2200}"?> m <?="\u{2208}"?> <?="\u{2124}"?><sup><?="\u{2265}"?>2</sup>): a <?="\u{2261}"?> b (mod m) <?="\u{2192}"?> a * c <?="\u{2261}"?> b * c (mod m) (ugyanis: m | a - b <?="\u{2192}"?> m | a * c - b * c = (a - b) * c);</label></li>
            <li><label>(<?="\u{2200}"?> a, b, c <?="\u{2208}"?> <?="\u{2124}"?>)(<?="\u{2200}"?> m <?="\u{2208}"?> <?="\u{2124}"?><sup><?="\u{2265}"?>2</sup>): a * c <?="\u{2261}"?> b * c (mod m) <?="\u{2192}"?> a <?="\u{2261}"?> b (mod m/gcd(m,c)).</label></li>
        </ul>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>
<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Lineáris kongruenciák megoldhatósága és lehetséges megoldása
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Adottak a, b <?="\u{2208}"?> <?="\u{2124}"?> és m <?="\u{2208}"?> <?="\u{2124}"?><sup><?="\u{2265}"?>2</sup> számok. Ekkor az a * x <?="\u{2261}"?> b (mod m) kongruenciát lineárisnak nevezzük.
            A feladat az, hogy megkeressük azokat az x számokat, amellyel igaz állítást kapunk, azaz a * x és b azonos maradékot ad m-mel osztva.
            Nem mindig lesz megoldható ez a feladat. Az ekvivalenciákat követve: a * x <?="\u{2261}"?> b (mod m) <?="\u{2194}"?> m | a * x - b <?="\u{2194}"?> a * x +  (-y) * m = b. Vegyük az a és m legnagyobb közös osztóját (jelöljük d-vel), ekkor az egyenlet a következő formát veszi fel: d * a<sub>d</sub> * x + d * m<sub>d</sub> * y = b. 
            A bal oldal osztható d-vel, így pedig a jobb oldalnak is oszthatónak kell lennie. Az a * x <?="\u{2261}"?> b (mod m) lineáris kongruencia pontosan akkor oldható meg, ha (a,m) | b.
            "Sima" kongruenciák esetén nincs ekvivalencia, például a (3,9) | 6, de 3 és 6 nem ad azonos maradékot 9-cel osztva. Ott ez szükséges, de nem elégséges feltétel.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Egy lehetséges megoldása az (a, b <?="\u{2208}"?> <?="\u{2124}"?> és m <?="\u{2208}"?> <?="\u{2124}"?><sup><?="\u{2265}"?>2</sup>): a * x <?="\u{2261}"?> b (mod m) lineáris kongruenciának:<br>
            1. lépés: ellenőrizzük, hogy (a, m) | b;<br>
            2. lépés: ha a = 0, akkor |m| | b, ekkor megállhatunk, x bármi lehet; <br>
            3. lépés: vesszük az a és b maradékát m-mel osztva;<br>
            4. lépés: amíg a b nem osztható az a-val:<br>
            4.1. lépés: b<sub>+</sub> := b;<br>
            4.2. lépés: b<sub>-</sub> := b;<br>
            4.3. lépés: amíg (a,b<sub>+</sub>) == 1 és (a,b<sub>-</sub>) == 1:<br>
            4.3.1. lépés: b<sub>+</sub> := b<sub>+</sub> + m;<br>
            4.3.2. lépés: b<sub>-</sub> := b<sub>-</sub> - m;<br>
            4.4. lépés: ha (a,b<sub>+</sub>) == 1, akkor b := b<sub>+</sub>, különben b := b<sub>-</sub><br>
            4.5. lépés: osztjuk a kongruenciát gcd(a, b)-vel;<br>
            5. lépés: osztjuk a kongruenciát gcd(a,b) = a -val.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>