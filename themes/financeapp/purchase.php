<?php $v->layout("_theme"); ?>

<div style="display: flex; align-content: end; margin-bottom: 10px;">
    <a class="btn btn-blue icon-print" href="<?= url("/app/ordem-compra-print/{$order->id}"); ?>" target="_blank">Imprimir</a>
</div>

<div class="app_formbox app_widget">
    <form class="app_form" action="<?= url("/app/atualizar-ordem-compra/{$order->id}"); ?>" method="post">
        <div style="text-align: right;"><small>Criado por: <?= $order->getUser()->fullName(); ?> em <?= date("d/m/Y H:i", strtotime($order->created_at)); ?></small>
        </div>
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
                <input class="radius" type="number" name="amount" required value="<?= $order->amount; ?>" />
            </label>
            <label>
                <span class="field icon-check">Obra:</span>
                <input class="radius" type="text" name="job" required value="<?= $order->job; ?>" />
            </label>
        </div>

        <div class="label_group">
            <label>
                <span class="field"><img src="<?= theme("/assets/images/icon-truck.png", 'financeapp'); ?>" style="margin-bottom: -15px; margin-top: -15px;">Fornecedor:</span>
                <input class="radius" type="text" name="provider" value="<?= $order->provider; ?>" />
            </label>

            <label>
                <span class="field icon-money">Valor:</span>
                <input class="radius mask-money" type="text" name="value" required value="<?= $order->value; ?>" />
            </label>
        </div>

        <div class="label_group">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material" required value="<?= $order->material; ?>" />
            </label>
            <?php if ($order->material_1 == null) : ?>
                <button class="btn radius transition icon-plus add-material" data-show="material_1">Mais material</button>
            <?php endif; ?>
        </div>

        <?php for ($i = 1; $i < 50; $i++) : ?>
            <div class="label_group <?= $order->{'material_' . $i} == null ? 'material_input' : ''; ?> " id="material_<?= $i; ?>">
                <label>
                    <span class="field icon-check">Material:</span>
                    <input class="radius" type="text" name="<?= 'material_' . $i; ?>" value="<?= $order->{'material_' . $i}; ?>" />
                </label>
                <?php if ($order->{'material_' . ($i + 1)} == null) : ?>
                    <button class="btn radius transition icon-plus add-material" data-show="material_<?= ($i + 1); ?>">Mais material</button>
                <?php endif; ?>
            </div>
        <?php endfor; ?>

        <div class="label_group <?= $order->material_50 == null ? 'material_input' : ''; ?> " id="material_50">
            <label>
                <span class="field icon-check">Material:</span>
                <input class="radius" type="text" name="material_50" value="<?= $order->material_50; ?>" />
            </label>
        </div>

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
                    <option <?= ($order->status == 'Executada' ? "selected" : ""); ?> value="Executada">&ofcir;Executada</option>
                    <option <?= ($order->status == 'Não executada' ? "selected" : ""); ?> value="Não executada">&ofcir;Não executada</option>
                </select>
            </label>
        </div>

        <label>
            <span class="field">Anexo:
                <?php if ($order->file) : ?>
                    <a href="<?= urlStorage($order->file); ?>" class="icon-download" style="text-decoration: none;" title="Download"></a>
                <?php endif; ?>
            </span>
            <input type="file" id="file" name="file">
        </label>

        <div class="al-center">
            <div class="app_formbox_actions">
                <span data-invoiceremove="<?= url("/app/remover-ordem-compra/{$order->id}"); ?>" class="btn_remove transition icon-error">Excluir</span>
                <button class="btn btn_inline radius transition icon-pencil-square-o">Atualizar</button>
                <a class="btn_back transition radius icon-sign-in" href="<?= url("/app/ordem-compra"); ?>" title="Voltar">Voltar</a>
            </div>
        </div>
    </form>
</div>