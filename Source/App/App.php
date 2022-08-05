<?php

namespace Source\App;

use Source\Core\Controller;
use Source\Core\Session;
use Source\Core\View;
use Source\Models\Auth;
use Source\Models\FinanceApp\AppCategory;
use Source\Models\FinanceApp\AppInvoice;
use Source\Models\FinanceApp\AppPurchaseOrder;
use Source\Models\FinanceApp\AppWallet;
use Source\Models\Post;
use Source\Models\Report\Access;
use Source\Models\Report\Online;
use Source\Models\User;
use Source\Support\Email;
use Source\Support\Thumb;
use Source\Support\Upload;
use Source\Support\Pager;

/**
 * Class App
 * @package Source\App
 */
class App extends Controller
{

    /** @var User */
    private $user;

    /**
     * App constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW_APP . "/");

        if (!$this->user = Auth::user()) {
            $this->message->warning("Efetue login para acessar o APP.")->flash();
            redirect("/entrar");
        }

        (new AppInvoice())->fixed($this->user, 3);
    }

    /**
     * @param array|null $data
     */
    public function dash(?array $data): void
    {
        if (!empty($data["wallet"])) {
            $session = new Session();

            if ($data["wallet"] == "all") {
                $session->unset("walletfilter");
                echo json_encode(["filter" => true]);
                return;
            }

            $wallet = filter_var($data["wallet"], FILTER_VALIDATE_INT);
            if ($this->user->level == 5) {
                $getWallet = (new AppWallet())->find(
                    "id = :id",
                    "id={$wallet}"
                )->count();
            } else {
                $getWallet = (new AppWallet())->find(
                    "user_id = :user AND id = :id",
                    "user={$this->user->id}&id={$wallet}"
                )->count();
            }


            if ($getWallet) {
                $session->set("walletfilter", $wallet);
            }

            echo json_encode(["filter" => true]);
            return;
        }

        //CHART UPDATE
        $chartData = (new AppInvoice())->chartData($this->user);
        $categories = str_replace("'", "", explode(",", $chartData->categories));
        $json["chart"] = [
            "categories" => $categories,
            "income" => array_map("abs", explode(",", $chartData->income)),
            "expense" => array_map("abs", explode(",", $chartData->expense)),
            "refund" => array_map("abs", explode(",", $chartData->refund))
        ];

        //WALLET
        $wallet = (new AppInvoice())->balance($this->user);
        $wallet->wallet = str_price($wallet->wallet);
        $wallet->status = ($wallet->balance == "positive" ? "gradient-green" : "gradient-red");
        $wallet->income = str_price($wallet->income);
        $wallet->expense = str_price($wallet->expense);
        $json["wallet"] = $wallet;

        echo json_encode($json);
    }

    /**
     * APP HOME
     */
    public function home(): void
    {
        $head = $this->seo->render(
            "Olá {$this->user->first_name}. Vamos controlar? - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.png"),
            false
        );

        //CHART
        $chartData = (new AppInvoice())->chartData($this->user);
        //END CHART
        //INCOME && EXPENSE
        $whereWallet = "";
        if ((new Session())->has("walletfilter")) {
            $whereWallet = "AND wallet_id = " . (new Session())->walletfilter;
        }

        if ($this->user->level == 5) {
            $income = (new AppInvoice())
                ->find(
                    "type = 'income' AND status = 'unpaid' AND date(due_at) <= date(now() + INTERVAL 1 MONTH) {$whereWallet}"
                )
                ->order("due_at")
                ->fetch(true);

            $expense = (new AppInvoice())
                ->find(
                    "type = 'expense' AND status = 'unpaid' AND date(due_at) <= date(now() + INTERVAL 1 MONTH) {$whereWallet}"
                )
                ->order("due_at")
                ->fetch(true);

            $refund = (new AppInvoice())
                ->find(
                    "type = 'refund' AND status = 'unpaid' AND date(due_at) <= date(now() + INTERVAL 1 MONTH) {$whereWallet}"
                )
                ->order("due_at")
                ->fetch(true);
        } else {
            $income = (new AppInvoice())
                ->find(
                    "user_id = :user AND type = 'income' AND status = 'unpaid' AND date(due_at) <= date(now() + INTERVAL 1 MONTH) {$whereWallet}",
                    "user={$this->user->id}"
                )
                ->order("due_at")
                ->fetch(true);

            $expense = (new AppInvoice())
                ->find(
                    "user_id = :user AND type = 'expense' AND status = 'unpaid' AND date(due_at) <= date(now() + INTERVAL 1 MONTH) {$whereWallet}",
                    "user={$this->user->id}"
                )
                ->order("due_at")
                ->fetch(true);

            $refund = (new AppInvoice())
                ->find(
                    "user_id = :user AND type = 'refund' AND status = 'unpaid' AND date(due_at) <= date(now() + INTERVAL 1 MONTH) {$whereWallet}",
                    "user={$this->user->id}"
                )
                ->order("due_at")
                ->fetch(true);
        }
        //END INCOME && EXPENSE
        //WALLET
        $wallet = (new AppInvoice())->balance($this->user);
        //END WALLET

