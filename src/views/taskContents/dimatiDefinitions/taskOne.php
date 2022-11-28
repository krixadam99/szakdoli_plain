<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Halmazok
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Alapfogalom, így nem lehet definiálni. Körülírva: jól meghatározható dolgok összessége. Minden elemet egyszer tartalmazhat (minden eleme egyértelműen hivatkozható), az elemek sorrendje nem számít.
        </label>
        <br>
        <label class="definition_label elliptical_definition">
            Egy halmazt megadhatunk az elemeinek felsorolásával, vagy az elemek egy jól meghatározható tulajdonságával. A halmazokat konvenció szerint nagy betűvel jelöljük, az üres halmazt pedig a {}, vagy a <?="\u{2205}"?> jelekkel.
        </label>
        <br>
    </div>
    <div class="definition">
        <label class="definition_label">
            A <?="\u{2282}"?> B: azt mondjuk, hogy az A halmaz valódi részhalmaza a B halmaznak, ha A minden eleme benne van a B-ben is, de B-nek van olyan eleme, amely A-ban nincsen benne.
        </label>
        <br>
        <label class="definition_label">
            A <?="\u{2286}"?> B: azt mondjuk, hogy az A halmaz részhalmaza a B halmaznak, ha A minden eleme benne van a B-ben is, de B-nek lehet, hogy van olyan eleme, amely A-ban nincsen benne.
        </label>
        <br>
        <label class="definition_label">
            Az A és B halmazok azonosak, ha egyrészt elemszámuk megegyezik, másrészt az A elemei benne vannak B-ben és fordítva (formálisan: A = B <?="\u{2194}"?> A <?="\u{2286}"?> B <?="\u{2227}"?> B <?="\u{2286}"?> A <?="\u{2227}"?> |A| = |B|). Ezt a feltételt több bizonyításban is használjuk.   
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>
<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Halmazok közötti műveletek
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            A <?="\u{222A}"?> B (unió): Olyan elemek összessége, melyek benne vannak az A, vagy a B halmazban (megengedő vagy, OR). Formálisan: A <?="\u{222A}"?> B = { x: x <?="\u{2208}"?> A <?="\u{2228}"?> x <?="\u{2208}"?> B }. Tulajdonságai: kommutatív, asszociatív, idempotens (A <?="\u{222A}"?> A = A).
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            A <?="\u{2229}"?> B (metszet): Olyan elemek összessége, melyek benne vannak az A és a B halmazban is. Formálisan: A <?="\u{2229}"?> B = { x: x <?="\u{2208}"?> A <?="\u{2227}"?> x <?="\u{2208}"?> B }. Tulajdonságai: kommutatív, asszociatív, idempotens (A <?="\u{2229}"?> A = A).
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            A \ B (különbség): Olyan elemek összessége, melyek benne vannak az A halmazban, de nincsenek benne a B-ben. Formálisan: A \ B = { x: x <?="\u{2208}"?> A <?="\u{2227}"?> x <?="\u{2209}"?> B }. Tulajdonságai: nem kommutatív, asszociatív, nem idempotens (A \ A <?="\u{2260}"?> A ( = <?="\u{2205}"?>)).
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            <span style="text-decoration: overline">A</span> (komplementer): Olyan elemek összessége, amelyek nincsenek benne az A (A <?="\u{2286}"?> U) halmazban, de benne vannak az alaphalmazban (U-ban). Formálisan: <span style="text-decoration: overline">A</span> = { x: x <?="\u{2208}"?> U <?="\u{2227}"?> x <?="\u{2209}"?> A } <?="\u{2286}"?> U.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            A <?="\u{2206}"?> B (szimmetrikus differencia) : Olyan elemek összessége, melyek benne vannak vagy az A, vagy a B halmazban, de csak az egyikben (kizáró vagy, XOR). Formálisan: A <?="\u{222A}"?> B = { x: (x <?="\u{2208}"?> A <?="\u{2227}"?> x <?="\u{2209}"?> B) <?="\u{2228}"?> (x <?="\u{2208}"?> B <?="\u{2227}"?> x <?="\u{2209}"?> A) } = { x: (x <?="\u{2208}"?> A <?="\u{222A}"?> B) <?="\u{2227}"?> (x <?="\u{2209}"?> A <?="\u{2229}"?> B) }. Tulajdonságai: kommutatív, asszociatív, nem idempotens (A <?="\u{2206}"?> A <?="\u{2260}"?> A ( = <?="\u{2205}"?>)).
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>