<?php

declare(strict_types=1);

namespace App\Application\Actions\Control;

use Phpentair\Com\HexStringSampleConnector;
use Phpentair\Pentair;
use Phpentair\PentairComFacade;
use Phpentair\Command\CircuitChange;
use Psr\Http\Message\ResponseInterface as Response;

class CircuitAction extends PentairAction
{

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        // Blocks until read
        $message = $this->pentair->read();
        $protocol = $message->protocol;

        usleep(10 * 1000);
        switch ($this->args['circuit']) {
            case 'poolLightOn':
                $cmd = CircuitChange::poolLight($protocol, CircuitChange::$ON);
                break;
            case 'poolLightOff':
                $cmd = CircuitChange::poolLight($protocol, CircuitChange::$OFF);
                break;

            case 'spaLightOn':
                $cmd = CircuitChange::spaLight($protocol, CircuitChange::$ON);
                break;
            case 'spaLightOff':
                $cmd = CircuitChange::spaLight($protocol, CircuitChange::$OFF);
                break;
            case 'spaOn':
                $cmd = CircuitChange::spa($protocol, CircuitChange::$ON);
                break;
            case 'spaOff':
                $cmd = CircuitChange::spa($protocol, CircuitChange::$OFF);
                break;

            case 'waterfallOn':
                $cmd = CircuitChange::waterfall($protocol, CircuitChange::$ON);
                break;
            case 'waterfallOff':
                $cmd = CircuitChange::waterfall($protocol, CircuitChange::$OFF);
                break;

            case 'alvinOn':
                $cmd = CircuitChange::alvin($protocol, CircuitChange::$ON);
                break;
            case 'alvinOff':
                $cmd = CircuitChange::alvin($protocol, CircuitChange::$OFF);
                break;

            default:
                throw new \UnexpectedValueException("Circuit not supported or recognized.");
        }
        $this->pentair->write($cmd);

        $ack = $this->pentair->read();
        $hexstr = new HexStringSampleConnector($ack->getSignal());
        $com = new PentairComFacade($hexstr);
        $pentair = new Pentair($com);

        $ack->parsed($pentair->read()->toJson());

        return $this->respondWithData($ack);
    }
}

