<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Binomiális tétel
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Adott az <?="\u{2124}"?> <?="\u{220B}"?> k szám. Ekkor a k szám faktoriálisa alatt a következőt értjük: k! = 0 (ha k < 0) és k! = <?="\u{220F}"?><sup>k</sup><sub>i=1</sub>i (ha k > 0) és 1, ha k = 0.
            Adottak az n, m <?="\u{220B}"?> <?="\u{2124}"?> egészek, ahol n <?="\u{2265}"?> m. Ekkor a (n alatt az m) = n! / (m! * (n - m)!) egészet binomiális együtthatónak nevezzük. Erre az <?="\u{276C}"?> n alatt m <?="\u{276D}"?> jelölést használjuk az oldalon. 
            Tulajdonságok: <?="\u{276C}"?> n alatt m <?="\u{276D}"?> = <?="\u{276C}"?> n alatt (m-n) <?="\u{276D}"?>; <?="\u{276C}"?> (n-1) alatt m <?="\u{276D}"?> + <?="\u{276C}"?> (n-1) alatt (m-1) <?="\u{276D}"?> = <?="\u{276C}"?> n alatt m <?="\u{276D}"?>.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            <b>Binomiális tétel: (a + b)<sup>n</sup> = <?="\u{220F}"?><sup>n</sup><sub>i=0</sub><?="\u{276C}"?> n alatt i <?="\u{276D}"?>a<sup>i</sup>b<sup>n-i</sup></b>, 
            ugyanis az i.-ik (i <?="\u{2208}"?> {0,1,...,n}) lépés során, i darab zárójel esetén választunk a-t és n-i esetén b-t. Ismétlés nélküli kombináció esetén pedig n darab zárójelből i darabot <?="\u{276C}"?> n alatt i <?="\u{276D}"?> féle képpen lehet kiválasztani.
            Tulajdonságok: (1+1)<sup>n</sup> = 2<sup>n</sup> = <?="\u{220F}"?><sup>n</sup><sub>i=0</sub><?="\u{276C}"?> n alatt i <?="\u{276D}"?> = <?="\u{276C}"?> n alatt 0 <?="\u{276D}"?> + ... + <?="\u{276C}"?> n alatt n <?="\u{276D}"?>, azaz egy halmaz részhalmazainak száma 2<sup>halmaz elemszáma</sup> (0 elemű, 1 elemű, ..., n elemű részhalmazok száma);
            0<sup>n</sup> = <?="\u{220F}"?><sup>n</sup><sub>i=0</sub><?="\u{276C}"?> n alatt i <?="\u{276D}"?>1<sup>i</sup>(-1)<sup>n-i</sup> = <?="\u{276C}"?> n alatt 0 <?="\u{276D}"?> - <?="\u{276C}"?> n alatt 1 <?="\u{276D}"?> + ... <?="\u{00B1}"?> <?="\u{276C}"?> n alatt n <?="\u{276D}"?>, azaz egy halmaz páros és páratlan elemszámú részhalmazainak száma azonos.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Polinomiális tétel: (a<sub>1</sub> + ... + a<sub>k</sub>)<sup>n</sup> = <?="\u{220F}"?><sub>i<sub>1</sub>+...+i<sub>k</sub> = n</sub>(x<sub>1</sub><sup>i<sub>1</sub></sup>*...*x<sub>k</sub><sup>i<sub>k</sub></sup>) * n!/(i<sub>1</sub>!*...*i<sub>k</sub>!).
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>
<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
                Általánosított Viéte- formula
            </label>
        </div>
        <div class="definition first_definition">
            <label class="definition_label elliptical_definition">
                Adott egy n-ed fokú polinom az a<sub>n</sub> * (x - x<sub>1</sub>) * (x - x<sub>2</sub>) * ... * (x - x<sub>n</sub>) szorzatalakban.
                Ekkor megszeretnénk kapni a polinom a<sub>n</sub> * x<sup>n</sup> + ... + a<sub>1</sub> * x + a<sub>0</sub> összegalakját, azaz az a<sub>i</sub>-ket (i <?="\u{2208}"?> {0,1,...,n}). 
                Az a<sub>i</sub> esetén ehhez i darab zárójelben kell x-et választani, a többiben pedig a konstans tagot. Ez persze azt jelenti, hogy n - i darab konstans tagot választunk és ebből <?="\u{276C}"?> n alatt i <?="\u{276D}"?> van.
                Azaz egy olyan <?="\u{276C}"?> n alatt i <?="\u{276D}"?> tagú összeget kapunk az i.-ik együttható meghatározásánál, melyben minden tag n - i darab gyököt tartalmazó szorzat (összes lehetséges n - i elemszámú kombinációját kivesszük az n darab gyöknek, majd az egyes kombinációkban lévő elemeket szorozzuk össze).
                Eszerint az i.-ik (i <?="\u{2208}"?> {0,1,...,n}) együttható képlete:
                <b>a<sub>i</sub> = a<sub>n</sub> * (-1)<sup>(n-i)</sup> * <?="\u{2211}"?><sub>1 <?="\u{2264}"?> j<sub>1</sub> < j<sub>2</sub> < ... < j<sub>(n - i)</sub> <?="\u{2264}"?> n</sub>x<sub>j<sub>1</sub></sub>* ... *x<sub>j<sub>(n-i)</sub></sub></b>.
            </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>