        echo $this->view->render("home", [
            "head" => $head,
            "chart" => $chartData,
            "income" => $income,
            "expense" => $expense,
            "refund" => $refund,
            "wallet" => $wallet
        ]);
    }

    /**
     * @param array $data
     * @throws \Exception
     */
    public function filter(array $data): void
    {
        $status = (!empty($data["status"]) ? $data["status"] : "all");
        $category = (!empty($data["category"]) ? $data["category"] : "all");
        $date = (!empty($data["date"]) ? $data["date"] : date("m/Y"));

        list($m, $y) = explode("/", $date);
        $m = ($m >= 1 && $m <= 12 ? $m : date("m"));
        $y = ($y <= date("Y", strtotime("+10year")) ? $y : date("Y", strtotime("+10year")));

        $start = new \DateTime(date("Y-m-t"));
        $end = new \DateTime(date("Y-m-t", strtotime("{$y}-{$m}+1month")));
        $diff = $start->diff($end);

        if (!$diff->invert) {
            $afterMonths = (floor($diff->days / 30));
            (new AppInvoice())->fixed($this->user, $afterMonths);
        }

        $redirect = ($data["filter"] == "income" ? "receber" : ($data["filter"] == "refund" ? "reembolso" : "pagar"));
        $json["redirect"] = url("/app/{$redirect}/{$status}/{$category}/{$m}-{$y}");
        echo json_encode($json);
    }

    /**
     * @param array|null $data
     */
    public function income(?array $data): void
    {
        $head = $this->seo->render(
            "Minhas receitas - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.png"),
            false
        );

        $categories = (new AppCategory())
            ->find("type = :t", "t=income", "id, name")
            ->order("order_by, name")
            ->fetch("true");

        echo $this->view->render("invoices", [
            "user" => $this->user,
            "head" => $head,
            "type" => "income",
            "categories" => $categories,
            "invoices" => (new AppInvoice())->filter($this->user, "income", ($data ?? null)),
            "filter" => (object) [
                "status" => ($data["status"] ?? null),
                "category" => ($data["category"] ?? null),
                "date" => (!empty($data["date"]) ? str_replace("-", "/", $data["date"]) : null)
            ]
        ]);
    }

    /**
     * @param array|null $data
     */
    public function expense(?array $data): void
    {
        $head = $this->seo->render(
            "Minhas despesas - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.png"),
            false
        );

        $categories = (new AppCategory())
            ->find("type = :t", "t=expense", "id, name")
            ->order("order_by, name")
            ->fetch("true");

        echo $this->view->render("invoices", [
            "user" => $this->user,
            "head" => $head,
            "type" => "expense",
            "categories" => $categories,
            "invoices" => (new AppInvoice())->filter($this->user, "expense", ($data ?? null)),
            "filter" => (object) [
                "status" => ($data["status"] ?? null),
                "category" => ($data["category"] ?? null),
                "date" => (!empty($data["date"]) ? str_replace("-", "/", $data["date"]) : null)
            ]
        ]);
    }

    /**
     * @param array|null $data
     */
    public function refund(?array $data): void
    {
        $head = $this->seo->render(
            "Meus Reembolsos - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.png"),
            false
        );

        $categories = (new AppCategory())
            ->find("type = :t", "t=refund", "id, name")
            ->order("order_by, name")
            ->fetch("true");

        echo $this->view->render("invoices", [
            "user" => $this->user,
            "head" => $head,
            "type" => "refund",
            "categories" => $categories,
            "invoices" => (new AppInvoice())->filter($this->user, "refund", ($data ?? null)),
            "filter" => (object) [
                "status" => ($data["status"] ?? null),
                "category" => ($data["category"] ?? null),
                "date" => (!empty($data["date"]) ? str_replace("-", "/", $data["date"]) : null)
            ]
        ]);
    }

    /**
     *
     */
    public function fixed(): void
    {
        $head = $this->seo->render(
            "Minhas contas fixas - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.png"),
            false
        );

        $whereWallet = "";
        if ((new Session())->has("walletfilter")) {
            $whereWallet = "AND wallet_id = " . (new Session())->walletfilter;
        }

        echo $this->view->render("recurrences", [
            "head" => $head,
            "invoices" => (new AppInvoice())->find(
                "user_id = :user AND type IN('fixed_income', 'fixed_expense') {$whereWallet}",
                "user={$this->user->id}"
            )->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     */
    public function wallets(?array $data): void
    {
        //create
        if (!empty($data["wallet"]) && !empty($data["wallet_name"])) {

            $wallet = new AppWallet();
            $wallet->wallet = filter_var($data["wallet_name"], FILTER_SANITIZE_STRIPPED);
            $wallet->save();

            echo json_encode(["reload" => true]);
            return;
        }

        //edit
        if (!empty($data["wallet"]) && !empty($data["wallet_edit"])) {
            $wallet = (new AppWallet())->find()->fetch();

            if ($wallet) {
                $wallet->wallet = filter_var($data["wallet_edit"], FILTER_SANITIZE_STRIPPED);
                $wallet->save();
            }

            echo json_encode(["wallet_edit" => true]);
            return;
        }

        //delete
        if (!empty($data["wallet"]) && !empty($data["wallet_remove"])) {
            $wallet = (new AppWallet())->find()->fetch();

            if ($wallet) {
                $wallet->destroy();
                (new Session())->unset("walletfilter");
            }

            echo json_encode(["wallet_remove" => true]);
            return;
        }

        $head = $this->seo->render(
            "Minhas Empresas - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.png"),
            false
        );

        $wallets = (new AppWallet())
            ->find()
            ->order("wallet")
            ->fetch(true);

        echo $this->view->render("wallets", [
            "head" => $head,
            "wallets" => $wallets
        ]);
    }

    /**
     * @param array $data
     */
    public function launch(array $data): void
    {
        $invoice = new AppInvoice();

        $data["value"] = (!empty($data["value"]) ? str_replace([".", ","], ["", "."], $data["value"]) : 0);
        if (!$invoice->launch($this->user, $data)) {
            $json["message"] = $invoice->message()->render();
            echo json_encode($json);
            return;
        }

        $type = ($invoice->type == "income" ? "sua receita foi lançada" : ($invoice->type == "refund" ? "seu reembolso foi lançado" : "sua despesa foi lançada"));
        $this->message->success("Tudo certo, {$type} com sucesso")->flash();

        $json["reload"] = true;
        echo json_encode($json);
    }

    /**
     * @param array $data
     */
    public function onpaid(array $data): void
    {
        if ($this->user->level == 5) {
            $invoice = (new AppInvoice())
                ->find("id = :id", "id={$data["invoice"]}")
                ->fetch();
        } else {
            $invoice = (new AppInvoice())
                ->find("user_id = :user AND id = :id", "user={$this->user->id}&id={$data["invoice"]}")
                ->fetch();
        }

        if (!$invoice) {
            $this->message->error("Ooops! Ocorreu um erro ao atualizar o lançamento :/")->flash();
            $json["reload"] = true;
            echo json_encode($json);
            return;
        }


        $invoice->status = ($invoice->status == "paid" ? "unpaid" : "paid");
        $invoice->save();

        $y = date("Y");
        $m = date("m");
        if (!empty($data["date"])) {
            list($m, $y) = explode("/", $data["date"]);
        }

        exit();
        $json["onpaid"] = (new AppInvoice())->balanceMonth($this->user, $y, $m, $invoice->type);
        echo json_encode($json);
    }

    /**
     * @param array $data
     */
    public function invoice(array $data): void
    {
        if (!empty($data["update"])) {
            if ($this->user->level == 5) {
                $invoice = (new AppInvoice())->find(
                    "id = :id",
                    "id={$data["invoice"]}"
                )->fetch();
            } else {
                $invoice = (new AppInvoice())->find(
                    "user_id = :user AND id = :id",
                    "user={$this->user->id}&id={$data["invoice"]}"
                )->fetch();
            }


            if (!$invoice) {
                $json["message"] = $this->message->error("Ooops! Não foi possível carregar a fatura {$this->user->first_name}. Você pode tentar novamente.")->render();
                echo json_encode($json);
                return;
            }

            if ($data["due_day"] < 1 || $data["due_day"] > $dayOfMonth = date("t", strtotime($invoice->due_at))) {
                $json["message"] = $this->message->warning("O vencimento deve ser entre dia 1 e dia {$dayOfMonth} para este mês.")->render();
                echo json_encode($json);
                return;
            }

            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $due_day = date("Y-m", strtotime($invoice->due_at)) . "-" . $data["due_day"];
            $invoice->category = $data["category"];
            $invoice->description = $data["description"];
            $invoice->due_at = date("Y-m-d", strtotime($due_day));
            $invoice->value = str_replace([".", ","], ["", "."], $data["value"]);
            $invoice->wallet_id = $data["wallet"];
            $invoice->status = $data["status"];
            $invoice->purchase_mode = $data["purchase_mode"] ?? null;
            $invoice->annotation = $data["annotation"] ?? null;

            if (!empty($_FILES["file"])) {
                $files = $_FILES["file"];
                $upload = new Upload();
                $file = $upload->file($files, $data["description"]);
                if (!$file) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }
                $invoice->file = $file;
            }

            if (!$invoice->save()) {
                $json["message"] = $invoice->message()->before("Ooops! ")->after(" {$this->user->first_name}.")->render();
                echo json_encode($json);
                return;
            }

            if ($this->user->level == 5) {
                $invoiceOf = (new AppInvoice())->find(
                    "invoice_of = :of",
                    "of={$invoice->id}"
                )->fetch(true);
            } else {
                $invoiceOf = (new AppInvoice())->find(
                    "user_id = :user AND invoice_of = :of",
                    "user={$this->user->id}&of={$invoice->id}"
                )->fetch(true);
            }

            if (!empty($invoiceOf) && in_array($invoice->type, ["fixed_income", "fixed_expense"])) {
                foreach ($invoiceOf as $invoiceItem) {
                    if ($data["status"] == "unpaid" && $invoiceItem->status == "unpaid") {
                        $invoiceItem->destroy();
                    } else {
                        $due_day = date("Y-m", strtotime($invoiceItem->due_at)) . "-" . $data["due_day"];
                        $invoiceItem->category = $data["category"];
                        // $invoiceItem->category_id = $data["category"];
                        $invoiceItem->description = $data["description"];
                        $invoiceItem->wallet_id = $data["wallet"];

                        if ($invoiceItem->status == "unpaid") {
                            $invoiceItem->value = str_replace([".", ","], ["", "."], $data["value"]);
                            $invoiceItem->due_at = date("Y-m-d", strtotime($due_day));
                        }

                        $invoiceItem->save();
                    }
                }
            }

            $json["message"] = $this->message->success("Pronto {$this->user->first_name}, a atualização foi efetuada com sucesso!")->render();
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            "Aluguel - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.png"),
            false
        );

        if ($this->user->level == 5) {
            $invoice = (new AppInvoice())->find(
                "id = :invoice",
                "invoice={$data["invoice"]}"
            )->fetch();
        } else {
            $invoice = (new AppInvoice())->find(
                "user_id = :user AND id = :invoice",
                "user={$this->user->id}&invoice={$data["invoice"]}"
            )->fetch();
        }

        if (!$invoice) {
            $this->message->error("Ooops! Você tentou acessar uma fatura que não existe")->flash();
            redirect("/app");
        }
        if ($this->user->level == 5) {
            $wallets = (new AppWallet())
                ->find()
                ->order("wallet")
                ->fetch(true);
        } else {
            $wallets = (new AppWallet())
                ->find("user_id = :user", "user={$this->user->id}", "id, wallet")
                ->order("wallet")
                ->fetch(true);
        }

        echo $this->view->render("invoice", [
            "head" => $head,
            "invoice" => $invoice,
            "wallets" => $wallets,
            "categories" => (new AppCategory())
                ->find("type = :type", "type={$invoice->category}")
                ->order("order_by, name")
                ->fetch(true)
        ]);
    }

    /**
     * @param array $data
     */
    public function remove(array $data): void
    {
        if ($this->user->level == 5) {
            $invoice = (new AppInvoice())->find(
                "id = :invoice",
                "invoice={$data["invoice"]}"
            )->fetch();
        } else {
            $invoice = (new AppInvoice())->find(
                "user_id = :user AND id = :invoice",
                "user={$this->user->id}&invoice={$data["invoice"]}"
            )->fetch();
        }

        if ($invoice) {
            $invoice->destroy();
        }

        $this->message->success("Tudo pronto {$this->user->first_name}. O lançamento foi removido com sucesso!")->flash();
        $json["redirect"] = url("/app");
        echo json_encode($json);
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function profile(?array $data): void
    {
        if (!empty($data["update"])) {
            list($d, $m, $y) = explode("/", $data["datebirth"]);
            $user = (new User())->findById($this->user->id);
            $user->first_name = $data["first_name"];
            $user->last_name = $data["last_name"];
            $user->genre = $data["genre"];
            $user->datebirth = "{$y}-{$m}-{$d}";
            $user->document = preg_replace("/[^0-9]/", "", $data["document"]);

            if (!empty($_FILES["photo"])) {
                $file = $_FILES["photo"];
                $upload = new Upload();

                if ($this->user->photo()) {
                    (new Thumb())->flush("storage/{$this->user->photo}");
                    $upload->remove("storage/{$this->user->photo}");
                }

                if (!$user->photo = $upload->image($file, "{$user->first_name} {$user->last_name} " . time(), 360)) {
                    $json["message"] = $upload->message()->before("Ooops {$this->user->first_name}! ")->after(".")->render();
                    echo json_encode($json);
                    return;
                }
            }

            if (!empty($data["password"])) {
                if (empty($data["password_re"]) || $data["password"] != $data["password_re"]) {
                    $json["message"] = $this->message->warning("Para alterar sua senha, informa e repita a nova senha!")->render();
                    echo json_encode($json);
                    return;
                }

                $user->password = $data["password"];
            }

            if (!$user->save()) {
                $json["message"] = $user->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Pronto {$this->user->first_name}. Seus dados foram atualizados com sucesso!")->render();
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            "Meu perfil - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.png"),
            false
        );

        echo $this->view->render("profile", [
            "head" => $head,
            "user" => $this->user,
            "photo" => ($this->user->photo() ? image($this->user->photo, 360, 360) :
                theme("/assets/images/avatar.jpg", CONF_VIEW_APP))
        ]);
    }

    /** Users */
    /**
     * @param array|null $data
     */
    public function usersHome(?array $data): void
    {

        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);
            echo json_encode(["redirect" => url("/app/usuarios/home/{$s}/1")]);
            return;
        }

        $search = null;
        $users = (new User())->find();

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $users = (new User())->find("MATCH(first_name, last_name, email) AGAINST(:s)", "s={$search}");
            if (!$users->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/app/usuarios/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/app/usuarios/home/{$all}/"));
        $pager->pager($users->count(), 12, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Usuários",
            CONF_SITE_DESC,
            url("/app"),
            url("/app/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("users/home", [
            "app" => "users/home",
            "head" => $head,
            "search" => $search,
            "users" => $users->order("level DESC, first_name, last_name")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function users(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $userCreate = new User();
            $userCreate->first_name = $data["first_name"];
            $userCreate->last_name = $data["last_name"];
            $userCreate->email = $data["email"];
            $userCreate->password = $data["password"];
            $userCreate->level = $data["level"];
            $userCreate->genre = $data["genre"];
            $userCreate->datebirth = date_fmt_back($data["datebirth"]);
            $userCreate->document = preg_replace("/[^0-9]/", "", $data["document"]);
            $userCreate->status = $data["status"];

            //upload photo
            if (!empty($_FILES["photo"])) {
                $files = $_FILES["photo"];
                $upload = new Upload();
                $image = $upload->image($files, $userCreate->fullName(), 600);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $userCreate->photo = $image;
            }

            if (!$userCreate->save()) {
                $json["message"] = $userCreate->message()->render();
                echo json_encode($json);
                return;
            }

            if (!empty($data["wallet"])) {
                $wallet = (new AppWallet())->findById($data["wallet"]);
                if ($wallet) {
                    $wallet->user_id = $userCreate->id;
                    $wallet->save();

                    $invoices = (new AppInvoice())->find('wallet_id', $data["wallet"])->fetch(true);
                    if (count($invoices) > 0) {
                        foreach ($invoices as $invoice) {
                            $invoice->user_id = $userCreate->id;
                            $invoice->save();
                        }
                    }
                }
            }

            $this->message->success("Usuário cadastrado com sucesso...")->flash();
            $json["redirect"] = url("/app/usuarios/usuario/{$userCreate->id}");

            echo json_encode($json);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $userUpdate = (new User())->findById($data["user_id"]);

            if (!$userUpdate) {
                $this->message->error("Você tentou gerenciar um usuário que não existe")->flash();
                echo json_encode(["redirect" => url("/app/usuarios/home")]);
                return;
            }

            $userUpdate->first_name = $data["first_name"];
            $userUpdate->last_name = $data["last_name"];
            $userUpdate->email = $data["email"];
            $userUpdate->password = (!empty($data["password"]) ? $data["password"] : $userUpdate->password);
            $userUpdate->level = $data["level"];
            $userUpdate->genre = $data["genre"];
            $userUpdate->datebirth = date_fmt_back($data["datebirth"]);
            $userUpdate->document = preg_replace("/[^0-9]/", "", $data["document"]);
            $userUpdate->status = $data["status"];

            if (!empty($data["wallet"])) {
                $wallet = (new AppWallet())->findById($data["wallet"]);
                if ($wallet) {
                    $wallet->user_id = $userUpdate->id;
                    $wallet->save();

                    $invoices = (new AppInvoice())->find('wallet_id', $data["wallet"])->fetch(true);
                    if (count($invoices) > 0) {
                        foreach ($invoices as $invoice) {
                            $invoice->user_id = $userUpdate->id;
                            $invoice->save();
                        }
                    }
                }
            }

            //upload photo
            if (!empty($_FILES["photo"])) {
                if ($userUpdate->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$userUpdate->photo}")) {
                    unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$userUpdate->photo}");
                    (new Thumb())->flush($userUpdate->photo);
                }

                $files = $_FILES["photo"];
                $upload = new Upload();
                $image = $upload->image($files, $userUpdate->fullName(), 600);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $userUpdate->photo = $image;
            }

            if (!$userUpdate->save()) {
                $json["message"] = $userUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Usuário atualizado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $userDelete = (new User())->findById($data["user_id"]);

            if (!$userDelete) {
                $this->message->error("Você tentnou deletar um usuário que não existe")->flash();
                echo json_encode(["redirect" => url("/app/users/home")]);
                return;
            }

            if ($userDelete->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$userDelete->photo}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$userDelete->photo}");
                (new Thumb())->flush($userDelete->photo);
            }

            $userDelete->destroy();

            $this->message->success("O usuário foi excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/app/usuarios/home")]);

            return;
        }

        $userEdit = null;
        if (!empty($data["user_id"])) {
            $userId = filter_var($data["user_id"], FILTER_VALIDATE_INT);
            $userEdit = (new User())->findById($userId);
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | " . ($userEdit ? "Perfil de {$userEdit->fullName()}" : "Novo Usuário"),
            CONF_SITE_DESC,
            url("/app"),
            url("/app/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("users/user", [
            "app" => "users/user",
            "head" => $head,
            "user" => $userEdit,
            "wallets" => (new AppWallet())
                ->find()
                ->order("wallet")
                ->fetch(true)
        ]);
    }

    /** APP PURCHASE ORDER */

    public function purchaserOrder()
    {
        if ($this->user->level == 5) {
            $orders = (new AppPurchaseOrder())->find()
                ->order("date DESC")
                ->fetch(true);
        } else {
            $orders = (new AppPurchaseOrder())->find("user_id = {$this->user->id}")
                ->order("date DESC")
                ->fetch(true);
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Ordem de Compra",
            CONF_SITE_DESC,
            url("/app"),
            url("/app/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("purchases", [
            "head" => $head,
            "orders" => $orders
        ]);
    }

    public function purchaserOrderSave(?array $data): void
    {
        $order = new AppPurchaseOrder();
        $order->user_id = $this->user->id;
        $order->date = $data['date'];
        $order->amount = $data['amount'];
        $order->material = $data['material'];
        $order->job = $data['job'];
        $order->value = (!empty($data["value"]) ? str_replace([".", ","], ["", "."], $data["value"]) : 0);
        $order->requester = $data['requester'];
        $order->forecast = $data['forecast'];
        $order->authorized = $data['authorized'];
        $order->authorized_date = $data['authorized_date'];
        $order->freight = $data['freight'];
        $order->payment = $data['payment'];
        $order->provider = $data['provider'];
        $order->invoice = $data['invoice'];
        $order->material_1 = (!empty($data['material_1']) ? $data['material_1'] : null);
        $order->material_2 = (!empty($data['material_2']) ? $data['material_2'] : null);
        $order->material_3 = (!empty($data['material_3']) ? $data['material_3'] : null);
        $order->material_4 = (!empty($data['material_4']) ? $data['material_4'] : null);
        $order->material_5 = (!empty($data['material_5']) ? $data['material_5'] : null);
        $order->material_6 = (!empty($data['material_6']) ? $data['material_6'] : null);
        $order->material_7 = (!empty($data['material_7']) ? $data['material_7'] : null);
        $order->material_8 = (!empty($data['material_8']) ? $data['material_8'] : null);
        $order->material_9 = (!empty($data['material_9']) ? $data['material_9'] : null);
        $order->material_10 = (!empty($data['material_10']) ? $data['material_10'] : null);
        $order->material_11 = (!empty($data['material_11']) ? $data['material_11'] : null);
        $order->material_12 = (!empty($data['material_12']) ? $data['material_12'] : null);
        $order->material_13 = (!empty($data['material_13']) ? $data['material_13'] : null);
        $order->material_14 = (!empty($data['material_14']) ? $data['material_14'] : null);
        $order->material_15 = (!empty($data['material_15']) ? $data['material_15'] : null);
        $order->material_16 = (!empty($data['material_16']) ? $data['material_16'] : null);
        $order->material_17 = (!empty($data['material_17']) ? $data['material_17'] : null);
        $order->material_18 = (!empty($data['material_18']) ? $data['material_18'] : null);
        $order->material_19 = (!empty($data['material_19']) ? $data['material_19'] : null);
        $order->material_20 = (!empty($data['material_20']) ? $data['material_20'] : null);
        $order->material_21 = (!empty($data['material_21']) ? $data['material_21'] : null);
        $order->material_22 = (!empty($data['material_22']) ? $data['material_22'] : null);
        $order->material_23 = (!empty($data['material_23']) ? $data['material_23'] : null);
        $order->material_24 = (!empty($data['material_24']) ? $data['material_24'] : null);
        $order->material_25 = (!empty($data['material_25']) ? $data['material_25'] : null);
        $order->material_26 = (!empty($data['material_26']) ? $data['material_26'] : null);
        $order->material_27 = (!empty($data['material_27']) ? $data['material_27'] : null);
        $order->material_28 = (!empty($data['material_28']) ? $data['material_28'] : null);
        $order->material_29 = (!empty($data['material_29']) ? $data['material_29'] : null);
        $order->material_30 = (!empty($data['material_30']) ? $data['material_30'] : null);
        $order->material_31 = (!empty($data['material_31']) ? $data['material_31'] : null);
        $order->material_32 = (!empty($data['material_32']) ? $data['material_32'] : null);
        $order->material_33 = (!empty($data['material_33']) ? $data['material_33'] : null);
        $order->material_34 = (!empty($data['material_34']) ? $data['material_34'] : null);
        $order->material_35 = (!empty($data['material_35']) ? $data['material_35'] : null);
        $order->material_36 = (!empty($data['material_36']) ? $data['material_36'] : null);
        $order->material_37 = (!empty($data['material_37']) ? $data['material_37'] : null);
        $order->material_38 = (!empty($data['material_38']) ? $data['material_38'] : null);
        $order->material_39 = (!empty($data['material_39']) ? $data['material_39'] : null);
        $order->material_40 = (!empty($data['material_40']) ? $data['material_40'] : null);
        $order->material_41 = (!empty($data['material_41']) ? $data['material_41'] : null);
        $order->material_42 = (!empty($data['material_42']) ? $data['material_42'] : null);
        $order->material_43 = (!empty($data['material_43']) ? $data['material_43'] : null);
        $order->material_44 = (!empty($data['material_44']) ? $data['material_44'] : null);
        $order->material_45 = (!empty($data['material_45']) ? $data['material_45'] : null);
        $order->material_46 = (!empty($data['material_46']) ? $data['material_46'] : null);
        $order->material_47 = (!empty($data['material_47']) ? $data['material_47'] : null);
        $order->material_48 = (!empty($data['material_48']) ? $data['material_48'] : null);
        $order->material_49 = (!empty($data['material_49']) ? $data['material_49'] : null);
        $order->material_50 = (!empty($data['material_50']) ? $data['material_50'] : null);
        $order->serie = $data['serie'];
        $order->status = $data['status'];

        if (!empty($_FILES["file"])) {
            $files = $_FILES["file"];
            $upload = new Upload();
            $file = $upload->file($files, $data['serie']);
            if (!$file) {
                $json["message"] = $upload->message()->render();
                echo json_encode($json);
                return;
            }
            $order->file = $file;
        }

        if (!$order->save()) {
            $json["message"] = $order->message()->render();
            echo json_encode($json);
            return;
        }

        $subject = date("Y-m-d") . ' - Nova Ordem de Compra';
        $message = "Nova Ordem de compra cadastrada pelo usuário {$this->user->fullName()}, com os seguintes dados: Série: {$order->serie} / Valor: R$ " . number_format((!empty($order->amount) ? $order->amount : 0), 2, ',', '.');

        $view = new View(__DIR__ . "/../../shared/views/email");
        $body = $view->render("mail", [
            "subject" => $subject,
            "message" => str_textarea($message)
        ]);

        (new Email())->bootstrap(
            $subject,
            $body,
            CONF_MAIL_SUPPORT,
            "Ordem de Compra " . CONF_SITE_NAME
        )->queue($this->user->email, "{$this->user->first_name} {$this->user->last_name}");

        $this->message->success("Ordem de Compra salva com sucesso...")->flash();
        echo json_encode(["reload" => true]);
        return;
    }

    public function purchase(array $data)
    {

        if ($this->user->level == 5) {
            $obj = new AppPurchaseOrder();
            $order = $obj->findById($data['id']);
        } else {
            $order = (new AppPurchaseOrder())
                ->find("user_id = {$this->user->id} AND id = {$data['id']}")
                ->fetch();
        }

        if (empty($order->id)) {
            $this->message->error("Ooops! Você tentou acessar uma ordem de compra que não existe")->flash();
            redirect("/app/ordem-compra");
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Ordem de Compra nº {$order->id}",
            CONF_SITE_DESC,
            url("/app"),
            url("/app/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("purchase", [
            "head" => $head,
            "order" => $order
        ]);
    }

    public function purchaseUpdate(array $data)
    {
        if ($this->user->level == 5) {
            $obj = new AppPurchaseOrder();
            $order = $obj->findById($data['id']);
        } else {
            $order = (new AppPurchaseOrder())
                ->find("user_id = {$this->user->id} AND id = {$data['id']}")
                ->fetch();
        }
        if (empty($order->id)) {
            $this->message->error("Ooops! Você tentou atualizar uma ordem de compra que não existe")->flash();
            redirect("/app/ordem-compra");
        }

        $order->user_id = $this->user->id;
        $order->date = date_fmt_back($data['date']);
        $order->amount = $data['amount'];
        $order->material = $data['material'];
        $order->job = $data['job'];
        $order->value = (!empty($data["value"]) ? str_replace([".", ","], ["", "."], $data["value"]) : 0);
        $order->requester = $data['requester'];
        $order->forecast = date_fmt_back($data['forecast']);
        $order->authorized = $data['authorized'];
        $order->authorized_date = date_fmt_back($data['authorized_date']);
        $order->freight = $data['freight'];
        $order->payment = $data['payment'];
        $order->provider = $data['provider'];
        $order->invoice = $data['invoice'];
        $order->material_1 = (!empty($data['material_1']) ? $data['material_1'] : null);
        $order->material_2 = (!empty($data['material_2']) ? $data['material_2'] : null);
        $order->material_3 = (!empty($data['material_3']) ? $data['material_3'] : null);
        $order->material_4 = (!empty($data['material_4']) ? $data['material_4'] : null);
        $order->material_5 = (!empty($data['material_5']) ? $data['material_5'] : null);
        $order->material_6 = (!empty($data['material_6']) ? $data['material_6'] : null);
        $order->material_7 = (!empty($data['material_7']) ? $data['material_7'] : null);
        $order->material_8 = (!empty($data['material_8']) ? $data['material_8'] : null);
        $order->material_9 = (!empty($data['material_9']) ? $data['material_9'] : null);
        $order->material_10 = (!empty($data['material_10']) ? $data['material_10'] : null);
        $order->material_11 = (!empty($data['material_11']) ? $data['material_11'] : null);
        $order->material_12 = (!empty($data['material_12']) ? $data['material_12'] : null);
        $order->material_13 = (!empty($data['material_13']) ? $data['material_13'] : null);
        $order->material_14 = (!empty($data['material_14']) ? $data['material_14'] : null);
        $order->material_15 = (!empty($data['material_15']) ? $data['material_15'] : null);
        $order->material_16 = (!empty($data['material_16']) ? $data['material_16'] : null);
        $order->material_17 = (!empty($data['material_17']) ? $data['material_17'] : null);
        $order->material_18 = (!empty($data['material_18']) ? $data['material_18'] : null);
        $order->material_19 = (!empty($data['material_19']) ? $data['material_19'] : null);
        $order->material_20 = (!empty($data['material_20']) ? $data['material_20'] : null);
        $order->material_21 = (!empty($data['material_21']) ? $data['material_21'] : null);
        $order->material_22 = (!empty($data['material_22']) ? $data['material_22'] : null);
        $order->material_23 = (!empty($data['material_23']) ? $data['material_23'] : null);
        $order->material_24 = (!empty($data['material_24']) ? $data['material_24'] : null);
        $order->material_25 = (!empty($data['material_25']) ? $data['material_25'] : null);
        $order->material_26 = (!empty($data['material_26']) ? $data['material_26'] : null);
        $order->material_27 = (!empty($data['material_27']) ? $data['material_27'] : null);
        $order->material_28 = (!empty($data['material_28']) ? $data['material_28'] : null);
        $order->material_29 = (!empty($data['material_29']) ? $data['material_29'] : null);
        $order->material_30 = (!empty($data['material_30']) ? $data['material_30'] : null);
        $order->material_31 = (!empty($data['material_31']) ? $data['material_31'] : null);
        $order->material_32 = (!empty($data['material_32']) ? $data['material_32'] : null);
        $order->material_33 = (!empty($data['material_33']) ? $data['material_33'] : null);
        $order->material_34 = (!empty($data['material_34']) ? $data['material_34'] : null);
        $order->material_35 = (!empty($data['material_35']) ? $data['material_35'] : null);
        $order->material_36 = (!empty($data['material_36']) ? $data['material_36'] : null);
        $order->material_37 = (!empty($data['material_37']) ? $data['material_37'] : null);
        $order->material_38 = (!empty($data['material_38']) ? $data['material_38'] : null);
        $order->material_39 = (!empty($data['material_39']) ? $data['material_39'] : null);
        $order->material_40 = (!empty($data['material_40']) ? $data['material_40'] : null);
        $order->material_41 = (!empty($data['material_41']) ? $data['material_41'] : null);
        $order->material_42 = (!empty($data['material_42']) ? $data['material_42'] : null);
        $order->material_43 = (!empty($data['material_43']) ? $data['material_43'] : null);
        $order->material_44 = (!empty($data['material_44']) ? $data['material_44'] : null);
        $order->material_45 = (!empty($data['material_45']) ? $data['material_45'] : null);
        $order->material_46 = (!empty($data['material_46']) ? $data['material_46'] : null);
        $order->material_47 = (!empty($data['material_47']) ? $data['material_47'] : null);
        $order->material_48 = (!empty($data['material_48']) ? $data['material_48'] : null);
        $order->material_49 = (!empty($data['material_49']) ? $data['material_49'] : null);
        $order->material_50 = (!empty($data['material_50']) ? $data['material_50'] : null);
        $order->serie = $data['serie'];
        $order->status = $data['status'];

        if (!empty($_FILES["file"])) {
            $files = $_FILES["file"];
            $upload = new Upload();
            $file = $upload->file($files, $data['serie']);
            if (!$file) {
                $json["message"] = $upload->message()->render();
                echo json_encode($json);
                return;
            }
            $order->file = $file;
        }

        if (!$order->save()) {
            $json["message"] = $order->message()->render();
            echo json_encode($json);
            return;
        }

        $this->message->success("Ordem de Compra atualizada com sucesso...")->flash();
        echo json_encode(["reload" => true]);
        return;
    }

    public function purchaseRemove(array $data)
    {
        if ($this->user->level == 5) {
            $obj = new AppPurchaseOrder();
            $order = $obj->findById($data['id']);
        } else {
            $order = (new AppPurchaseOrder())
                ->find("user_id = {$this->user->id} AND id = {$data['id']}")
                ->fetch();
        }

        if (!$order) {
            $this->message->error("Você tentnou deletar uma ordem de compra que não existe")->flash();
            echo json_encode(["redirect" => url("/app/ordem-compra")]);
            return;
        }

        $order->destroy();

        $this->message->success("A ordem de compra foi excluída com sucesso...")->flash();
        echo json_encode(["redirect" => url("/app/ordem-compra")]);
        return;
    }

    /**
     * APP LOGOUT
     */
    public function logout(): void
    {
        $this->message->info("Você saiu com sucesso " . Auth::user()->first_name . ". Volte logo :)")->flash();

        Auth::logout();
        redirect("/entrar");
    }
}
