<?php $v->layout("_theme-print"); ?>
<h2 style="text-align: center; margin: -30px 0 5px 0;">Ordem de Compra</h2>
<div class="app_formbox app_widget">
    <form class="app_form">
        <div class="label_group">
            <label>
                <span class="field icon-filter">Nº de Série:</span>
                <input type="text" value="<?= $order->serie; ?>" name="serie" required />
            </label>
            <label>
                <span class="field icon-filter">Data:</span>
                <input type="text" class="mask-date" value="<?= date_fmt($order->date, "d/m/Y"); ?>" name="date" placeholder="dd/mm/aaaa" maxlength="10" />
            </label>
        </div>

        <div class="label_group">
            <label>
                <span class="field icon-plus">Quantidade:</span>
                <input class="radius" type="text" name="amount" required value="<?= $order->amount; ?>" />
            </label>
            <label>
                <span class="field icon-check">Obra:</span>
                <input class="radius" type="text" name="job" required value="<?= $order->job; ?>" />
            </label>
        </div>

        <div class="label_group">
            <label>
                <span class="field icon-plus">Fornecedor:</span>
                <input class="radius" type="text" name="provider" value="<?= $order->provider; ?>" />
            </label>

            <label>
                <span class="field icon-money">Valor:</span>
                <input class="radius mask-money" type="text" name="value" required value="<?= $order->value; ?>" />
            </label>
        </div>

        <div class="label_group">
            <label style="flex-basis: 100%;">
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material" required value="<?= $order->material; ?>" />
            </label>
        </div>

        <?php for ($i = 1; $i <= 50; $i++) : ?>
            <div class="label_group <?= $order->{'material_' . $i} == null ? 'material_input' : ''; ?> " id="material_<?= $i; ?>">
                <label style="flex-basis: 100%;">
                    <span class="field icon-check">Material:</span>
                    <input class="radius" type="text" name="<?= 'material_' . $i; ?>" value="<?= $order->{'material_' . $i}; ?>" />
                </label>
            </div>
        <?php endfor; ?>

        <div class="label_group">
            <label>
                <span class="field icon-check">Solicitante:</span>
                <input class="radius" type="text" name="requester" required value="<?= $order->requester; ?>" />
            </label>
            <label>
                <span class="field icon-check">Nº Nota Fiscal:</span>
                <input class="radius" type="text" name="invoice" />
            </label>
        </div>

        <div class="label_group">
            <label>
                <span class="field icon-filter">Previsão de Entrega:</span>
                <input class="radius masc-date" type="text" name="forecast" required value="<?= date_fmt($order->forecast, "d/m/Y"); ?>" placeholder="dd/mm/aaaa" maxlength="10" />
            </label>
            <label>
                <span class="field icon-plus">Autorizado Por:</span>
                <input class="radius" type="text" name="authorized" required value="<?= $order->authorized; ?>" />
            </label>
        </div>

        <div class="label_group">
            <label>
                <span class="field icon-filter">Data de Autorização:</span>
                <input class="radius masc-date" type="text" name="authorized_date" required value="<?= date_fmt($order->authorized_date, "d/m/Y"); ?>" placeholder="dd/mm/aaaa" maxlength="10" />
            </label>
            <label>
                <span class="field icon-plus">Frete:</span>
                <input class="radius" type="text" name="freight" value="<?= $order->freight; ?>" />
            </label>
        </div>
        <div class="label_group">
            <label>
                <span class="field icon-money">Forma de Pagamento:</span>
                <input class="radius" type="text" name="payment" value="<?= $order->payment; ?>" />
            </label>
            <label>
                <span class="field icon-check">Status:</span>
                <select name="status">
                    <option <?= ($order->status == 'Executada' ? "selected" : ""); ?> value="Executada">Executada</option>
                    <option <?= ($order->status == 'Não executada' ? "selected" : ""); ?> value="Não executada">Não executada</option>
                </select>
            </label>
        </div>
    </form>
    <p style="text-align: right; font-size: 8px;">Impresso em <?= strftime('%A, %d de %B de %Y', strtotime('today')); ?></p>
</div>