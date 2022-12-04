<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Gráfok 
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            A G = (&varphi;, V, E) rendezett hármast irányítatlan <b>gráfnak</b> nevezzük. A  V és E halmazok, a &varphi; pedig egy függvény. A V-t <b>csúcshalmaznak</b>, az E-t pedig <b>élhalmaznak</b>, a &varphi;-t pedig az  az <b>illeszkedési függvénynek</b> nevezzük. Ha a csúcs- és élhalmaz véges, akkor a gráf véges, különben végtelen.
            Feltesszük, hogy a csúcshalmaz nem üres, és a V &cap; E = &emptyset;, valamint, hogy &varphi; : E &rightarrow; { { v, v' } | v, v' &in; V } } (rendezetlen párok halmaza), ahol: (e &in; E): &varphi;(e) = { e- re illeszkedő csúcsok }.
            Az <b>illeszkedési reláció</b>: I &subset; E &times; V, I =  { (e, v) &in; E &times; V | v &in; &varphi; (e) } = { (e, v) &in; E &times; V | v illeszkedik az e élre }. Ha egy él csak egy csúcsra illeszkedik, akkor <b>hurokélnek</b> nevezzük. Ha két élnek az illeszkedési leképezés által adott képe ugyanaz (azaz, ugyanazokra a csúcsokra illeszkednek), akkor <b>párhuzamos éleknek</b> nevezzük őket.
            Azt mondjuk, hogy <b>egy gráf egyszerű</b>, ha nem tartalmaz hurokéleket és párhuzamos éleket. Ha az élek halmaza üres, akkor a gráfot üresnek nevezzük. 
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            2 csúcs szomszédos, amennyiben van olyan él, amelyre illeszkednek a csúcsok, azaz az él végpontja ez a két csúcs.
            2 él szomszédos, amennyiben van közös végpontjuk. 
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Egy csúcs fokszáma alatt a rá illeszkedő élek számát értjük, és deg(v)-vel, vagy d(v)-vel jelöljük. A hurokéleket kétszer számoljuk a fokszámoknál.
            Ha egy csúcs fokszáma 0, akkor izolált csúcsnak nevezzük.
            Egy gráf esetén a gráf fokszámainak összege mindig 2-szerese az élhalmaz méretének, azaz &Sum;<sub>v &in; V</sub>d(v) = 2*|E(G)|. Ennek az az oka, hogy minden egyes él behúzása során, pontosan 2 csúcs fokszáma növekszik 1-1-gyel.
            A következménye pedig az, hogy a gráf páratlan fokú csúcsainak száma csakis páros lehet, máskülönben azon fokszámok összege páratlan lenne, így pedig a teljes fokszámösszeg is.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>
<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Gráfok megszerkeszthetősége:
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Adott a d<sub>1</sub> &ge; ... &ge; d<sub>n</sub> nemnegatív számokból álló fokszámsorozat. Ezzel a fokszámsorozattal gráf szerkeszthető, ha a fokszámösszeg páros.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>
<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Egyszerű gráf megszerkeszthetősége:
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Adott a d<sub>1</sub> &ge; ... &ge; d<sub>n</sub> nemnegatív számokból álló fokszámsorozat. Ezzel a fokszámsorozattal gráf szerkeszthető, ha egyrészt a fokszámösszeg páros,
            másrészt teljesül az is, hogy (k &in; {1, ..., n}): (&sum;<sup>k</sup><sub>i=1</sub>d<sub>i</sub>) - k*(k - 1) &le; (&sum;<sup>k</sup><sub>i=k+1</sub>min(d<sub>i</sub>, k)).
            <br>
            Utóbbi elégségességét egy algoritmus bizonyítja. Felveszünk n darab csúcsot, majd mindnél számon tartjuk a csúcs hiányát (azaz, hogy mennyi él kell még, hogy a csúcs fokszáma meglegyen). 
            Minden körben a legnagyobb hiányú csúcsból elkezdünk éleket húzni a hiánynak megfelelő számú, másik legnagyobb hiányú csúcsba. Ezt addig folytatjuk, amíg már minden csúcs hiánya 0, vagy maradt olyan csúcs, amely hiányát már nem tudjuk csökkenteni.
            Ha nem tudnánk csökkenteni a hiányt, akkor az csak úgy lehetséges, hogy a tételben szereplő egyenlőtlenség nem teljesül.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>
