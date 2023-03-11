<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 01/04/2018
 * Time: 09:16.
 */

namespace Peru\Sunat;

use Peru\Http\ClientInterface;
use Peru\Sunat\Parser\XpathLoader;

/**
 * Class UserValidator.
 */
class UserValidator
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Consulta válidez del usuario SOL.
     */
    public function valid(string $ruc, string $user): bool
    {
        $this->client->get(Endpoints::USER_VALIDEZ);
        $html = $this->client->post(Endpoints::USER_VALIDEZ, [
            'accion' => 'e1',
            'ruc' => $ruc,
            'usr' => $user,
        ]);

        $state = $this->getStatus($html);

        return str_contains(strtoupper($state), 'ACTIVO');
    }

    private function getStatus(string $html): string
    {
        $xpt = XpathLoader::getXpathFromHtml($html);
        $nodes = $xpt->query('//strong');

        if (1 !== $nodes->length) {
            return '';
        }

        return $nodes->item(0)->nodeValue;
    }
}
