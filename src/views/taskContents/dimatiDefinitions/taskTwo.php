<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Relációk
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Az (a,b) rendezett pár alatt a {{a}, {a,b}} halmazt értjük (számít a sorrend). Az A és B halmazok Descartes (direkt, vagy cartesian) szorzata egy olyan halmaz, amely olyan rendezett párokat tartalmaz, melyek első eleme az A, második eleme pedig a B halmazban van benne. Formálisan: A <?="\u{2A2F}"?> B = { (a,b): a <?="\u{2208}"?> A <?="\u{2227}"?> b <?="\u{2208}"?> B}.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Az <?="\u{2A2F}"?><sub>i=1</sub><sup>n</sup>A<sub>i</sub> halmazok Descartes- szorzatának egy (nemüres) részhalmazát a felsorolt halmazokon értelmezett relációnak nevezzük. Amennyiben csak két halmaz van, akkor a relációt binárisnak nevezzük. Ha pedig a halmazok mind ugyanazok, akkor a reláció homogén.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            <?="\u{2205}"?> <?="\u{2260}"?> R <?="\u{2286}"?> A <?="\u{2A2F}"?> B formálisan: R = { (a,b) <?="\u{2208}"?> A <?="\u{2A2F}"?> B | a <?="\u{2208}"?> A <?="\u{2227}"?> b <?="\u{2208}"?> B}. Ha az (a,b) benne van az R relációban, akkor (a,b) <?="\u{2208}"?> R, helyett gyakran az <i>a R b</i> jelölést alkalmazzuk (az a R relációban áll b-vel).
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>
<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Bináris relációk alapvető definíciói
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            Adott <?="\u{2205}"?> <?="\u{2260}"?> R <?="\u{2286}"?> A <?="\u{2A2F}"?> B. Ekkor Dom<sub>R</sub> = { a <?="\u{2208}"?> A | <?="\u{2203}"?> b <?="\u{2208}"?> B: (a,b) <?="\u{2208}"?> R}. Ezt nevezzük az <b>R reláció értelmezési tartományának</b>. Informálisan: készítünk egy halmazt az R relációt alkotó rendezett párok első elemeiből.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Adott <?="\u{2205}"?> <?="\u{2260}"?> R <?="\u{2286}"?> A <?="\u{2A2F}"?> B. Ekkor Ran<sub>R</sub> = { b <?="\u{2208}"?> B | <?="\u{2203}"?> a <?="\u{2208}"?> A: (a,b) <?="\u{2208}"?> R}. Ezt nevezzük az <b>R reláció értékkészletének</b>. Informálisan: készítünk egy halmazt az R relációt alkotó rendezett párok második elemeiből.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Adott <?="\u{2205}"?> <?="\u{2260}"?> R <?="\u{2286}"?> A <?="\u{2A2F}"?> B és az N halmaz. Ekkor R<sub>N</sub> = { (a,b) <?="\u{2208}"?> R | a <?="\u{2208}"?> N } <?="\u{2286}"?> R. Ezt nevezzük az <b>R reláció N halmazra vett megszorítása</b>. Informálisan: kivesszük azokat a rendezett párokat R-ből, amik első elemei benne vannak N-ben.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Adott <?="\u{2205}"?> <?="\u{2260}"?> R <?="\u{2286}"?> A <?="\u{2A2F}"?> B. Ekkor R<sup>-1</sup> = { (b,a) <?="\u{2208}"?> B <?="\u{2A2F}"?> A | (a,b) <?="\u{2208}"?> R } <?="\u{2286}"?> B <?="\u{2A2F}"?> A. Ezt nevezzük az <b>R reláció inverzének</b>. Informálisan: az R reláció rendezett párjainak elemeit megfordítjuk. 
            Megjegyzendő tehát, hogy Dom<sub>f<sup>-1</sup></sub> = Ran<sub>f</sub> és Ran<sub>f<sup>-1</sup></sub> = Dom<sub>f</sub>.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Adott <?="\u{2205}"?> <?="\u{2260}"?> R <?="\u{2286}"?> A <?="\u{2A2F}"?> B és az I halmaz. Ekkor R(I) = { b <?="\u{2208}"?> B | a  <?="\u{2208}"?> I <?="\u{2227}"?> (a,b) <?="\u{2208}"?> R } <?="\u{2286}"?> Ran<sub>R</sub>. Ezt nevezzük az <b>R reláció I halmazon felvett képének</b>. Informálisan: kivesszük az R reláció rendezett párjainak azon második elemeit, ahol az első elem benne van az I halmazban.
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Adott <?="\u{2205}"?> <?="\u{2260}"?> R <?="\u{2286}"?> A <?="\u{2A2F}"?> B és az D halmaz. Ekkor R<sup>-1</sup>(D) = { a <?="\u{2208}"?> A | b  <?="\u{2208}"?> D <?="\u{2227}"?> (a,b) <?="\u{2208}"?> R } <?="\u{2286}"?> Dom<sub>R</sub>. Ezt nevezzük az <b>R reláció D halmazon felvett ősképének</b>. Informálisan: kivesszük az R reláció rendezett párjainak azon első elemeit, ahol a második elem benne van a D halmazban.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>