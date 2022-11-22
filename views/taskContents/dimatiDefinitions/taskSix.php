<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Komplex számok trigonometrikus alakja
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Gauss- számsík: ha a derékszögű koordináta-rendszerben az x- tengelyen a valós számokat, az y- tengelyen pedig a képzetes egység számsorosait ábrázoljuk, akkor minden egyes pontnak a koordináta- rendszerben megfeleltethető egy komplex szám. Így a komplex számok valójában olyan síkvektorok, amelyek egyben helyvektorok is.
            A komplex számokat ezután már jelölhetjük a két koordinátájukkal is. Például: <?="\u{2102}"?> <?="\u{220B}"?> w = a + b * i = (a, b) (a, b <?="\u{2208}"?> <?="\u{211D}"?>). Ez a komplex szám geometrikus alakja.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            A műveletek, valamint néhány tulajdonság geometriai értelemben sokkal szemléletesebb ebben az ábrázolásban: egy komplex szám hossza az őt reprezentáló vektor hossza (valós számok esetén továbbra is a 0-tól (origótól) vett távolság); 
            a konjugált a vektor x tengelyre vett tükörképe; 
            2 komplex szám szorzata (és a hatványozás is) forgatva való nyújtást jelent; 
            2 vektor összeadása, az eltolással azonos;
            komplex szám konjugálttal való szorzása esetén először vesszük a vektor merőleges vetületét az x- tengelyre, majd ezt nyújtjuk a vektor hosszával.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            A komplex szám argumentuma az x- tengellyel bezárt szöge. Ha tehát <?="\u{2102}"?> <?="\u{220B}"?> w = a + b * i = (a, b) (a, b <?="\u{2208}"?> <?="\u{211D}"?>), akkor a bezárt szög = <b>arctan(b/a) = arcsin(b/|w|) = arccos(a/|w|)</b>. A w argumentumát az <b>arg(w)</b>-vel jelöljük. Ezt pedig az egyszerűség kedvéért a <?="\u{03C6}"?> görög betűvel fogom jelölni.
            Természetesen a korábbi összefüggésekből egyszerű átrendezések után adódik, hogy a = cos(<?="\u{03C6}"?>) * |w| és b = sin(<?="\u{03C6}"?>) * |w|, így <b>w = a + b * i = |w| * (cos(<?="\u{03C6}"?>) + i * sin(<?="\u{03C6}"?>))</b>.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>
<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Műveletek trigonometrikus alakkal
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Legyen <?="\u{2102}"?> <?="\u{220B}"?> w = |w| * (cos(<?="\u{03C6}"?><sub>1</sub>) + i * sin(<?="\u{03C6}"?><sub>1</sub>)) és <?="\u{2102}"?> <?="\u{220B}"?> z = |z| * (cos(<?="\u{03C6}"?><sub>2</sub>) + i * sin(<?="\u{03C6}"?><sub>2</sub>)).
            Ekkor <b>w * z = |w| * |z| * (cos(<?="\u{03C6}"?><sub>1</sub> + <?="\u{03C6}"?><sub>2</sub>) + i * sin(<?="\u{03C6}"?><sub>1</sub> + <?="\u{03C6}"?><sub>2</sub>))</b>.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Legyen <?="\u{2102}"?> <?="\u{220B}"?> w = |w| * (cos(<?="\u{03C6}"?><sub>1</sub>) + i * sin(<?="\u{03C6}"?><sub>1</sub>)) és <?="\u{2102}"?> <?="\u{220B}"?> z = |z| * (cos(<?="\u{03C6}"?><sub>2</sub>) + i * sin(<?="\u{03C6}"?><sub>2</sub>)).
            Ekkor <b>w / z = (|w| / |z|) * (cos(<?="\u{03C6}"?><sub>1</sub> - <?="\u{03C6}"?><sub>2</sub>) + i * sin(<?="\u{03C6}"?><sub>1</sub> - <?="\u{03C6}"?><sub>2</sub>))</b>.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>