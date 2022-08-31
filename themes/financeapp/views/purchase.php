<div class="app_modal_box app_modal_order">
    <p class="title icon-calendar-check-o">Ordem de Compra:</p>
    <form class="app_form" action="<?= url("/app/ordem-compra"); ?>" method="post">

        <label>
            <span class="field icon-check">Nº de série:</span>
            <input class="radius" type="text" name="serie" required />
        </label>

        <div class="label_group">
            <label>
                <span class="field icon-filter">Data:</span>
                <input class="radius masc-date" type="date" name="date" required />
            </label>
            <label>
                <span class="field icon-plus">Quantidade:</span>
                <input class="radius" type="number" name="amount" required />
            </label>
        </div>

        <div class="label_group">
            <label>
                <span class="field icon-check">Obra:</span>
                <input class="radius" type="text" name="job" required />
            </label>
            <label>
                <span class="field"><img src="<?= theme("/assets/images/icon-truck.png", 'financeapp'); ?>" style="margin-bottom: -15px; margin-top: -15px;">Fornecedor:</span>
                <input class="radius" type="text" name="provider" />
            </label>
        </div>

        <div class="label_group">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material" required />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_1">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_1">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_1" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_2">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_2">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_2" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_3">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_3">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_3" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_4">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_4">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_4" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_5">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_5">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_5" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_6">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_6">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_6" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_7">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_7">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_7" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_8">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_8">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_8" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_9">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_9">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_9" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_10">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_10">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_10" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_11">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_11">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_11" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_12">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_12">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_12" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_13">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_13">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_13" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_14">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_14">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_14" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_15">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_15">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_15" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_16">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_16">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_16" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_17">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_17">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_17" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_18">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_18">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_18" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_19">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_19">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_19" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_20">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_20">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_20" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_21">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_21">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_21" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_22">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_22">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_22" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_23">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_23">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_23" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_24">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_24">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_24" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_25">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_25">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_25" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_26">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_26">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_26" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_27">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_27">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_27" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_28">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_28">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_28" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_29">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_29">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_29" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_30">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_30">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_30" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_31">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_31">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_31" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_32">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_32">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_32" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_33">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_33">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_33" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_34">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_34">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_34" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_35">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_35">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_35" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_36">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_36">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_36" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_37">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_37">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_37" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_38">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_38">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_38" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_39">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_39">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_39" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_40">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_40">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_40" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_41">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_41">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_41" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_42">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_42">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_42" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_43">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_43">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_43" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_44">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_44">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_44" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_45">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_45">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_45" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_46">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_46">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_46" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_47">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_47">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_47" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_48">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_48">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_48" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_49">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_49">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_49" />
            </label>
            <button class="btn radius transition icon-plus add-material" data-show="material_50">Mais material</button>
        </div>

        <div class="label_group material_input" id="material_50">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_50" />
            </label>
        </div>

        <div class="label_group">
            <label>
                <span class="field icon-check">Nº Nota Fiscal:</span>
                <input class="radius" type="text" name="invoice" />
            </label>
            <label>
                <span class="field icon-money">Valor:</span>
                <input class="radius mask-money" type="text" name="value" />
            </label>
        </div>

        <label>
            <span class="field icon-check">Solicitante:</span>
            <input class="radius" type="text" name="requester" required />
        </label>

        <div class="label_group">
            <label>
                <span class="field icon-filter">Previsão de Entrega:</span>
                <input class="radius masc-date" type="date" name="forecast" required />
            </label>
            <label>
                <span class="field icon-plus">Autorizado Por:</span>
                <input class="radius" type="text" name="authorized" required />
            </label>
        </div>

        <div class="label_group">
            <label>
                <span class="field icon-filter">Data de Autorização:</span>
                <input class="radius masc-date" type="date" name="authorized_date" required />
            </label>
            <label>
                <span class="field icon-plus">Frete:</span>
                <input class="radius" type="text" name="freight" />
            </label>
        </div>

        <label>
            <span class="field icon-money">Forma de Pagamento:</span>
            <input class="radius" type="text" name="payment" />
        </label>

        <label>
            <span class="field icon-check">Status:</span>
            <select name="status">
                <option value="Executada">&ofcir;Executada</option>
                <option value="Não executada">&ofcir;Não executada</option>
            </select>
        </label>

        <label>
            <span class="field">Anexo:</span>
            <input type="file" id="file" name="file">
        </label>

        <button class="btn radius transition icon-check-square-o">Enviar</button>
    </form>
</div>