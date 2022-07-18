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
      <p class="" style="flex-basis: 10%;">Visualizar</p>
      <p class="">Data</p>
      <p class="">Obra</p>
      <p class="">Valor</p>
      <p class="">Solicitante</p>
      <p class="">Prev Entrega</p>
    </div>

    <?php foreach ($orders as $order) : ?>
      <article class="app_launch_item">
        <p class="app_invoice_link transition" style="flex-basis: 10%;">
          <a title="<?= 'Editar ordem de compra nº ' . $order->id; ?>" href="<?= url("/app/ordem-compra/{$order->id}"); ?>"><span class='icon-pencil-square-o icon-notext'></span> <?= $order->serie; ?></a>
        </p>
        <p class="date"><?= date_fmt($order->date, "d/m/Y"); ?></p>
        <p class=""><?= $order->job; ?></p>
        <p class="price">
          <span>R$</span>
          <span><?= str_price($order->value); ?></span>
        </p>
        <p class=""><?= $order->requester; ?></p>
        <p class="date"><?= date_fmt($order->forecast, "d/m/Y"); ?></p>
      </article>
    <?php endforeach; ?>
  <?php endif; ?>