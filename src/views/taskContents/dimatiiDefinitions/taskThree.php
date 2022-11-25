<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Legnagyobb közös osztó és legkisebb közös többszörös
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label">
            Adottak <?="\u{2124}"?> <?="\u{220B}"?> a, b számok. Jelölje ekkor ennek a két számnak a legnagyobb közös osztóját az a d <?="\u{2208}"?> <?="\u{2124}"?> szám amelyre teljesül, hogy:
        </label>
    </div>
    <div class="definition">
        <ul class="definition_list">
            <li><label>d <?="\u{2265}"?> 0 (egyértelmű);</label></li>
            <li><label>d | a <?="\u{2227}"?> d | b (közös osztó);</label></li>
            <li><label>(<?="\u{2200}"?> e <?="\u{2208}"?> <?="\u{2124}"?>): e | a <?="\u{2227}"?> e | b <?="\u{2192}"?> e | d (legnagyobb).</label></li>
        </ul>
        <label class="definition_label">
            Ha a legnagyobb közös osztó 1, akkor a két számot relatív prímnek nevezzük (legnagyobb közös osztó az egység). A legnagyobb közös osztóval osztva a két számot relatív prímek lesznek.
            A legnagyobb közös osztót az <i>LNKO(a,b)</i>-vel, <i>gcd(a,b)</i>-mel, esetleg <i>(a,b)</i>-vel jelöljük.  A másodikat és az elsőt fogom használni. Ritkán a harmadikat is, bár az összetéveszthető a rendezett párokkal, vagy nyílt intervallummal.
            Adott <?="\u{2124}"?> <?="\u{220B}"?> a gcd(0, a) = |a|. Nyilván |a| <?="\u{2265}"?> 0, és |a| a legnagyobb olyan szám, amely osztója a-nak. Végül azt is tudjuk, hogy bármely szám osztója a 0-nak, így a |a| is.
            Az is bebizonyítható, hogy gcd(a, b) = gcd(a, b - k * a) (a, b, k <?="\u{2208}"?> <?="\u{2124}"?>). 
            Ehhez vennünk kell a { d <?="\u{2208}"?> <?="\u{2124}"?><sup><?="\u{2265}"?>0</sup> : d | a <?="\u{2227}"?> d | b} és { d <?="\u{2208}"?> <?="\u{2124}"?><sup><?="\u{2265}"?>0</sup> : d | a <?="\u{2227}"?> d | b - a * k} halmazokat és be kell látni, hogy azonosak, így pedig a véges elemszámuk miatt a maximumuk (ami rendre gcd(a, b) és gcd(a, b - k * a)) is egyenlő.
            Az Eukleidészi- algoritmus segítségével bizonyítjuk, hogy bármely két egész számnak van legnagyobb közös osztója.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Adottak <?="\u{2124}"?> <?="\u{220B}"?> a, b számok. Jelölje ekkor ennek a két számnak a legkisebb közös többszörösét az az m <?="\u{2208}"?> <?="\u{2124}"?> szám amelyre teljesül, hogy:
        </label>
        <ul class="definition_list">
            <li><label>m <?="\u{2265}"?> 0 (egyértelmű);</label></li>
            <li><label>a | m <?="\u{2227}"?> b | m (közös többszörös);</label></li>
            <li><label>(<?="\u{2200}"?> e <?="\u{2208}"?> <?="\u{2124}"?>): a | e <?="\u{2227}"?> b | e <?="\u{2192}"?> m | e (lekisebb).</label></li>
        </ul>
        <label class="definition_label">
            A legkisebb közös többszöröst az <i>LKKT(a,b)</i>-vel, <i>lcm(a,b)</i>-mel, esetleg <i>[a,b]</i>-vel jelöljük. A másodikat és az elsőt fogom használni.
            Adottak <?="\u{2124}"?> <?="\u{220B}"?> a, b, ekkor lcm(a,b) = |a * b| / gcd(a,b).
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>
<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Eukleidészi- algoritmus
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Adottak a <?="\u{2124}"?> <?="\u{220B}"?> a, b számok. Feltételezzük, hogy mind a kettő nemnegatív (ha negatívak, akkor vegyük az abszolútértéküket, ugyanis a legnagyobb közös osztó ugyanaz marad), valamint az a <?="\u{2265}"?> b.
            Majd hajtsuk végre a következő maradékos osztásokat:<br>
            a = q<sub>0</sub> * b + r<sub>0</sub>;<br>
            b = q<sub>1</sub> * r<sub>0</sub> + r<sub>1</sub>;<br>
            r<sub>0</sub> = q<sub>2</sub> * r<sub>1</sub> + r<sub>2</sub>;<br>
            ...<br>
            r<sub>i-2</sub> = q<sub>i</sub> * r<sub>i-1</sub> + r<sub>i</sub>.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Mivel itt végig maradékos osztást hajtottunk végre, ezért a korábbi tétel alapján |b| = b > |r<sub>0</sub>| = r<sub>0</sub> > ... > |r<sub>i</sub>| = r<sub>i</sub> <?="\u{2265}"?> 0,
            tehát a maradékok egy szigorúan monoton csökkenő számsorozatot alkotnak, ebből pedig következik, hogy az algoritmus véges számú lépésben véget ér. Az i-t értelemszerűen érdemes úgy megválasztani, hogy az r<sub>i</sub> 0 legyen.
            Felhasználva a korábbi tételeinket: gcd(a, b) = gcd(b, a - k<sub>0</sub> * b) [k<sub>0</sub> <?="\u{2208}"?> <?="\u{2124}"?>, ezért kicserélhető q<sub>0</sub>-ra] = gcd(b, a -  q<sub>0</sub> * b) 
            = gcd(b, r<sub>0</sub>) = gcd(r<sub>0</sub>, b - k<sub>1</sub> * r<sub>0</sub>) [k<sub>1</sub> <?="\u{2208}"?> <?="\u{2124}"?>, ezért kicserélhető q<sub>1</sub>-re] = gcd(r<sub>0</sub>, b - q<sub>1</sub> * r<sub>0</sub>) 
            = gcd(r<sub>0</sub>, r<sub>1</sub>) = ... = gcd(r<sub>i-1</sub>, r<sub>i</sub>) = gcd(r<sub>i-1</sub>, 0) = |r<sub>i-1</sub>| = r<sub>i-1</sub>.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Mivel az Eukleidészi- algoritmus véges lépésben véget ér bármely két egész szám esetén, ezért valóban bármely két szám esetén létezik a legnagyobb közös osztó.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>
