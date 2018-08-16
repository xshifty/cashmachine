<?php
declare(strict_types=1);

namespace Xshifty\CashMachineAPI\Controller;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

final class MainController extends BaseController
{
    public function withdraw(Request $request, Response $response, $args)
    {
        $params = $request->getQueryParams();
        
        if (!isset($params['amount'])) {
            $params['amount'] = NULL;
        }

        $result = $this->container['service.cashMachine']->withdraw($params['amount']);
        return json_encode($result);
    }
}
