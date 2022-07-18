<?php

namespace Source\Models\FinanceApp;

use Source\Core\Model;

/**
 * Class AppPurchaseOrder
 * @package Source\Models\FinanceApp
 */
class AppPurchaseOrder extends Model
{
  /**
   * AppPurchaseOrder constructor.
   */
  public function __construct()
  {
    parent::__construct("purchase_order", ["id"], ["user_id", "date", "amount", "material", "job", "serie", "requester", "forecast", "authorized", "authorized_date"]);
  }
}
