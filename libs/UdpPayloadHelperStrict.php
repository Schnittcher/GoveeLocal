<?php

declare(strict_types=1);

trait GoveeUdpPayloadHelper
{
    /**
     * Der UDP-Socket übergibt und erwartet den Buffer hexkodiert.
     */
    protected function EncodePayload(string $Payload): string
    {
        return bin2hex($Payload);
    }

    /**
     * Liefert den Klartext aus dem Buffer eines Datenpakets des UDP-Sockets.
     */
    protected function DecodePayload(string $Buffer): string
    {
        if ($Buffer !== '' && strlen($Buffer) % 2 === 0 && ctype_xdigit($Buffer)) {
            return (string) hex2bin($Buffer);
        }
        return $Buffer;
    }
}
