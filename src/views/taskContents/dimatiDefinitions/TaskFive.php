<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Komplex számok
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Pongyolán fogalmazva, minden számhalmaz esetén egy újabbat akkor vezettünk be, amikor valamilyen művelet korlátozva lett a számhalmazon (nem zárt már a számhalmazon).
            A természetes számok körében az összeadás és szorzás zárt, de a kivonás kivezetett az egészek körébe (inverz hiánya a nem nulla természetes számoknál az összeadásra nézve). Az egészek zártak a hozzáadásra nézve, viszont az osztás nem mindig eredményezett egész számot (inverz hiánya nem nulla egészeknél a szorzásra nézve).
            Így jutottunk el a racionális számokhoz, ahol pedig már az alapműveletek elvégezhetők voltak, viszont a hatványozásnál csak a egész kitevőt lehetett venni. Így pedig a nem egész kitevős hatványozás során jutunk el a valós számokhoz, melyek a racionális és irracionális számok uniója.
            Fontos megjegyezni, hogy még mindig voltak korlátozások. Például páros gyököt csakis nemnegatív szám esetén vehettünk (ugyanis bármely szám páros kitevős hatványa nemnegatív, míg páratlan kitevős szám lehet negatív is).
            Ahhoz, hogy a gyökvonást korlátozás nélkül elvégezhessük, be lett vezetve az imaginárius egység, az i, melynek négyzete a -1. A komplex számok halmaza tehát olyan számhalmaz, amely a valós és imaginárius számok halmazának uniója.
            A bővítés során folyamatosan figyelni kellett arra, hogy a korábbi műveleti tulajdonságok megmaradjanak. A komplex számok közötti műveletek is így lettek definiálva. A szorzás és összeadás műveleteire így továbbra is teljesülnek a test axiómák (ZANIK - Ábel csoport (az adott művelet zárt, asszociatív, van neutrális eleme, van inverz elem valamennyi elemnek, kommutatív), valamint a 2 művelet esetén van 2 oldali disztributivitás).
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            A fentiek szerint valamennyi valós szám felírható egy valós és egy imaginárius szám összegeként. Így a <?="\u{2102}"?> <?="\u{220B}"?> w = a + b * i (a, b <?="\u{2208}"?> <?="\u{211D}"?>), ahol Re(w) = a, a w szám valós, az Im(w) = b pedig a képzetes része. A valós számok esetén a képzetes rész 0.
            <br>
            A <?="\u{2102}"?> <?="\u{220B}"?> w = a + b * i (a, b <?="\u{2208}"?> <?="\u{211D}"?>) komplex szám konjugáltja alatt a <span style="text-decoration : overline">w</span> = a - b*i komplex számot értjük.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            A <?="\u{2102}"?> <?="\u{220B}"?> w = a + b * i (a, b <?="\u{2208}"?> <?="\u{211D}"?>) komplex szám hossza alatt a <?="\u{221A}"?>(w*<span style="text-decoration : overline">w</span>) = <?="\u{221A}"?>(a<sup>2</sup> + b<sup>2</sup>) valós számot értjük, ezt a |w|-vel jelöljük. Tulajdonságok: |a| = 0, pontosan akkor, ha az a = 0; (<?="\u{2200}"?> a, b <?="\u{2208}"?> <?="\u{2102}"?>):|a*b| = |a|*|b|; (<?="\u{2200}"?> a, b <?="\u{2208}"?> <?="\u{2102}"?>): |a|/|b| = |a/b|, végül a háromszög- egyenlőtlenség: (<?="\u{2200}"?> a, b <?="\u{2208}"?> <?="\u{2102}"?>): |a + b| <?="\u{2264}"?> |a| + |b|.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>
<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Komplex számok közötti műveletek
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            A komplex számok közötti műveleteket úgy kellett definiálni, hogy azok a valós számok esetén (tehát, amikor a képzetes rész 0) megtartsák a tulajdonságaikat.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Adott <?="\u{2102}"?> <?="\u{220B}"?> w = a + b * i (a, b <?="\u{2208}"?> <?="\u{211D}"?>) és <?="\u{2102}"?> <?="\u{220B}"?> z = c + d * i (c, d <?="\u{2208}"?> <?="\u{211D}"?>). Ekkor a <b>w <?="\u{00B1}"?> z = (a <?="\u{00B1}"?> c) + i * (b <?="\u{00B1}"?> d)</b>.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Adott <?="\u{2102}"?> <?="\u{220B}"?> w = a + b * i (a, b <?="\u{2208}"?> <?="\u{211D}"?>) és <?="\u{2102}"?> <?="\u{220B}"?> z = c + d * i (c, d <?="\u{2208}"?> <?="\u{211D}"?>). Ekkor a <b>w * z = (a * c - b * d) + i * (a * d + b * c)</b>.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
        Adott <?="\u{2102}"?> <?="\u{220B}"?> w = a + b * i (a, b <?="\u{2208}"?> <?="\u{211D}"?>) és <?="\u{2102}"?> <?="\u{220B}"?> z = c + d * i (c, d <?="\u{2208}"?> <?="\u{211D}"?>). Ekkor a <b>w / z</b> 
        = (w * <span style="text-decoration : overline">z</span>) / |z|<sup>2</sup>
        = <b>((a * c + b * d) + i * (b * c - a * d)) / (c<sup>2</sup> + d<sup>2</sup>)</b>.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>