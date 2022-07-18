<?php

namespace Source\Models\FinanceApp;

use Source\Core\Model;

/**
 * Class AppCategory
 * @package Source\Models\FinanceApp
 */
class AppCategory extends Model
{
    /**
     * AppCategory constructor.
     */
    public function __construct()
    {
        parent::__construct("app_categories", ["id"], ["name", "type"]);
    }
}