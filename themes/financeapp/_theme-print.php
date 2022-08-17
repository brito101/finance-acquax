<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="<?= theme("/assets/style.css", CONF_VIEW_APP); ?>" />
    <link rel="icon" type="image/png" href="<?= theme("/assets/images/favicon.png", CONF_VIEW_APP); ?>" />
</head>

<style>
    * {
        background-color: #fff;
    }

    @page {
        size: A4 portrait;
        margin: 1cm 0 0 0;
    }
</style>

<body>

    <div class="app" style="padding: 0;">
        <header class="app_header">
            <h1><a href="<?= url("/app"); ?>" title="<?= CONF_SITE_NAME; ?>"> <img src="<?= theme("/assets/images/logo.png", 'financeapp'); ?>" alt="<?= CONF_SITE_NAME; ?>" width="50" style="margin-right: 10px; margin-bottom: -15px;" /><?= CONF_SITE_NAME; ?></a></h1>
        </header>

        <div class="app_box">
            <main class="app_main">
                <?= $v->section("content"); ?>
            </main>
        </div>
    </div>

    <script src="<?= theme("/assets/scripts.js", CONF_VIEW_APP); ?>"></script>

    <script>
        window.onload = function() {
            window.print();
            window.close();
        }
    </script>
</body>

</html>