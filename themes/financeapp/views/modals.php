<div class="app_modal" data-modalclose="true">
    <!--INCOME-->
    <?php
    $user = user();
    if ($user->level == 5) {
        $wallets = (new \Source\Models\FinanceApp\AppWallet())
            ->find()
            ->order("wallet")
            ->fetch(true);
    } else {
        $wallets = (new \Source\Models\FinanceApp\AppWallet())
            ->find("user_id = :u", "u={$user->id}", "id, wallet")
            ->order("wallet")
            ->fetch(true);
    }

    $v->insert("views/invoice", [
        "type" => "income",
        "wallets" => $wallets
    ]);

    $v->insert("views/invoice", [
        "type" => "expense",
        "wallets" => $wallets
    ]);

    $v->insert("views/invoice", [
        "type" => "refund",
        "wallets" => $wallets
    ]);

    $v->insert("views/purchase");
    ?>
</div>