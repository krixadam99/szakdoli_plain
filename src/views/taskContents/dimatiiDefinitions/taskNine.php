<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Lagrange- féle interpoláció
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Adottak a (x<sub>1</sub>, y<sub>1</sub>), (x<sub>2</sub>, y<sub>2</sub>), ..., (x<sub>n + 1</sub>, y<sub>n + 1</sub>) pontok. Ekkor szeretnénk meghatározni azt az n-ed fokú görbét, amelyre illeszkednek a pontok.
            Az első módszer a Lagrange- interpoláció lesz. Bevezetjük a Lagrange- alappolinomokat. Az i.-ik (i <?="\u{2208}"?> {1,..,n}) alappolinom olyan, hogy az i.-ik pontnál 1-et, a többi helyen pedig 0-t vesz fel. Sorra megszorozzuk az alappolinomokat a helyhez tartozó értékkel. Végül összeadjuk őket.<br>
            (i <?="\u{2208}"?> {1,..,n}): l<sub>(x<sub>i</sub>,y<sub>i</sub>)</sub>[x] := l<sub>i</sub>[x] = (<?="\u{220F}"?><sup>n</sup><sub>j=1, j <?="\u{2260}"?> i</sub>(x - x<sub>j</sub>))/(<?="\u{220F}"?><sup>n</sup><sub>j=1, j <?="\u{2260}"?> i</sub>(x<sub>i</sub> - x<sub>j</sub>)). Valóban l<sub>i</sub>[x<sub>i</sub>] = 1 és (i <?="\u{2260}"?> j): l<sub>i</sub>[x<sub>j</sub>] = 0 a számláló miatt.
            Az interpolációs polinom pedig: L[x] := <?="\u{220F}"?><sup>n</sup><sub>i=1</sub>(y<sub>i</sub> * l<sub>i</sub>[x]). Ebbe a polinomba az x<sub>i</sub>-t helyettesítve egyedül az i.-ik tag nem lesz nulla (ugyanis (i <?="\u{2260}"?> j): l<sub>j</sub>[x<sub>i</sub>] = 0), az ottani alappolinom értéke pedig 1 (l<sub>i</sub>[x<sub>i</sub>] = 1), amelyet y<sub>i</sub>-vel megszorozva a helyettesítési érték valóban y<sub>i</sub> lesz.
            Így ezen a polinomon valóban rajta vannak az említett pontok. 
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>
<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Newton- interpoláció
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            A Newton- interpoláció által kapott polinomhoz a lépcsős táblát használjuk.
            Nem bizonyítjuk, hogy az előző és következő módszerek ugyanazt a polinomot adják.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            A Newton- interpoláció menete (vázlatosan):
            <br>
            Felrajzoljuk a lépcsős táblát, mely 1. és 2. oszlopában vannak a hely - érték párok.
            A 3. oszloptól kezdve minden oszlopban 1-gyel kevesebb sor lesz, mint az előzőben. Érdemes a 3. oszloptól az előző oszlop celláit felezni, ezek pedig meghatározzák az új cellákat. Összesen (pontok száma) - 1 új oszlop lesz.
            Minden cella esetén a számlálóba a cellával szomszédos, előző oszlopban lévő értékek különbsége kerül úgy, hogy az alsóból vonjuk ki a felsőt.
            A nevezőben pedig a helyek (1. oszlop béli elemek) különbsége kerül úgy, hogy a kivonandó a (cella sorszáma (adott oszlopban 1-től számozva) + (oszlopszám - 2)). hely (1. oszlop béli elem), a kivonó pedig a (cella sorszáma). hely (1. oszlop béli elem).
            Ezt a törtet az egyes cellákban osztott differenciának is nevezzük.
            Ha a táblázatot kitöltöttük, akkor válasszuk ki a 2. oszloptól a legfelső cellákat.
            Az interpolációs polinom pedig: 2. oszlop 1. eleme + 3. oszlop 1. eleme * (x - 1. oszlop 1. eleme) + 4. oszlop 1. eleme * (x -  1. oszlop 1. eleme)(x -  1. oszlop 2. eleme) + ...
            = y<sub>1</sub> + &Sum;<sup>n+1</sup><sub>i = 3</sub>(i. oszlop 1. elem * &Product;<sup>i - 2</sup><sub>j = 1</sub>(x-x<sub>j</sub>)).
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>