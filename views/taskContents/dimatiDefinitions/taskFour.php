<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Függvények
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Adott az f <?="\u{2286}"?> D <?="\u{2A2F}"?> R reláció. Azt mondjuk, hogy az f reláció függvény, ha bármely két rendezett pár első eleme különböző (azaz egyértelmű, vagyis bármely rendezett pár meghatározható egyértelműen az első eleme alapján). 
            Formálisan: (x,y) <?="\u{2208}"?> f <?="\u{2227}"?> (x,z) <?="\u{2208}"?> f <?="\u{2194}"?> y = z. A rendezett párok első elemei a helyek, a második elemek pedig az értékek.
            Ha f függvény és (a,b) <?="\u{2208}"?> f, akkor az <i>a f b</i> helyett az <i>f(a) = b</i> jelölést használjuk. Ekkor azt mondjuk, hogy az f függvény a b értéket veszi fel az a helyen.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Ha az f <?="\u{2286}"?> D <?="\u{2A2F}"?> R reláció függvény, akkor ezt így jelöljük: f <?="\u{2208}"?> D <?="\u{2192}"?> R. Ha Dom<sub>f</sub> = D, akkor a f : D <?="\u{2192}"?> R jelölést használjuk. Ekkor a D az alaphalmaz, az R a képhalmaz.
            Az f függvény képe: graph(f) = { {{x}, {x,f(x)}} | x <?="\u{2208}"?> D } = {(x, f(x)) | x <?="\u{2208}"?> D}. Egyváltozós (skalár) függvény (azaz bináris reláció) esetén, a helyek az abszcisszán, az értékek pedig az ordinátán helyezkednek el. A nulvektor pedig az origó.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Az f és g függvények azonosak, ha értelmezési tartományuk (azaz Dom<sub>f</sub> és Dom<sub>g</sub>) azonosak, valamint bármely értelmezési tartomány béli helyen a függvények azonos értéket vesznek fel.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            A függvényeknél a relációk korábbi definíciói (értelmezési tartomány, értékkészlet, inverz, megszorítás halmazra, halmazon felvett őskép és kép), valamint relációk kompozícója azonos az ott látottakkal (ez abból következik, hogy a függvények speciális relációk). Valójában minimálisan módosulnak a definíciók az <i>a f b</i> és <i>f(a) = b</i> jelölésváltás miatt.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>
<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Függvények alapvető tulajdonságai
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Az f <?="\u{2208}"?> D <?="\u{2192}"?> R függvény <b>szürjektív</b>, ha Ran<sub>f</sub> = R. Formálisan: (<?="\u{2200}"?> b <?="\u{2208}"?> R)(<?="\u{2203}"?> a <?="\u{2208}"?> D): f(a) = b. Ha f és g szürjektív függvények, akkor kompozíciójuk is szürjektív függvény.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Az f <?="\u{2208}"?> D <?="\u{2192}"?> R függvény <b>injektív</b> (vagy <b>invertálható</b>), ha az inverz relációja függvény, azaz az inverze egyértelmű, vagyis bármely rendezett pár meghatározható egyértelműen a második eleme alapján. Formálisan: (<?="\u{2200}"?> x, y <?="\u{2208}"?> Dom<sub>f</sub>): f(x) = f(y) <?="\u{2194}"?> x = y. Másképpen (<?="\u{2200}"?> x, y <?="\u{2208}"?> Dom<sub>f</sub>): x <?="\u{2260}"?> y <?="\u{2192}"?> f(x) <?="\u{2260}"?> f(y). Ha f és g injektív függvények, akkor kompozíciójuk is injektív függvény.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Az f <?="\u{2208}"?> D <?="\u{2192}"?> R függvény <b>bijektív</b>, ha az f szürjektív és injektív. A korábbiakból következik, hogy ha f és g bijektív függvények, akkor kompozíciójuk is bijektív függvény.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>