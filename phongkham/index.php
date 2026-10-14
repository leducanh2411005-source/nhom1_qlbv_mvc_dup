<?php
/**
 * FRONT CONTROLLER - cổng vào duy nhất của ứng dụng.
 * Mọi yêu cầu đều đi qua file này, sau đó Router chuyển cho Controller phù hợp.
 */
require_once __DIR__ . "/app/core/Database.php";
require_once __DIR__ . "/app/core/Model.php";
require_once __DIR__ . "/app/core/Auth.php";
require_once __DIR__ . "/app/core/Controller.php";
require_once __DIR__ . "/app/core/Router.php";
require_once __DIR__ . "/app/core/helpers.php";

Auth::start();

(new Router())->dispatch();
