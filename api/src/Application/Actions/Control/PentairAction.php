<?php

declare(strict_types=1);

namespace App\Application\Actions\Control;
use App\Application\Actions\Action;

use Phpentair\Com\IConnector;
use Psr\Log\LoggerInterface;
use \Phpentair\PentairComFacade;
use \Phpentair\Pentair;

abstract class PentairAction extends Action
{
    protected PentairComFacade $com;
    protected Pentair $pentair;
    protected IConnector $IConnector;

    public function __construct(LoggerInterface $logger, IConnector $IConnector)
    {
        parent::__construct($logger);
        $this->IConnector = $IConnector;
        $this->com = new PentairComFacade($this->IConnector);
        $this->pentair = new Pentair($this->com, 'pentair.lock', 'pentair.cache');
    }
}
