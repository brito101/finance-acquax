<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php if ($cookieConsent == 'accept') : ?>
        <?= $v->insert('partials/gtm-head'); ?>
    <?php endif; ?>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="mit" content="2019-11-01T22:48:46-03:00+169593">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <?= $head; ?>

    <link rel="icon" type="image/png" href="<?= theme("/assets/images/favicon.png"); ?>" />
    <link rel="stylesheet" href="<?= theme("/assets/style.css"); ?>" />

    <!--ANDROID-->
    <link rel="manifest" href="/../manifest.json" />
    <meta name="theme_color" content="#f38321" />
    <!--<link rel="shortcut icon" href="/../images/icons/icon-512x512.png"/>-->

    <!--IOS-->
    <meta name="apple-mobile-web-app-capable" content="true" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <link rel="apple-touch-icon" href="/../images/icons/icon-512x512.png" />
    <link rel="apple-touch-startup-image" href="/../images/icons/icon-512x512.png" />
</head>

<body>

    <?php if ($cookieConsent == 'accept') : ?>
        <?= $v->insert('partials/gtm-body'); ?>
    <?php endif; ?>


    <div class="ajax_load">
        <div class="ajax_load_box">
            <div class="ajax_load_box_circle"></div>
            <p class="ajax_load_box_title">Aguarde, carregando...</p>
        </div>
    </div>

    <!--HEADER-->
    <header class="main_header">
        <div class="container">
            <div class="main_header_logo">
                <h1><a title="Home" href="<?= url(); ?>"><img src="<?= theme("/assets/images/logo.png"); ?>" alt="<?= CONF_SITE_NAME; ?>" width="75" style="padding: 0 10px 0 0; margin-bottom: -20px;" />Finance<b>GAB</b></a></h1>
            </div>

            <nav class="main_header_nav">
                <span class="main_header_nav_mobile j_menu_mobile_open icon-menu icon-notext radius transition"></span>
                <div class="main_header_nav_links j_menu_mobile_tab">
                    <span class="main_header_nav_mobile_close j_menu_mobile_close icon-error icon-notext transition"></span>
                    <a class="link transition radius home" title="Home" href="<?= url(); ?>">Home</a>
                    <?php if (\Source\Models\Auth::user()) : ?>
                        <a class="link login transition radius icon-money" title="Controlar" href="<?= url("/app"); ?>">Controlar</a>
                    <?php else : ?>
                        <a class="link login transition radius icon-sign-in" title="Entrar" href="<?= url("/entrar"); ?>">Entrar</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>

    <!--CONTENT-->
    <main class="main_content">
        <?= $v->section("content"); ?>
    </main>


    <!--FOOTER-->
    <footer class="main_footer">
        <div class="container content">
            <section class="main_footer_content">
                <article class="main_footer_content_item">
                    <h2>Sobre:</h2>
                    <p>O <?= CONF_SITE_NAME; ?> é um gerenciador de contas simples, poderoso e gratuito. O prazer de ter o controle total de suas contas.</p>
                    <a title="Termos de uso" href="<?= url("/termos"); ?>">Termos de uso</a>

                </article>

                <article class="main_footer_content_item">
                    <h2>Mais:</h2>
                    <a class="link transition radius" title="Home" href="<?= url(); ?>">Home</a>

                    <a class="link transition radius" title="Entrar" href="<?= url("/entrar"); ?>">Entrar</a>
                </article>

                <article class="main_footer_content_item">
                    <h2>Contato:</h2>
                    <p class="icon-phone"><b>Telefone:</b><br> 4003-7945</p>
                    <p class="icon-envelope"><b>Email:</b><br> comercial@acquaxdobrasil.com.br</p>
                    <p class="icon-map-marker"><b>Endereço:</b><br> Vitória, ES/Brasil</p>
                </article>
            </section>
        </div>
    </footer>

    <!--cookie consent notification-->
    <?php if (!$cookieConsent) : ?>
        <div id="cookieConsent" class="al-center">
            <div class="container">
                <p>Este website utiliza cookies próprios e de terceiros a fim de personalizar o conteúdo, melhorar a experiência do usuário, fornecer funções de mídias sociais e analisar o tráfego. Para continuar navegando você deve concordar com nossa
                    <a href="<?= $router->route('web.terms'); ?>">Política de Privacidade</a>
                </p>
                <a data-action="<?= $router->route('web.cookie.consent'); ?>" data-cookie="accept" href="#" class="footer_optout_btn gradient gradient-green gradient-hover radius icon-check">
                    Sim, eu aceito.
                </a>
                <a data-action="<?= $router->route('web.cookie.consent'); ?>" data-cookie="decline" href="#" class="footer_optout_btn gradient gradient-red gradient-hover radius icon-error">
                    Não, eu não aceito.
                </a>
            </div>
        </div>
    <?php endif; ?>
    <!--/cookie consent notification-->

    <script data-ad-client="ca-pub-5215287632125939" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-155005524-2"></script>
    <script src="<?= theme("/assets/scripts.js"); ?>"></script>
    <?= $v->section("scripts"); ?>
    <script>
        $('#cookieConsent').find('[data-action]').click(function(e) {
            e.preventDefault();

            let action = $(this).data('action');

            $.post(action, {
                cookie: $(this).data('cookie')
            }, function(response) {
                if (response.cookie) {
                    $('#cookieConsent').slideUp('normal', function() {
                        $(this).remove();
                    });
                }

                if (response.gtmHead) {
                    $('head').prepend(response.gtmHead);
                }

                if (response.gtmBody) {
                    $('body').prepend(response.gtmBody);
                }
            }, 'json');
        });
    </script>
    <script>
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('sw.js').then(function(registration) {
                // Registration was successful
                console.log('ServiceWorker registration successful with scope: ', registration.scope);
            }, function(err) {
                // registration failed :(
                console.log('ServiceWorker registration failed: ', err);
            });
        });
    </script>

</body>

</html>