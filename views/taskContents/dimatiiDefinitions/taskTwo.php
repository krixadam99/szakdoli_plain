<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Teljes és redukált maradékrendszerek
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Legyen <?="\u{2124}"?> <?="\u{220B}"?> n <?="\u{2265}"?> 2. Ekkor definiáljuk a ~ relációt a következő képpen: ~ <?="\u{2286}"?> <?="\u{2124}"?> <?="\u{00D7}"?> <?="\u{2124}"?>, ~ := { (a, b) <?="\u{2208}"?> <?="\u{2124}"?> <?="\u{00D7}"?> <?="\u{2124}"?> | n | a - b}, azaz pontosan akkor van (a, b) rendezett pár benne a ~ relációban, ha azonos maradékot adnak n-nel osztva (azaz kongruensek modulo n).
            Ez a reláció ekvivalencia reláció (ezt a kongruenciák tulajdonságainál (4. téma) látjuk be), így meghatározhatunk egy osztályozást. 
            Jelöljük a <span style="text-decoration: overline">a</span>-val azt a halmazt, amely azokat az elemeket tartalmazza, melyek n-nel osztva a maradékot adnak, azaz <span style="text-decoration: overline">a</span> = { b <?="\u{2208}"?> <?="\u{2124}"?> | n | a - b} = { ..., a - n, a, a + n, ...} = a + n * <?="\u{2124}"?> (az n * <?="\u{2124}"?> helyett használható az n * k (k <?="\u{2208}"?> <?="\u{2124}"?> jelölés is)). Ezt <b>maradékosztálynak</b> nevezzük.
            Ekkor egy osztályozást határoz meg az egész számokon a következő szuperhalmaz: { { n-nel osztva 0 maradékot adó egészek}, ..., { n-nel osztva n-1 maradékot adó egészek} } = { <span style="text-decoration: overline">0</span>, ..., <span style="text-decoration: overline">n-1</span> }. Ezt a <?="\u{2124}"?>/<sub>n</sub><?="\u{2124}"?>-nel jelöljük és <b>teljes maradékrendszernek</b> nevezzük.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">  
            Legyen <span style="text-decoration: overline">a</span>, <span style="text-decoration: overline">b</span> <?="\u{2208}"?> <?="\u{2124}"?>/<sub>n</sub><?="\u{2124}"?>, ekkor <span style="text-decoration: overline">a</span> <?="\u{00B1}"?> <span style="text-decoration: overline">b</span> = <span style="text-decoration: overline">a <?="\u{00B1}"?> b</span> és <span style="text-decoration: overline">a</span> * <span style="text-decoration: overline">b</span> = <span style="text-decoration: overline">a * b</span>.
            Megjegyzendő, hogy a bal oldali szorzás és hozzáadás művelete nem azonos a jobb oldalival, hiszen az előbbi két halmaz között lett elvégezve (értelemszerűen az első halmaz minden eleméhez hozzáadjuk / megszorozzuk a második halmaz minden elemét/elemével), az utóbbi két egész között lesz végrehajtva. Az itt bevezetett (bal oldali) szorzás és hozzáadás műveletek kommutatívak, asszociatívak, diszrtibutívak, zártak és van neutrális elemük (előbbinél <span style="text-decoration: overline">1</span>, utóbbinál <span style="text-decoration: overline">0</span>). 
            Viszont míg a hozzáadás esetén van minden elemnek inverzeleme, addig ez a szorzásra már nem igaz (pl.: <span style="text-decoration: overline">0</span>). Ezért lesz szükségünk majd a redukált maradékrendszer fogalmának bevezetésére.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Legyen <?="\u{2124}"?> <?="\u{220B}"?> n <?="\u{2265}"?> 2. A (<?="\u{2124}"?>/<sub>n</sub><?="\u{2124}"?>)<sup>*</sup> = { <span style="text-decoration: overline">a</span> <?="\u{2208}"?> <?="\u{2124}"?>/<sub>n</sub><?="\u{2124}"?> | <?="\u{2203}"?> <span style="text-decoration: overline">b</span> <?="\u{2208}"?> <?="\u{2124}"?>/<sub>n</sub><?="\u{2124}"?>: <span style="text-decoration: overline">a</span> * <span style="text-decoration: overline">b</span> = <span style="text-decoration: overline">1</span> }. Ezt <b>redukált maradékrendszernek</b> nevezzük.
            Ebben azok a maradékosztályok vannak benne, amelyeknek van inverz elemük a szorzásra nézve.
            Belátható, hogy (<?="\u{2124}"?>/<sub>n</sub><?="\u{2124}"?>)<sup>*</sup> = { <span style="text-decoration: overline">a</span> <?="\u{2208}"?> <?="\u{2124}"?>/<sub>n</sub><?="\u{2124}"?> | gcd(a,n) = 1 }, azaz azok a maradékosztályok vannak benne, amelyeknek az elemei relatív prímek n-hez, azaz nincsen az egységen kívül más közös osztójuk n-nel.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>
