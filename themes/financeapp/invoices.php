<?php $v->layout("_theme"); ?>

<div class="app_launch_header">
    <form class="app_launch_form_filter app_form" action="<?= url("/app/filter"); ?>" method="post">
        <input type="hidden" name="filter" value="<?= $type; ?>" />

        <select name="status">
            <option value="all" <?= (empty($filter->status) ? "selected" : ""); ?>>Todas</option>
            <option value="paid" <?= (!empty($filter->status) && $filter->status == "paid" ? "selected" : ""); ?>><?= ($type == 'income' ? "Receitas recebidas" : ($type == 'refund' ? "Reembolsos recebidos" : "Despesas pagas")); ?></option>
            <option value="unpaid" <?= (!empty($filter->status) && $filter->status == "unpaid" ? "selected" : ""); ?>><?= ($type == 'income' ? "Receitas não recebidas" : ($type == 'refund' ? "Reembolsos não recebidos" : "Despesas não pagas")); ?></option>
        </select>

        <input type="text" name="category" placeholder="Categoria...">


        <input list="datelist" type="text" class="radius mask-month" name="date" placeholder="<?= (!empty($filter->date) ? $filter->date : date("m/Y")); ?>">

        <datalist id="datelist">
            <?php for ($range = -2; $range <= 2; $range++) :
                $dateRange = date("m/Y", strtotime(date("Y-m-01") . "+{$range}month"));
            ?>
                <option value="<?= $dateRange; ?>" />
            <?php endfor; ?>
        </datalist>

        <button class="filter radius transition icon-filter icon-notext"></button>
    </form>

    <div class="app_launch_btn <?= $type; ?> radius transition icon-plus-circle" data-modalopen=".app_modal_<?= $type; ?>">Lançar
        <?= ($type == "income" ? "Receita" : ($type == "refund" ? "Reembolso" : "Despesa")); ?>
    </div>
</div>

<section class="app_launch_box">
    <?php if (!$invoices) : ?>
        <?php if (empty($filter->status)) : ?>
            <div class="message info icon-info">Ainda não existem <?= ($type == "income" ? "contas a receber" : ($type == "refund" ? "reembolsos" : "contas a pagar")); ?>
                . Comece lançando <?= ($type == "income" ? "suas receitas" : ($type == "refund" ? "seus reembolsos" : "suas despesas")); ?>.
            </div>
        <?php else : ?>
            <div class="message info icon-info">Não existem <?= ($type == "income" ? "contas
                a receber" : ($type == "refund" ? "reembolsos" : "contas a pagar")); ?>
                para o filtro aplicado.
            </div>
        <?php endif; ?>
    <?php else : ?>
        <div class="app_launch_item header">
            <p style="flex-basis: 25%;">Descrição</p>
            <p style="flex-basis: 15%;">Data</p>
            <p class="category" style="flex-basis: 15%;">Categoria</p>
            <?php if ($type != 'refund') : ?>
                <p class="enrollment" style="flex-basis: 15%;">Parcela</p>
            <?php endif; ?>
            <p style="flex-basis: 15%;">Anexo</p>
            <p class="price" style="flex-basis: 15%;">Valor</p>
        </div>
        <?php
        $unpaid = 0;
        $paid = 0;
        foreach ($invoices as $invoice) :
        ?>
            <article class="app_launch_item">
                <p class="desc app_invoice_link transition" style="flex-basis: 25%;">
                    <a title="<?= $invoice->description; ?>" href="<?= url("/app/fatura/{$invoice->id}"); ?>"><?= str_limit_words($invoice->description, 3, "&nbsp;<span class='icon-info icon-notext'></span>") ?></a>
                </p>
                <p class="date" style="flex-basis: 15%;">Dia <?= date_fmt($invoice->due_at, "d"); ?></p>
                <p class="category" style="flex-basis: 15%;"><?= $invoice->category; ?></p>
                <?php if ($type != 'refund') : ?>
                    <p class="enrollment" style="flex-basis: 15%;">
                        <?php if ($invoice->repeat_when == "fixed") : ?>
                            <span class="app_invoice_link">
                                <a href="<?= url("/app/fatura/{$invoice->invoice_of}"); ?>" class="icon-exchange" title="Controlar Conta Fixa">Fixa</a>
                            </span>
                        <?php elseif ($invoice->repeat_when == 'enrollment') : ?>
                            <span class="app_invoice_link" style="flex-basis: 15%;">
                                <a href="<?= url("/app/fatura/{$invoice->invoice_of}"); ?>" title="Controlar Parcelamento"><?= str_pad($invoice->enrollment_of, 2, 0, 0); ?> de <?= str_pad($invoice->enrollments, 2, 0, 0); ?></a>
                            </span>
                        <?php else : ?>
                            <span class="icon-calendar-check-o" style="flex-basis: 15%;">Única</span>
                        <?php endif; ?>
                    </p>
                <?php endif; ?>
                <p style="flex-basis: 15%;">
                    <?php if ($invoice->file) : ?>
                        <a href="<?= urlStorage($invoice->file); ?>" class="icon-download" style="text-decoration: none;" title="Download"></a>
                    <?php else : ?>
                        -
                    <?php endif; ?>
                </p>
                <p class="price" style="flex-basis: 15%;">
                    <span>R$</span>
                    <span><?= str_price($invoice->value); ?></span>
                    <?php if ($invoice->status == 'unpaid') : $unpaid += $invoice->value; ?>
                        <span class="check <?= $type; ?> icon-thumbs-o-down transition" data-toggleclass="active icon-thumbs-o-down icon-thumbs-o-up" data-onpaid="<?= url("/app/onpaid"); ?>" data-date="<?= ($filter->date ?? date("m/Y")); ?>" data-invoice="<?= $invoice->id; ?>"></span>
                    <?php else : $paid += $invoice->value; ?>
                        <span class="check <?= $type; ?> icon-thumbs-o-up transition" data-toggleclass="active icon-thumbs-o-down icon-thumbs-o-up" data-onpaid="<?= url("/app/onpaid"); ?>" data-date="<?= ($filter->date ?? date("m/Y")); ?>" data-invoice="<?= $invoice->id; ?>"></span>
                    <?php endif; ?>
                </p>

            </article>
        <?php endforeach; ?>

        <div class="app_launch_item footer">
            <p class="icon-thumbs-o-down j_total_unpaid">R$ <?= str_price($unpaid); ?></p>
            <p class="icon-thumbs-o-up j_total_paid">R$ <?= str_price($paid); ?></p>
        </div>
    <?php endif; ?>
</section>