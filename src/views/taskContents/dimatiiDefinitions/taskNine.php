<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Lagrange- interpoláció
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
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>