<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Páros gráf megszerkeszthetősége:
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Adottak az a<sub>1</sub> &ge; ... &ge; a<sub>m</sub> és b<sub>1</sub> &ge; ... &ge; b<sub>n</sub> nemnegatív számokból álló fokszámsorozatok. Ezekkel a fokszámsorozatokkal páros gráf szerkeszthető, ha egyrészt a két fokszámsorozat összege azonos,
            másrészt teljesül az is, hogy (k &in; {1, ..., m}): (&sum;<sup>k</sup><sub>i=1</sub>a<sub>i</sub>) &le; (&sum;<sup>n</sup><sub>i=1</sub>min(b<sub>i</sub>, k)).
            <br>
            Utóbbi elégségességét egy algoritmus bizonyítja. Felveszünk az A és B osztályok csúcsait élek nélkül, majd a B osztály minden csúcsánál számon tartjuk a csúcs hiányát (azaz, hogy mennyi él kell még, hogy a csúcs fokszáma meglegyen). 
            Minden körben az A csúcsai közül a legnagyobb hiányú csúcsból elkezdünk éleket húzni a hiánynak megfelelő számú, B osztály béli legnagyobb hiányú csúcsba. Ezt addig folytatjuk, amíg már minden B osztály béli csúcs hiánya 0, vagy maradt olyan csúcs ott, amely hiányát már nem tudjuk csökkenteni.
            Ha nem tudnánk csökkenteni a hiányt, akkor az csak úgy lehetséges, hogy a tételben szereplő egyenlőtlenség nem teljesül.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>
<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Fagráf megszerkeszthetősége:
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            A legalább 1 hosszú, zárt vonalat körnek nevezzük, ha a kezdő- és végpontja azonos, viszont a vonal pontjai különböznek.
            Egy körmentes gráfot erdőnek nevezünk. Az olyan csúcsok halmazát, amelyben bármely csúcsból, bármely másik elérhető úton, összefüggő komponensnek nevezzük.
            Ebben a gráfban egy él behúzása biztosan csökkenteni fogja a komponensek számát, ha ugyanis nem ez történne, akkor egy komponensen belüli 2 csúcs között futna az új él, ami pedig azt jelenti, hogy a 2 csúcs között már 2 út létezik, tehát a gráfban van kör (így már nem körmentes).
            Ha felvesszük a gráf összes csúcsát (|V(G)| darab) élek nélkül, akkor pontosan ennyi komponens is van a gráfban. Így ha a gráfban |E(G)| darab él van, akkor a komponensek száma a fentiek szerint = |V(G)| - |E(G)|.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            A fagráf egy összefüggő erdő, azaz olyan erdő, amelynek 1 darab komponense van. Tehát a korábbiak szerint 1 = |V(G)| - |E(G)|, másképp: |E(G)| = |V(G)| - 1.
            Adott a<sub>1</sub> &ge; ... &ge; a<sub>m</sub> fokszámsorozat, ekkor pontosan akkor szerkeszthető fagráf ezzel a fokszámsorozattal, ha teljesül, hogy |E(G)| = &frac12;*&Sum;<sub>v &in; V</sub>d(v) = |V(G)| - 1.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>
<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Irányított gráf megszerkeszthetősége:
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Adott a (&alpha;<sub>1</sub>, &beta;<sub>1</sub>), (&alpha;<sub>2</sub>, &beta;<sub>2</sub>), ..., (&alpha;<sub>n</sub>, &beta;<sub>n</sub>) irányított gráf, ahol &alpha;<sub>1</sub> &ge; ... &ge; &alpha;<sub>n</sub> nemnegatív számokból álló fokszámsorozatok. Ez az irányított gráf megszerkeszthető, ha egyrészt a kifokok (a párosok esetén a második számok) és befokok (a párosok esetén az első számok) összege megegyezik,
            másrészt teljesül az is, hogy (k &in; {1, ..., n}): (&sum;<sup>k</sup><sub>i=1</sub>&beta;<sub>i</sub>) &le; (&sum;<sup>k</sup><sub>i=1</sub>min(&alpha;<sub>i</sub>, k-1)) + (&sum;<sup>n</sup><sub>i=k+1</sub>min(&alpha;<sub>i</sub>, k)).
            <br>
            Utóbbi elégségességét egy algoritmus bizonyítja. Felveszünk n darab csúcsot, mindnél számon tartjuk, hogy mekkora a hiányuk (azaz, mennyi él hiányzik még, hogy meglegyen az adott csúcs befoka).
            Minden körben kiválasztjuk a legnagyobb hiányú csúcsot (azonos hiány esetén azt, amelynek a kifokát még nem kezeltük), majd kiválasztunk a kifokával megegyező legnagyobb hiányú másik csúcsot és behúzzuk az éleket. A többi csúcs hiányát 1-gyel csökkentjük.
            Akkor nem tudunk már hiányt csökkenteni, ha az egyenlőtlenség nem teljesül.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>