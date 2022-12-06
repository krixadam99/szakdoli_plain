<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Polinomok
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            A P[x] = a<sub>n</sub> * x<sup>n</sup> + ... + a<sub>1</sub> * x + a<sub>0</sub> (x <?="\u{2208}"?> <?="\u{2124}"?>) kifejezést az egészek felett értelmezett polinomnak nevezzük.
            Tulajdonképpen a polinomot felírhatjuk olyan végtelen hosszú számsorozatként, ahol véges számú nem-nulla tag van. Amennyiben az x helyére beírunk egy értelmezés tartomány béli elemet, akkor a polinomot a helyen kiértékelve megkapjuk a helyettesítési értéket.
            A polinom legmagasabb fokú tagja melletti számot a polinom főegyütthatójának, a nullad rendű tag együtthatóját pedig konstans tagnak nevezzük. Amennyiben egy értelmezési tartomány béli helyen a polinomnak a helyettesítési értéke 0, akkor azt a polinom gyökének nevezzük.
            Az algebra alaptétele szerint egy n-ed fokú komplex számtest felett értelmezett polinomnak a multiplicitásokat beleszámítva pontosan n darab gyöke van.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>
<div class="definition_holder">
    <div class="defined">
        <label class="definition_label">
            Horner- elrendezés
        </label>
    </div>
    <div class="definition first_definition">
        <label class="definition_label elliptical_definition">
            A P[x] = a<sub>n</sub> * x<sup>n</sup> + ... + a<sub>1</sub> * x + a<sub>0</sub> polinomot más alakban is fel tudjuk írni.
            Horner- elrendezés: P[x] = ((...(a<sub>n</sub> * x + a<sub>n-1</sub>)...) * x + a<sub>1</sub>) * x + a<sub>0</sub>.
            Ebből rekurzívan megkapjuk a helyettesítési értéket:<br>
            c<sub>n</sub> = a<sub>n</sub>;<br>
            c<sub>n-1</sub> = c<sub>n</sub> * x + a<sub>n-1</sub>;<br>
            c<sub>n-2</sub> = c<sub>n-1</sub> * x + a<sub>n-2</sub>;<br>
            ...<br>
            c<sub>1</sub> = c<sub>2</sub> * x + a<sub>1</sub>;<br>
            c<sub>0</sub> = c<sub>1</sub> * x + a<sub>0</sub> = P[x].
        </label>
    </div>
    <div class="definition">
        <label class="definition_label">
            Az x<sub>0</sub> behelyettesítése során tulajdonképpen megkapjuk a P[x] / (x - x<sub>0</sub>) hányadospolinomot és maradékpolinomot. A helyettesítési érték lesz a maradék, a hányadospolinomot pedig a c<sub>n</sub> * x<sup>n-1</sup> + c<sub>n-1</sub> * x<sup>n-2</sup> + ... + c<sub>1</sub> határozza meg.
        </label>
    </div>
    <button class="show_button">
        <div class="top_triangle"></div>
    </button>
</div>