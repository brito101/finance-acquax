<?php $v->layout("_theme"); ?>

<!--FEATURED-->
<article class="home_featured">
    <div class="home_featured_content container content">
        <header class="home_featured_header">
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <h1 data-anime="400" class="fadeInDown">Contas a pagar e receber? Comece a controlar!</h1>
            <p data-anime="800" class="fadeInDown">Cadastre-se, lance suas contas e conte com automações poderosas para gerenciar tudo!</p>
        </header>
    </div>

    <div class="home_featured_app">
        <img src="<?= theme("/assets/images/home-app.png"); ?>" alt="<?= CONF_SITE_NAME; ?>" title="<?= CONF_SITE_NAME; ?>" />
    </div>
</article>

<!--FEATURES-->
<div class="home_features">
    <section class="container content">
        <header class="home_features_header">
            <h2>O que você pode fazer com o <?= CONF_SITE_NAME; ?>?</h2>
            <p>São 3 paços simples para você começar a controlar suas contas. É tudo muito fácil, veja:</p>
        </header>

        <div class="home_features_content">
            <article class="radius">
                <header>
                    <img alt="Contas a receber" title="Contas a receber" src="<?= theme("/assets/images/home_receive.jpg"); ?>" />
                    <h3>Contas a receber</h3>
                    <p>Cadastre seus recebíveis, use as automações para salários, contratos e recorrentes e comece a
                        controlar tudo que entra em sua conta. É rápido!</p>
                </header>
            </article>

            <article class="radius">
                <header>
                    <img alt="Contas a pagar" title="Contas a pagar" src="<?= theme("/assets/images/home_pay.jpg"); ?>" />
                    <h3>Contas a pagar</h3>
                    <p>Cadastre suas contas a pagar, despesas, use as automações para contas fixas e parcelamentos e
                        controle tudo que sai de sua conta. É simples!</p>
                </header>
            </article>

            <article class="radius">
                <header>
                    <img alt="Controle e relatórios" title="Controle e relatórios" src="<?= theme("/assets/images/home_control.jpg"); ?>" />
                    <h3>Controle e relatórios</h3>
                    <p>Contas e recebíveis cadastrados? Pronto, agora você tem tudo controlado. É gratuito!</p>
                </header>
            </article>
        </div>
    </section>
</div>