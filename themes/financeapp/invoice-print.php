<?php $v->layout("_theme-print"); ?>
<h2 style="text-align: center; margin: -30px 0 5px 0;"><?= $invoice->type == 'income' ? 'Recebimento' : ($invoice->type == 'expense' ? 'Pagamento' : 'Reembolso'); ?></h2>
<div class="app_formbox app_widget">
    <form class="app_form">
        <div style="text-align: right;"><small>Criado por: <?= $invoice->getUser()->fullName(); ?> em <?= date("d/m/Y H:i", strtotime($invoice->created_at)); ?></small>
        </div>
        <label>
            <span class="field icon-leanpub">Descrição:</span>
            <input class="radius" type="text" name="description" value="<?= $invoice->description; ?>" required />
        </label>

        <div class="label_group">
            <label>
                <span class="field icon-money">Valor:</span>
                <input class="radius mask-money" type="text" name="value" value="<?= $invoice->value; ?>" required />
            </label>

            <label>
                <span class="field icon-filter">Dia de vencimento:</span>
                <input class="radius masc-date" type="text" name="due_day" name="value" min="1" max="<?= date("t", strtotime($invoice->due_at)); ?>" value="<?= date_fmt($invoice->due_at, "d/m/Y"); ?>" required />
            </label>
        </div>

        <label>
            <span class="field icon-briefcase">Empresa:</span>
            <select name="wallet">
                <?php foreach ($wallets as $wallet) : ?>
                    <option <?= ($wallet->id == $invoice->wallet_id ? "selected" : ""); ?> value="<?= $wallet->id; ?>"><?= $wallet->wallet; ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <?php if ($invoice->type == 'expense') : ?>
            <label>
                <span class="field icon-credit-card">Método de pagamento:</span>
                <select name="purchase_mode">
                    <option <?= ($invoice->purchase_mode == 'Boleto' ? "selected" : ""); ?> value="Boleto">Boleto</option>
                    <option <?= ($invoice->purchase_mode == 'Cartão de Crédito' ? "selected" : ""); ?> value="Cartão de Crédito">Cartão de Crédito</option>
                    <option <?= ($invoice->purchase_mode == 'Dinheiro' ? "selected" : ""); ?> value="Dinheiro">Dinheiro</option>
                    <option <?= ($invoice->purchase_mode == 'Pix' ? "selected" : ""); ?> value="Pix">Pix</option>
                    <option <?= ($invoice->purchase_mode == 'Transferência' ? "selected" : ""); ?> value="Transferência">Transferência</option>
                </select>
            </label>
        <?php endif; ?>

        <div class="label_group">
            <label>
                <span class="field icon-filter">Categoria:</span>
                <input type="text" name="category" required value="<?= $invoice->category; ?>" />
            </label>

            <label>
                <span class="field icon-filter">Status:</span>
                <select name="status">
                    <?php if ($invoice->type == "fixed_income" || $invoice->type == "fixed_expense") : ?>
                        <option <?= ($invoice->status != 'paid' ?: "selected"); ?> value="paid">Ativa</option>
                        <option <?= ($invoice->status != 'unpaid' ?: "selected"); ?> value="unpaid">Inativa
                        </option>
                    <?php else : ?>
                        <option <?= ($invoice->status == 'paid' ? "selected" : ""); ?> value="paid"><?= ($invoice->type == 'income' ? "Recebida" : "Paga"); ?></option>
                        <option <?= ($invoice->status == 'unpaid' ? "selected" : ""); ?> value="unpaid"><?= ($invoice->type == 'income' ? "Não recebida" : "Não paga"); ?></option>
                    <?php endif; ?>
                </select>
            </label>

        </div>

        <label>
            <span class="field">Anotação:</span>
            <input class="radius" type="text" name="annotation" value="<?= $invoice->annotation; ?>" />
        </label>
    </form>
    <p style="text-align: right; font-size: 8px;">Impresso em <?= strftime('%A, %d de %B de %Y', strtotime('today')); ?></p>
</div>