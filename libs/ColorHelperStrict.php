<?php

declare(strict_types=1);

trait GoveeColorHelper
{
    /**
     * @return array{0: int, 1: int, 2: int} Rot, Grün, Blau
     */
    protected function HexToRGB(int $value): array
    {
        return [($value >> 16) & 0xFF, ($value >> 8) & 0xFF, $value & 0xFF];
    }

    protected function RGBToHex(int $r, int $g, int $b): int
    {
        return ($r << 16) + ($g << 8) + $b;
    }
}
