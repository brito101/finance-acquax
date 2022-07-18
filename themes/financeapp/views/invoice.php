<div class="app_modal_box app_modal_<?= $type; ?>">
    <p class="title icon-calendar-check-o"><?= ($type == 'income' ? "Nova Receita" : ($type == 'refund' ? "Novo Reembolso" : "Nova Despesa")); ?>:</p>
    <form class="app_form" action="<?= url("/app/launch"); ?>" method="post">
        <input type="hidden" name="currency" value="BRL" />
        <input type="hidden" name="type" value="<?= $type; ?>" />

        <label>
            <span class="field icon-leanpub">Descrição:</span>
            <input class="radius" type="text" name="description" placeholder="Ex: Aluguel" required />
        </label>

        <div class="label_group">
            <label>
                <span class="field icon-money">Valor:</span>
                <input class="radius mask-money" type="text" name="value" required />
            </label>

            <label>
                <span class="field icon-filter">Data:</span>
                <input class="radius masc-date" type="date" name="due_at" required />
            </label>
        </div>

        <div class="label_group">
            <label>
                <span class="field icon-briefcase">Empresa:</span>
                <select name="wallet_id">
                    <?php foreach ($wallets as $wallet) : ?>
                        <option value="<?= $wallet->id; ?>">&ofcir; <?= $wallet->wallet ?></option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label>
                <span class="field icon-filter">Categoria:</span>
                <input type="text" name="category" required />
            </label>
        </div>

        <?php if ($type == 'expense') : ?>
            <label>
                <span class="field icon-credit-card">Método de pagamento:</span>
                <select name="purchase_mode">
                    <option value="Boleto">&ofcir; Boleto</option>
                    <option value="Cartão de Crédito">&ofcir; Cartão de Crédito</option>
                    <option value="Dinheiro">&ofcir; Dinheiro</option>
                    <option value="Pix">&ofcir; Pix</option>
                    <option value="Transferência">&ofcir; Transferência</option>
                </select>
            </label>
        <?php endif; ?>

        <?php if ($type != 'refund') : ?>
            <div class="label_check">
                <p class="field icon-exchange">Repetição:</p>
                <label class="check" data-checkbox="true" data-slideup=".app_modal_<?= $type; ?> .repeate_item_fixed, .app_modal_<?= $type; ?> .repeate_item_enrollment">
                    <input type="radio" name="repeat_when" value="single" checked> Única
                </label>

                <label data-checkbox="true" data-slideup=".app_modal_<?= $type; ?> .repeate_item_enrollment" data-slidedown=".app_modal_<?= $type; ?> .repeate_item_fixed">
                    <input type="radio" name="repeat_when" value="fixed"> Fixa
                </label>

                <label data-checkbox="true" data-slideup=".app_modal_<?= $type; ?> .repeate_item_fixed" data-slidedown=".app_modal_<?= $type; ?> .repeate_item_enrollment">
                    <input type="radio" name="repeat_when" value="enrollment"> Parcelada
                </label>
            </div>

            <label class="repeate_item repeate_item_fixed" style="display: none">
                <select name="period">
                    <option value="month">&ofcir; Mensal</option>
                    <option value="year">&ofcir; Anual</option>
                </select>
            </label>

            <label class="repeate_item repeate_item_enrollment" style="display: none">
                <input class="radius" type="number" value="1" min="1" max="420" placeholder="1 parcela" name="enrollments" />
            </label>
        <?php endif; ?>

        <?php if ($type == 'refund') : ?>
            <input type="hidden" name="repeat_when" value="single">
            <input type="hidden" name="period" value="month">
            <input type="hidden" name="enrollments" value="1">
        <?php endif; ?>

        <button class="btn radius transition icon-check-square-o" <?= ($type == 'refund' ? 'style="width:100%;"' : ''); ?>>
            Lançar <?= ($type == 'income' ? "Receita" : ($type == 'refund' ? "Reembolso" : "Despesa")); ?></button>
    </form>
</div>