<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Kibővített Eukleidészi- algoritmus
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            A gcd(a,b) meghatározásánál használt Eukleidészi- algoritmust felhasználva alkotjuk meg az itteni algoritmust. Azt szeretnénk elérni, hogy minden maradékot felírhassunk az a és b lineáris kombinációjaként.<br>
            r<sub>-2</sub> := 1*a + 0*b = a (m<sub>-2</sub> := 1, n<sub>-2</sub> := 0);<br>
            r<sub>-1</sub> := 0*a + 1*b = b (m<sub>-1</sub> := 0, n<sub>-1</sub> := 1);<br>
            r<sub>0</sub> = a - q<sub>0</sub> * b (m<sub>0</sub> := 1, n<sub>0</sub> := -q<sub>0</sub>);<br>
            r<sub>1</sub> = b - q<sub>1</sub> * r<sub>0</sub> = b - q<sub>1</sub> * (a - q<sub>0</sub> * b) =  b * (1 + q<sub>1</sub> * q<sub>0</sub>) - q<sub>1</sub> * a (m<sub>1</sub> := -q<sub>1</sub>, n<sub>1</sub> := 1 + q<sub>1</sub> * q<sub>0</sub>);<br>
            ...<br>
            Tegyük fel, hogy a k.-ik (0 <?="\u{2264}"?> k <?="\u{2264}"?> (i - 1)) lépésig (a k.-ik már nem) minden maradékot fel tudtunk írni a és b lineáris kombinációjaként, 
            vagyis r<sub>k-2</sub> = m<sub>k-2</sub> * a + n<sub>k-2</sub> * b és r<sub>k-1</sub> = m<sub>k-1</sub> * a + n<sub>k-1</sub> * b.<br>
            Ekkor az Eukleidészi- algoritmus szerint: r<sub>k</sub> = r<sub>k-2</sub> - q<sub>k</sub> * r<sub>k-1</sub>
            = m<sub>k-2</sub> * a + n<sub>k-2</sub> * b - q<sub>k</sub> * (m<sub>k-1</sub> * a + n<sub>k-1</sub> * b)
            = a * (m<sub>k-2</sub> - q<sub>k</sub> * m<sub>k-1</sub>) + b*(n<sub>k-2</sub> - q<sub>k</sub> * n<sub>k-1</sub>)
            = a * m<sub>k</sub>  + b*n<sub>k</sub> (m<sub>k</sub> := m<sub>k-2</sub> - q<sub>k</sub> * m<sub>k-1</sub>, n<sub>k</sub> := n<sub>k-2</sub> - q<sub>k</sub> * n<sub>k-1</sub>).
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Mivel gcd(a,b) = r<sub>i-1</sub>, és r<sub>i-1</sub> a kibővített Eukleidészi- algoritmus szerint felírható az a és b lineáris kombinációjaként, ezért a legnagyobb közös osztó is.
            Ezt nevezzük Bézout- azonosságnak: gcd(a,b) = a * x + b * y ( = a * m<sub>i-1</sub> + b * n<sub>i-1</sub>) (x, y <?="\u{2208}"?> <?="\u{2124}"?>).
            Adottak a <?="\u{2124}"?> <?="\u{220B}"?> a, b, c számok, továbbá tudjuk, hogy c | a * b és gcd(c, a) = 1, ekkor c | b. Bézout szerint, ekkor 1 = c * x + a * y (x, y <?="\u{2208}"?> <?="\u{2124}"?>), mind a két oldalt b-vel szorozva pedig b = c * x * b + a * b * y, ahol a b a jobb oldal mindkét tagját osztja, így pedig a bal oldalt, azaz a b-t is.
            Következmény: ha a p szám prím és osztója az a * b szorzatnak, akkor osztója a-nak, vagy b-nek is. Sőt ez kiterjeszthető többtényezős szorzatra is.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>