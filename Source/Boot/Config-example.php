<?php

date_default_timezone_set("America/Sao_Paulo");

/**
 * DATABASE
 */
define("CONF_DB_HOST", "localhost");
define("CONF_DB_USER", "root");
define("CONF_DB_PASS", "");
define("CONF_DB_NAME", "financecontrol");

/**
 * PROJECT URLs
 */
define("CONF_URL_BASE", "https://www.localhost/financecontrol");
define("CONF_URL_TEST", "https://www.localhost/financecontrol");

/**
 * SITE
 */
define("CONF_SITE_NAME", "FinanceGAB");
define("CONF_SITE_TITLE", "Gerencie suas contas");
define(
        "CONF_SITE_DESC",
        "O FinanceGAB é um gerenciador de contas simples, poderoso e gratuito. O prazer de ter o controle total de suas contas."
);
define("CONF_SITE_LANG", "pt_BR");
define("CONF_SITE_DOMAIN", "financecontrol.rodrigobrito.dev.br");
define("CONF_SITE_ADDR_STREET", "RJ - Rua General Miguel Ferreira");
define("CONF_SITE_ADDR_NUMBER", "178");
define("CONF_SITE_ADDR_COMPLEMENT", "Rua B, casa 255");
define("CONF_SITE_ADDR_CITY", "Rio de Janeiro");
define("CONF_SITE_ADDR_STATE", "RJ");
define("CONF_SITE_ADDR_ZIPCODE", "22770-590");

/**
 * SOCIAL
 */
define("CONF_SOCIAL_TWITTER_CREATOR", "@financecontrol");
define("CONF_SOCIAL_TWITTER_PUBLISHER", "@financecontrol");
define("CONF_SOCIAL_FACEBOOK_APP", "550149899141611");
define("CONF_SOCIAL_FACEBOOK_PAGE", "FinanceControl-113901093395599");
define("CONF_SOCIAL_FACEBOOK_AUTHOR", "rodrigo.carvalhodebrito");
define("CONF_SOCIAL_GOOGLE_PAGE", "no_page");
define("CONF_SOCIAL_GOOGLE_AUTHOR", "no_author");
define("CONF_SOCIAL_INSTAGRAM_PAGE", "financecontrol");
define("CONF_SOCIAL_YOUTUBE_PAGE", "channel/UCIP44Y-7qG38XDYhbRAMBpw");

/**
 * DATES
 */
define("CONF_DATE_BR", "d/m/Y H:i:s");
define("CONF_DATE_APP", "Y-m-d H:i:s");

/**
 * PASSWORD
 */
define("CONF_PASSWD_MIN_LEN", 8);
define("CONF_PASSWD_MAX_LEN", 40);
define("CONF_PASSWD_ALGO", PASSWORD_DEFAULT);
define("CONF_PASSWD_OPTION", ["cost" => 10]);

/**
 * VIEW
 */
define("CONF_VIEW_PATH", __DIR__ . "/../../shared/views");
define("CONF_VIEW_EXT", "php");
define("CONF_VIEW_THEME", "financeweb");
define("CONF_VIEW_APP", "financeapp");
define("CONF_VIEW_ADMIN", "financeadm");

/**
 * UPLOAD
 */
define("CONF_UPLOAD_DIR", "storage");
define("CONF_UPLOAD_IMAGE_DIR", "images");
define("CONF_UPLOAD_FILE_DIR", "files");
define("CONF_UPLOAD_MEDIA_DIR", "medias");

/**
 * IMAGES
 */
define("CONF_IMAGE_CACHE", CONF_UPLOAD_DIR . "/" . CONF_UPLOAD_IMAGE_DIR . "/cache");
define("CONF_IMAGE_SIZE", 2000);
define("CONF_IMAGE_QUALITY", ["jpg" => 75, "png" => 5]);

/**
 * MAIL
 */
define("CONF_MAIL_HOST", "");
define("CONF_MAIL_PORT", "");
define("CONF_MAIL_USER", "");
define("CONF_MAIL_PASS", '');
define("CONF_MAIL_SENDER", ["name" => "", "address" => ""]);
define("CONF_MAIL_SUPPORT", "");
define("CONF_MAIL_OPTION_LANG", "br");
define("CONF_MAIL_OPTION_HTML", true);
define("CONF_MAIL_OPTION_AUTH", true);
define("CONF_MAIL_OPTION_SECURE", "ssl");
define("CONF_MAIL_OPTION_CHARSET", "utf-8");
