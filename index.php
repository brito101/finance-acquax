<?php
ob_start();

require __DIR__ . "/vendor/autoload.php";

/**
 * BOOTSTRAP
 */

use CoffeeCode\Router\Router;
use Source\Core\Session;

$session = new Session();
$route = new Router(url(), ":");
$route->namespace("Source\App");

/**
 * WEB ROUTES
 */
$route->group(null);
$route->get("/", "Web:home");
$route->post("/cookie-consent", "Web:cookieConsent", "web.cookie.consent");

//auth
$route->group(null);
$route->get("/entrar", "Web:login");
$route->post("/entrar", "Web:login");
$route->get("/recuperar", "Web:forget");
$route->post("/recuperar", "Web:forget");
$route->get("/recuperar/{code}", "Web:reset");
$route->post("/recuperar/resetar", "Web:reset");

//optin
$route->group(null);
$route->get("/confirma", "Web:confirm");
$route->get("/obrigado/{email}", "Web:success");

//services
$route->group(null);
$route->get("/termos", "Web:terms", "web.terms");

/**
 * APP
 */
$route->group("/app");
$route->get("/", "App:home");
$route->get("/receber", "App:income");
$route->get("/receber/{status}/{category}/{date}", "App:income");
$route->get("/pagar", "App:expense");
$route->get("/pagar/{status}/{category}/{date}", "App:expense");
$route->get("/reembolso", "App:refund");
$route->get("/reembolso/{status}/{category}/{date}", "App:refund");
$route->get("/fixas", "App:fixed");
$route->get("/empresas", "App:wallets");
$route->get("/fatura/{invoice}", "App:invoice");
$route->get("/fatura-print/{invoice}", "App:invoicePrint");
$route->get("/perfil", "App:profile");
$route->get("/assinatura", "App:signature");
/** Users */
$route->get("/usuarios/home", "App:usersHome");
$route->post("/usuarios/home", "App:usersHome");
$route->get("/usuarios/home/{search}/{page}", "App:usersHome");
$route->get("/usuarios/usuario", "App:users");
$route->post("/usuarios/usuario", "App:users");
$route->get("/usuarios/usuario/{user_id}", "App:users");
$route->post("/usuarios/usuario/{user_id}", "App:users");
/** Purchase Order */
$route->get("/ordem-compra", "App:purchaserOrder");
$route->post("/ordem-compra", "App:purchaserOrderSave");
$route->get("/ordem-compra/{id}", "App:purchase");
$route->get("/ordem-compra-print/{id}", "App:purchasePrint");
$route->post("/atualizar-ordem-compra/{id}", "App:purchaseUpdate");
$route->post("/remover-ordem-compra/{id}", "App:purchaseRemove");
//END ADMIN
$route->get("/sair", "App:logout");

$route->post("/dash", "App:dash");
$route->post("/launch", "App:launch");
$route->post("/invoice/{invoice}", "App:invoice");
$route->post("/remove/{invoice}", "App:remove");
$route->post("/onpaid", "App:onpaid");
$route->post("/filter", "App:filter");
$route->post("/profile", "App:profile");
$route->post("/wallets/{wallet}", "App:wallets");

/**
 * ERROR ROUTES
 */
$route->group("/ops");
$route->get("/{errcode}", "Web:error");

/**
 * ROUTE
 */
$route->dispatch();

/**
 * ERROR REDIRECT
 */
if ($route->error()) {
    $route->redirect("/ops/{$route->error()}");
}

ob_end_flush();
