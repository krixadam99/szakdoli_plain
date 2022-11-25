<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Komplex számok hatványozása trigonometrikus alak segítségével
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label">
            Legyen <?="\u{2102}"?> <?="\u{220B}"?> w = |w| * (cos(<?="\u{03C6}"?>) + i * sin(<?="\u{03C6}"?>)).
            Ekkor <b>(<?="\u{2200}"?> m <?="\u{2208}"?> <?="\u{2124}"?>): w<sup>m</sup> = |w|<sup>m</sup> * (cos(m * <?="\u{03C6}"?>) + i * sin(m * <?="\u{03C6}"?>))</b>.
        </label>
    </div>
</div>
<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Komplex számok gyökvonása trigonometrikus alak segítségével
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label">
            Legyen <?="\u{2102}"?> <?="\u{220B}"?> w = |w| * (cos(<?="\u{03C6}"?>) + i * sin(<?="\u{03C6}"?>)).
            Ekkor <b>(<?="\u{2200}"?> m <?="\u{2208}"?> <?="\u{2124}"?>): <sup>m</sup><?="\u{221A}"?>w = <sup>m</sup><?="\u{221A}"?>|w| (cos((<?="\u{03C6}"?> + 2 * k * <?="\u{03C0}"?>) / m) + i * sin((<?="\u{03C6}"?> + 2 * k * <?="\u{03C0}"?>) / m))</b> (k = 0,1,..,m-1).
        </label>
    </div>
</div>
<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Komplex szám rendje és egységgyökök
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Legyen <?="\u{2102}"?> <?="\u{220B}"?> w = |w| * (cos(<?="\u{03C6}"?>) + i * sin(<?="\u{03C6}"?>)).
            Ekkor a komplex szám rendjének azt a legkisebb pozitív egészet nevezzük, amelyre a számot emelve önmagát kapjuk. Ha nincsen ilyen szám, akkor végtelen a rend.
            Mivel egy komplex szám hatványozás geometriai értelemben a forgatva nyújtás, így ahhoz, hogy a rend véges legyen, szükséges az, hogy a komplex szám hossza 1 legyen.
            Ha <?="\u{03C6}"?> = (p / q) * 2 * <?="\u{03C0}"?> (ahol (p, q) = 1), akkor a w rendje q.
            Tehát 1 hosszú komplexek esetén a hatványok periodikusan ismétlődnek, a periódus hosszát pedig a rend határozza meg.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Azt mondjuk, hogy a w komplex szám az n.-ik egységyök, ha w<sup>n</sup> = 1. Előzőek szerint ekkor: <?="\u{03C6}"?> = (p / n) * 2 * <?="\u{03C0}"?> alakú (ahol (p, n) = 1). 
            Ha nincsen olyan osztója n-nek, amelyre a w-t emelve 1-et kapnánk, de a w n.-ik egységgyök, akkor a w-t n.-ik primitív egységgyöknek nevezzük.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>