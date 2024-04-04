<?php

declare(strict_types=1);

namespace App\Application\Actions\Signal;

use Phpentair\Com\HexStringSampleConnector;
use Phpentair\Pentair;
use Phpentair\PentairComFacade;
use Psr\Http\Message\ResponseInterface as Response;

class RecentSignalsAction extends SignalAction
{

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {

        $count = (int)($this->args['count'] ?? 1);

        $signals = $this->signalRepository->mostRecent($count);

        $this->logger->info("Most recent signal was viewed.");

        foreach ($signals as $signal) {
            try {
                var_dump($signal); die();
                $hexstr = new HexStringSampleConnector($signal->getSignal());
                $com = new PentairComFacade($hexstr);
                $pentair = new Pentair($com);

                $signal->parsed($pentair->read()->toJson());
            } catch (\Exception $e) {
                $signal->error($e->getMessage());
            }
        }

        return $this->respondWithData($signals);
    }
}
