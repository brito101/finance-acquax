<?php

require __DIR__ . "/../vendor/autoload.php";

/**
 * SEND QUEUE
 */
$emailQueue = new \Source\Support\Email();
$emailQueue->sendQueue();

/** usr/local/bin/php /home/rodrigo2/financecontrol.rodrigobrito.dev.br/service/sendEmail.php */
