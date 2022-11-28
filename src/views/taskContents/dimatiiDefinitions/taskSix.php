<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Kínai maradéktétel
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Legyen n, m <?="\u{2264}"?> 2 egészek úgy, hogy gcd(n,m) = 1. Ekkor az f: <?="\u{2124}"?>/<sub>n*m</sub><?="\u{2124}"?> <?="\u{2192}"?> <?="\u{2124}"?>/<sub>n</sub><?="\u{2124}"?> <?="\u{00D7}"?> <?="\u{2124}"?>/<sub>m</sub><?="\u{2124}"?>, 
            f(<span style="text-decoration: overline">a</span>) = (<span style="text-decoration: overline">a</span>,<span style="text-decoration: overline">a</span>) egy bijektív függvény.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Egyértelműség:<br>
            Tegyük fel, hogy (<span style="text-decoration: overline">a</span>, <span style="text-decoration: overline">b</span> <?="\u{2208}"?> <?="\u{2124}"?>/<sub>n*m</sub><?="\u{2124}"?>): f(<span style="text-decoration: overline">a</span>) = (<span style="text-decoration: overline">a</span><sub>1</sub>,<span style="text-decoration: overline">a</span><sub>2</sub>) <?="\u{2260}"?> (<span style="text-decoration: overline">b</span><sub>1</sub>,<span style="text-decoration: overline">b</span><sub>2</sub>) = f(<span style="text-decoration: overline">b</span>), hogy <span style="text-decoration: overline">a</span> = <span style="text-decoration: overline">b</span> <?="\u{2124}"?>/<sub>n*m</sub><?="\u{2124}"?>-ban.
            <span style="text-decoration: overline">a</span> = <span style="text-decoration: overline">b</span> <?="\u{2208}"?> <?="\u{2124}"?>/<sub>n*m</sub><?="\u{2124}"?>-ban <?="\u{2194}"?> n * m | a - b <?="\u{2194}"?> n * m * k + b = a (k <?="\u{2208}"?> <?="\u{2124}"?>). 
            Ezt behelyettesítve az (<span style="text-decoration: overline">a</span><sub>2</sub>,<span style="text-decoration: overline">a</span><sub>2</sub>)-ba: <span style="text-decoration: overline">n * m * k + b</span> <?="\u{2208}"?> <?="\u{2124}"?>/<sub>n</sub><?="\u{2124}"?> és 
            <span style="text-decoration: overline">n * m * k + b</span> <?="\u{2208}"?> <?="\u{2124}"?>/<sub>m</sub><?="\u{2124}"?>. Mind a két esetben kiesik az n * m * k tag, így valójában <span style="text-decoration: overline">n * m * k + b</span> = <span style="text-decoration: overline">b</span> <?="\u{2208}"?> <?="\u{2124}"?>/<sub>n</sub><?="\u{2124}"?> és
            <span style="text-decoration: overline">n * m * k + b</span> = <span style="text-decoration: overline">b</span> <?="\u{2208}"?> <?="\u{2124}"?>/<sub>m</sub><?="\u{2124}"?>, azaz (<span style="text-decoration: overline">a</span><sub>1</sub>,<span style="text-decoration: overline">a</span><sub>2</sub>) = (<span style="text-decoration: overline">b</span><sub>1</sub>,<span style="text-decoration: overline">b</span><sub>2</sub>).
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Injektivitás:
            Tegyük fel, hogy (<span style="text-decoration: overline">a</span>, <span style="text-decoration: overline">b</span> <?="\u{2208}"?> <?="\u{2124}"?>/<sub>n*m</sub><?="\u{2124}"?>): f(<span style="text-decoration: overline">a</span>) = (<span style="text-decoration: overline">a</span><sub>1</sub>,<span style="text-decoration: overline">a</span><sub>2</sub>) = f(<span style="text-decoration: overline">b</span>), hogy <span style="text-decoration: overline">a</span> <?="\u{2260}"?> <span style="text-decoration: overline">b</span> <?="\u{2124}"?>/<sub>n*m</sub><?="\u{2124}"?>-ban.
            <span style="text-decoration: overline">a</span> = <span style="text-decoration: overline">b</span> <?="\u{2208}"?> <?="\u{2124}"?>/<sub>m</sub><?="\u{2124}"?> <?="\u{2194}"?> m | a - b <?="\u{2194}"?> m * k = a - b (k <?="\u{2208}"?> <?="\u{2124}"?>) és
            <span style="text-decoration: overline">a</span> = <span style="text-decoration: overline">b</span> <?="\u{2208}"?> <?="\u{2124}"?>/<sub>n</sub><?="\u{2124}"?> <?="\u{2194}"?> n | a - b <?="\u{2194}"?> n * l = a - b (l <?="\u{2208}"?> <?="\u{2124}"?>).
            Valamint a Bézout- azonosság szerint: gcd(n,m) = 1 = n * x + m * y (x, y <?="\u{2208}"?> <?="\u{2124}"?>), mind a két oldalt (a-b)-vel szorozzuk, (a - b) = (a - b) * n * x + (a - b) * m * y = m * k * n * x + n * l * m * y, a jobb oldal osztható (n * m)-mel, így pedig az egyenlőségjel miatt az a - b is.
            m * n | a - b <?="\u{2194}"?> <span style="text-decoration: overline">a</span> = <span style="text-decoration: overline">b</span> <?="\u{2208}"?> <?="\u{2124}"?>/<sub>n*m</sub><?="\u{2124}"?>, azaz <span style="text-decoration: overline">a</span> = <span style="text-decoration: overline">b</span> <?="\u{2124}"?>/<sub>n*m</sub><?="\u{2124}"?>-ban.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Szürjektivitás:
            Kell keresnünk minden (<span style="text-decoration: overline">a</span><sub>1</sub>,<span style="text-decoration: overline">a</span><sub>2</sub>) <?="\u{2208}"?> <?="\u{2124}"?>/<sub>n</sub><?="\u{2124}"?> <?="\u{00D7}"?> <?="\u{2124}"?>/<sub>m</sub><?="\u{2124}"?> párhoz egy megfelelő <span style="text-decoration: overline">a</span> <?="\u{2208}"?> <?="\u{2124}"?>/<sub>n*m</sub><?="\u{2124}"?> maradékosztályt.
            A Bézout- azonosság szerint: gcd(n,m) = 1 = n * x + m * y (x, y <?="\u{2208}"?> <?="\u{2124}"?>), vagyis n * x <?="\u{2261}"?> 1 (mod m) és m * y <?="\u{2261}"?> 1 (mod n).
            Vegyük az n * x * a<sub>2</sub> + m * y * a<sub>1</sub> számot. Nézzük meg ennek mi a függvény általi képe: f(<span style="text-decoration: overline">n * x * a<sub>2</sub> + m * y * a<sub>1</sub></span>) = (<span style="text-decoration: overline">n * x * a<sub>2</sub> + m * y * a<sub>1</sub></span>,<span style="text-decoration: overline">n * x * a<sub>2</sub> + m * y * a<sub>1</sub></span>), ahol
            <span style="text-decoration: overline">n * x * a<sub>2</sub> + m * y * a<sub>1</sub></span> <?="\u{2208}"?> <?="\u{2124}"?>/<sub>n</sub><?="\u{2124}"?> és <span style="text-decoration: overline">n * x * a<sub>2</sub> + m * y * a<sub>1</sub></span> <?="\u{2208}"?> <?="\u{2124}"?>/<sub>m</sub><?="\u{2124}"?>.
            A fentieket persze átírhatjuk: <span style="text-decoration: overline">n * x * a<sub>2</sub> + m * y * a<sub>1</sub></span> = <span style="text-decoration: overline">0 + m * y * a<sub>1</sub></span> = <span style="text-decoration: overline">1 * a<sub>1</sub></span> = <span style="text-decoration: overline">a<sub>1</sub></span> <?="\u{2208}"?> <?="\u{2124}"?>/<sub>n</sub><?="\u{2124}"?>, hasonlóan
            <span style="text-decoration: overline">n * x * a<sub>2</sub> + m * y * a<sub>1</sub></span> = <span style="text-decoration: overline">n * x * a<sub>2</sub> + 0</span> = <span style="text-decoration: overline">1 * a<sub>2</sub></span> = <span style="text-decoration: overline">a<sub>2</sub></span> <?="\u{2208}"?> <?="\u{2124}"?>/<sub>n</sub><?="\u{2124}"?>. Tehát a n * x * a<sub>2</sub> + m * y * a<sub>1</sub> megfelelő szám.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>
