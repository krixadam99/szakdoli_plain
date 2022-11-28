<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Diofantikus egyenlet megoldása
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Adottak az a, b, c <?="\u{2208}"?> <?="\u{2124}"?> számok. Az a * x + b * y = c egyenletet lineáris diofantikus egyenletnek nevezzük. A feladat az, hogy megkeressük ennek az összes megoldását.
            Ez az egyenlet pontosan akkor oldható meg, ha (a,b) | c.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            (a, b, c <?="\u{2208}"?> <?="\u{2124}"?>): a * x + b * y = c I. lehetséges megoldása:<br>
            1. lépés: ellenőrizzük, hogy (a,b) | c;<br>
            2. lépés: átalakítás: a * x - c = b * y <?="\u{2194}"?> b | a * x - c <?="\u{2194}"?> a * x <?="\u{2261}"?> c (mod b);<br>
            3. lépés: az a * x <?="\u{2261}"?> c (mod b) lineáris kongruencia megoldása;<br>
            4. lépés: y = (c - a * x) / b egyenletben az x behelyettesítése.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            (a, b, c <?="\u{2208}"?> <?="\u{2124}"?>): a * x + b * y = c II. lehetséges megoldása:<br>
            1. lépés: ellenőrizzük, hogy (a,b) | c;<br>
            2. lépés: meghatározni egy x<sub>0</sub> és y<sub>0</sub> alapmegoldást;<br>
            2.1. lépés: kibővített euklideszi algoritmussal határozzuk meg a megoldását a gcd(a,b) = a * x<sub>a</sub> + b * y<sub>b</sub> (x<sub>a</sub>, y<sub>b</sub> <?="\u{2208}"?> <?="\u{2124}"?>);<br>
            2.2. lépés: szorozzuk be mind a két oldalt (c/gcd(a,b))-val, így c = a * x<sub>a</sub> * (c/gcd(a,b)) + b * y<sub>b</sub> * (c/gcd(a,b)) (x<sub>a</sub>, y<sub>b</sub> <?="\u{2208}"?> <?="\u{2124}"?>);<br>
            2.3. lépés: az alap megoldások így: x<sub>0</sub> = x<sub>a</sub> * (c/gcd(a,b)) és y<sub>0</sub> = y<sub>b</sub> * (c/gcd(a,b));<br>
            3. lépés: behelyettesítés az x = x<sub>0</sub> + k * (b/gcd(a,b)) és y = y<sub>0</sub> - k * (a/gcd(a,b)) egyenletekbe, ahol a k egy tetszőleges egész szám, ami közös a két egyenletben.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>