<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Euler- féle <?="\u{03C6}"?> függvény és redukált maradékrendszerek mérete
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Az Euler- féle <?="\u{03C6}"?> függvény megadja egy pozitív egész szám esetén, hogy hány darab pozitív, hozzá relatív prím létezik, azaz, hány olyan pozitív szám van, amelynek az egységen kívül nincsen már közös osztója a számmal.
            Ez a <?="\u{2124}"?> <?="\u{220B}"?> p prím esetén p - 1 (különben nem lenne prím). Az 1-hez a függvény 1-et rendel.
            Ha az <?="\u{2124}"?> <?="\u{220B}"?> a = p<sup><?="\u{03B1}"?></sup> alakú, ahol p prím és alfa pedig nemnegatív egész, akkor bebizonyítható, hogy <b><?="\u{03C6}"?>(a)</b> = a - p<sup><?="\u{03B1}"?> - 1</sup> = <b>p<sup><?="\u{03B1}"?> - 1</sup> * (p - 1)</b>.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Az is bebizonyítható, hogy ez a függvény multiplikatív, azaz <?="\u{03C6}"?>(a * b) = <?="\u{03C6}"?>(a) * <?="\u{03C6}"?>(b) (a, b <?="\u{2208}"?> <?="\u{2124}"?>).
            Végül az <?="\u{2124}"?><sup>>1</sup> <?="\u{220B}"?> a = <?="\u{220F}"?><sup>m</sup><sub>i=1</sub>p<sub>i</sub><sup><?="\u{03B1}"?><sub>i</sub></sup> (m <?="\u{2265}"?> 1, (i <?="\u{2208}"?> {1,...,m} <?="\u{2282}"?> <?="\u{2115}"?>): <?="\u{2124}"?><sup>+</sup> <?="\u{220B}"?> p<sub>i</sub> páronként különböző prím <?="\u{2227}"?> <?="\u{03B1}"?><sub>i</sub> <?="\u{2265}"?> 0 (a prímszám előfordulása a prímfelbontásban)) kanonikus alak alapján már bármely összetett számra meghatározható a pozitív, hozzá relatív prímek száma.
            <b><?="\u{03C6}"?>(a)
            = <?="\u{03C6}"?>(<?="\u{220F}"?><sup>m</sup><sub>i=1</sub>p<sub>i</sub><sup><?="\u{03B1}"?><sub>i</sub></sup>)
            = <?="\u{220F}"?><sup>m</sup><sub>i=1</sub><?="\u{03C6}"?>(p<sub>i</sub><sup><?="\u{03B1}"?><sub>i</sub></sup>)
            = <?="\u{220F}"?><sup>m</sup><sub>i=1</sub>(p<sub>i</sub><sup><?="\u{03B1}"?><sub>i</sub> - 1</sup> * (p<sub>i</sub> - 1))</b>.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Korábbi tétel szerint (<?="\u{2124}"?>/<sub>n</sub><?="\u{2124}"?>)<sup>*</sup> = { <span style="text-decoration: overline">a</span> <?="\u{2208}"?> <?="\u{2124}"?>/<sub>n</sub><?="\u{2124}"?> | gcd(a,n) = 1 }, vagyis ahhoz, hogy megkapjuk a |(<?="\u{2124}"?>/<sub>n</sub><?="\u{2124}"?>)<sup>*</sup>|-et elég meghatározni a <?="\u{03C6}"?>(n)-et.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>