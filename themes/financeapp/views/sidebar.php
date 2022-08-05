<div class="app_sidebar_nav">
    <a class="icon-home radius transition" title="Dashboard" href="<?= url("/app"); ?>">Controle</a>
    <a class="icon-calendar-check-o radius transition" title="Receber" href="<?= url("/app/reembolso"); ?>">Reembolso</a>
    <?php if (user()->level == 5) : ?>
        <a class="icon-briefcase radius transition " title="Empresas" href="<?= url("/app/empresas"); ?>">Empresas</a>
        <a class="icon-user radius transition " title="Gerenciar Usuários" href="<?= url("/app/usuarios/home"); ?>">Gerenciar Usuários</a>
        <a class="icon-calendar-check-o radius transition" title="Receber" href="<?= url("/app/receber"); ?>">Receber</a>
    <?php endif; ?>
    <a class="icon-calendar-minus-o radius transition " title="Pagar" href="<?= url("/app/pagar"); ?>">Pagar</a>
    <?php if (user()->level == 5) : ?>
        <a class="icon-exchange radius transition " title="Fixas" href="<?= url("/app/fixas"); ?>">Fixas</a>
    <?php endif; ?>
    <a class="icon-money radius transition " title="Ordem de Compra" href="<?= url("/app/ordem-compra"); ?>">Ordem de Compra</a>
    <a class="icon-user radius transition" title="Perfil" href="<?= url("/app/perfil"); ?>">Perfil</a>
    <a class="icon-sign-out radius transition" title="Sair" href="<?= url("/app/sair"); ?>">Sair</a>
</div>