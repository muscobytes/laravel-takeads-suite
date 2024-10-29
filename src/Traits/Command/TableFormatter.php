<?php

namespace Muscobytes\Laravel\Takeads\Coupons\Traits\Command;

trait TableFormatter
{
    protected const DEFAULT_COLUMN_WIDTH = 20;

    protected function arrayCombineKeys(
        array $array1,
        string $key1,
        array $array2,
        string $key2
    ): array {
        $result = [];

        foreach ($array1 as $key => $value1) {
            $value2 = $array2[$key] ?? self::DEFAULT_COLUMN_WIDTH;
            $result[] = [
                $key1 => $this->getTruncatedValue((string)$value1, $value2),
                $key2 => (int)$value2
            ];
        }

        return $result;
    }


    protected function getTruncatedValue(string $string, int $length): string
    {
        return mb_strlen(mb_substr($string, 0, $length - 2)) == mb_strlen($string)
            ? $string
            : mb_substr($string, 0, $length - 2) . "\u{2026}" // "…"
            ;
    }


    public function formatRow(array $row, array $widths = []): string
    {
        return implode('', array_map(function($row) {
            return $row['value'] . str_repeat(' ', $row['width'] - mb_strlen($row['value']));
        }, $this->arrayCombineKeys($row, 'value', $widths, 'width')));
    }
}
