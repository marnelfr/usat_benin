<?php

/**
 * Created by PhpStorm
 * User: gmlgi
 * Date: 14/08/2020
 * Time: 21:46
 */

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class Md5Extension extends AbstractExtension
{

    public function getFilters(): array
    {
        return [
            new TwigFilter('md5', [$this, 'md5Converter']),
        ];
    }

    public function md5Converter(string $word)
    {
        return md5($word);
    }

}