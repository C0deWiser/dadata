<?php

namespace Codewiser\Dadata\Names;

use Codewiser\Dadata\ArrayBased;

/**
 * @property string $source
 * @property string $result
 * @property null|string $result_genitive
 * @property null|string $result_dative
 * @property null|string $result_ablative
 * @property null|string $surname
 * @property null|string $name
 * @property null|string $patronymic
 * @property string $gender
 * @property integer $qc
 */
class CleanName extends ArrayBased implements \Stringable
{
    protected array $casts = [
        'qc' => 'integer',
    ];

    public function __toString()
    {
        return $this->result ?? '';
    }
}