<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Kongruenciarendszer megoldása
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Legyen az n <?="\u{2264}"?> 2:<br>
            (a<sub>1</sub>, b<sub>1</sub> <?="\u{2208}"?> <?="\u{2124}"?> és m<sub>1</sub> <?="\u{2208}"?> <?="\u{2124}"?><sup><?="\u{2265}"?>2</sup>): a<sub>1</sub> * x <?="\u{2261}"?> b<sub>1</sub> (mod m<sub>1</sub>)<br>
            (a<sub>2</sub>, b<sub>2</sub> <?="\u{2208}"?> <?="\u{2124}"?> és m<sub>2</sub> <?="\u{2208}"?> <?="\u{2124}"?><sup><?="\u{2265}"?>2</sup>): a<sub>2</sub> * x <?="\u{2261}"?> b<sub>2</sub> (mod m<sub>2</sub>)<br>
            ...<br>
            (a<sub>n</sub>, b<sub>n</sub> <?="\u{2208}"?> <?="\u{2124}"?> és m<sub>n</sub> <?="\u{2208}"?> <?="\u{2124}"?><sup><?="\u{2265}"?>2</sup>): a<sub>n</sub> * x <?="\u{2261}"?> b<sub>n</sub> (mod m<sub>n</sub>)<br>
            Keressük azokat a számokat, amely egyszerre teljesíti ezt a kongruenciarendszert.
            A kongruenciarendszer megoldhatóságának első feltétele az, hogy a modulusok páronként relatív prímek. Ha van 2 amelynél a modulus nem relatív prím, akkor azt kell megnézni, hogy azonosak-e ezek a kongruenciák, amennyiben nem, akkor a rendszert nem lehet megoldani, különben valamelyik kongruenciát ki lehet venni.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">    
            Megoldás algoritmusa:<br>
            1. lépés: ellenőrizzük, hogy a modulusok páronként relatív prímek. Ha van 2 amelynél a modulus nem relatív prím, akkor azt kell megnézni, hogy azonosak-e ezek a kongruenciák, amennyiben nem, akkor a rendszert nem lehet megoldani, különben valamelyik kongruenciát ki lehet venni;<br>
            2. lépés: oldjuk meg a kongruenciákat, itt ellenőrizzük, hogy a kongruenciák megoldhatók-e;<br>
            3. lépés: i := 1;<br>
            4. lépés: amíg 1-nél több kongruencia van (i < n):<br>
            4.1. lépés: az első két kongruenciát vonjuk össze eggyé.<br>
            4.1.1. lépés: kibővített euklideszi algoritmussal keressük meg az i == 1 esetén az m<sub>1</sub> * x + m<sub>2</sub> * y = 1, az i > 1 esetén pedig az m<sub>1,i</sub> * x + m<sub>i+1</sub> * y = 1 egyenlet egy-egy alapmegoldását az x-re és y-ra;<br>
            4.1.2. lépés: i == 1 esetén: b<sub>1,2</sub> = m<sub>1</sub> * x * b<sub>2</sub> + m<sub>2</sub> * y * b<sub>1</sub>, az i > 1 esetén pedig b<sub>1,i+1</sub> = m<sub>1,i</sub> * x * b<sub>i+1</sub> + m<sub>i+1</sub> * y * b<sub>1,i</sub>;<br>
            4.1.3. lépés: i == 1 esetén: m<sub>1,2</sub> = m<sub>1</sub> * m<sub>2</sub>, az i > 1 esetén pedig m<sub>1,i+1</sub> = m<sub>1,i</sub> * m<sub>i+1</sub>;<br>
            4.1.4. lépés: az összevont kongruencia: x <?="\u{2261}"?> b<sub>1,i+1</sub> (mod m<sub>1,i+1</sub>);<br>
            4.2. lépés: az összevont kongruenciára cseréljük ki az első két kongruenciát;<br>
            4.3. lépés: i := i + 1; <br>
            5. lépés: a visszamaradt kongruencia a megoldás.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>