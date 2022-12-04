<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Relációk kompozíciója
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Adott <?="\u{2205}"?> <?="\u{2260}"?> R <?="\u{2286}"?> A <?="\u{2A2F}"?> B és <?="\u{2205}"?> <?="\u{2260}"?> S <?="\u{2286}"?> C <?="\u{2A2F}"?> D relációk, ahol az A, B, C és D halmazok nem feltétlen különbözőek. 
            Az S <?="\u{2218}"?> R kompozíció alatt a következő relációt értjük: S <?="\u{2218}"?> R = { (a,d) <?="\u{2208}"?> A <?="\u{2A2F}"?> D | <?="\u{2203}"?> b <?="\u{2208}"?> B: b <?="\u{2208}"?> C <?="\u{2227}"?> (a,b) <?="\u{2208}"?> R <?="\u{2227}"?> (b,d) <?="\u{2208}"?> S }. Például a nagybácsija reláció a testvére és szülője relációk kompozíciója. Informálisan: a jobb oldali tag rendezett párjainak második elemeit "összekötjük" a bal oldali reláció rendezett párjainak azonos első elemeivel. Majd az összekötés során kapott hármasok 1. és 3. elemeiből képzett rendezett párjai alkotják a kompozíciót. Tulajdonságok: asszociatív, valamint: (R <?="\u{2218}"?> S)<sup>-1</sup> = S<sup>-1</sup> <?="\u{2218}"?> R<sup>-1</sup>.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>
<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Homogén relációk tulajdonságai
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Adott <?="\u{2205}"?> <?="\u{2260}"?> R <?="\u{2286}"?> A <?="\u{2A2F}"?> A. Ekkor az R relációt <b>reflexívnek</b> nevezzük, ha (<?="\u{2200}"?> a <?="\u{2208}"?> A): (a,a) <?="\u{2208}"?> R.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Adott <?="\u{2205}"?> <?="\u{2260}"?> R <?="\u{2286}"?> A <?="\u{2A2F}"?> A. Ekkor az R relációt <b>irreflexívnek</b> nevezzük, ha (<?="\u{2200}"?> a <?="\u{2208}"?> A): (a,a) <?="\u{2209}"?> R.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Adott <?="\u{2205}"?> <?="\u{2260}"?> R <?="\u{2286}"?> A <?="\u{2A2F}"?> A. Ekkor az R relációt <b>szimmetrikusnak</b> nevezzük, ha (<?="\u{2200}"?> a,b <?="\u{2208}"?> A): (a,b) <?="\u{2208}"?> R <?="\u{2192}"?> (b,a) <?="\u{2208}"?> R.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Adott <?="\u{2205}"?> <?="\u{2260}"?> R <?="\u{2286}"?> A <?="\u{2A2F}"?> A. Ekkor az R relációt <b>antiszimmetrikusnak</b> nevezzük, ha (<?="\u{2200}"?> a,b <?="\u{2208}"?> A): ((a,b) <?="\u{2208}"?> R <?="\u{2227}"?> (b,a) <?="\u{2208}"?> R) <?="\u{2194}"?> (a = b).
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Adott <?="\u{2205}"?> <?="\u{2260}"?> R <?="\u{2286}"?> A <?="\u{2A2F}"?> A. Ekkor az R relációt <b>szigorúan antiszimmetrikusnak</b> nevezzük, ha (<?="\u{2200}"?> a,b <?="\u{2208}"?> A): (a,b) <?="\u{2208}"?> R <?="\u{2227}"?> (b,a) <?="\u{2209}"?> R.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Adott <?="\u{2205}"?> <?="\u{2260}"?> R <?="\u{2286}"?> A <?="\u{2A2F}"?> A. Ekkor az R relációt <b>tranzitívnak</b> nevezzük, ha (<?="\u{2200}"?> a,b,c <?="\u{2208}"?> A): ((a,b) <?="\u{2208}"?> R <?="\u{2227}"?> (b,c) <?="\u{2208}"?> R) <?="\u{2192}"?> (a,c) <?="\u{2208}"?> R.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Adott <?="\u{2205}"?> <?="\u{2260}"?> R <?="\u{2286}"?> A <?="\u{2A2F}"?> A. Ekkor az R relációt <b>dichotómnak</b> nevezzük, ha (<?="\u{2200}"?> a,b <?="\u{2208}"?> A)(a <?="\u{2260}"?> b): (a,b) <?="\u{2208}"?> R <?="\u{2228}"?> (b,a) <?="\u{2208}"?> R közül legalább az egyik teljesül.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Adott <?="\u{2205}"?> <?="\u{2260}"?> R <?="\u{2286}"?> A <?="\u{2A2F}"?> A. Ekkor az R relációt <b>trichotómnak</b> nevezzük, ha (<?="\u{2200}"?> a,b <?="\u{2208}"?> A): (a,b) <?="\u{2208}"?> R <?="\u{2228}"?> (b,a) <?="\u{2208}"?> R <?="\u{2228}"?> a = b közül pontosan egy teljesül.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Adott <?="\u{2205}"?> <?="\u{2260}"?> R <?="\u{2286}"?> A <?="\u{2A2F}"?> A. Ekkor az R relációt <b>ekvivalencia relációnak</b> nevezzük, ha reflexív, szimmetrikus és tranzitív. 
            Legyen a ~ reláció ekvivalencia reláció, ekkor meghatározhatunk az alaphalmazán egy osztályozást. Ez egy olyan szuperhalmaz, amelyben a halmazok diszjunktak, nem üresek és uniójuk kiadja az alaphalmazt.
            Egy osztály: [x] = { y | y ~ x } = {y | (y,x) <?="\u{2208}"?> ~}.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Adott <?="\u{2205}"?> <?="\u{2260}"?> R <?="\u{2286}"?> A <?="\u{2A2F}"?> A. Ekkor az R relációt <b>részben rendezési relációnak</b> nevezzük, ha reflexív, antiszimmetrikus és tranzitív. Ha emellett még irreflexív is, akkor <b>szigorú részben rendezési reláció</b> az R.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Adott <?="\u{2205}"?> <?="\u{2260}"?> R <?="\u{2286}"?> A <?="\u{2A2F}"?> A. Ekkor az R relációt <b>rendezési relációnak</b> nevezzük, ha részben rendezés és dichotóm. Ha emellett még irreflexív is, akkor <b>szigorú rendezési reláció</b> az R.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>