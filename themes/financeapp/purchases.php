<?php $v->layout("_theme"); ?>

<div class="app_main_right" style="margin: 0;">
  <ul class="app_widget_shortcuts">
    <li class="income radius transition" data-modalopen=".app_modal_order">
      <p class="icon-plus-circle">Ordem de Compra</p>
    </li>
  </ul>
</div>

<section class="app_launch_box">
  <?php if (!$orders) : ?>
    <div class="message info icon-info">Ainda não existem Ordens de Compra cadastradas</div>
  <?php else : ?>
    <div class="app_launch_item header">
      <p style="flex-basis: 20%;">Visualizar</p>
      <p style="flex-basis: 13%;">Data</p>
      <p style="flex-basis: 15%;">Obra</p>
      <p style="flex-basis: 15%;">Solicitante</p>
      <p style="flex-basis: 13%;">Entrega</p>
      <p style="flex-basis: 9%;">Anexo</p>
      <p style="flex-basis: 15%;">Valor</p>
    </div>

    <?php foreach ($orders as $order) : ?>
      <article class="app_launch_item">
        <p class="app_invoice_link transition" style="flex-basis: 20%; text-align: left;">
          <a title="<?= 'Editar ordem de compra nº ' . $order->id; ?>" href="<?= url("/app/ordem-compra/{$order->id}"); ?>">
            <?php if ($order->status == 'Executada') : ?>
              <span class='icon-check icon-notext' style="color: green;"></span>
            <?php else : ?>
              <span class='icon-times-circle icon-notext' style="color: red;"></span>
            <?php endif; ?>
            <?= $order->serie; ?></a>
        </p>
        <p class="date" style="flex-basis: 13%;"><?= date_fmt($order->date, "d/m/Y"); ?></p>
        <p style="flex-basis: 15%;"><?= $order->job; ?></p>
        <p style="flex-basis: 15%;"><?= $order->requester; ?></p>
        <p class="date" style="flex-basis: 13%;"><?= date_fmt($order->forecast, "d/m/Y"); ?></p>
        <p style="flex-basis: 9%;">
          <?php if ($order->file) : ?>
            <a href="<?= urlStorage($order->file); ?>" class="icon-download" style="text-decoration: none;" title="Download"></a>
          <?php else : ?>
            -
          <?php endif; ?>
        </p>
        <p style="flex-basis: 15%;">R$ <?= str_price($order->value); ?>
        </p>
      </article>
    <?php endforeach; ?>
  <?php endif; ?>