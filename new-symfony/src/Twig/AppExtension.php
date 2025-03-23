<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_current_user', [$this, 'getCurrentUser']),
        ];
    }

    public function getCurrentUser(): string
    {
        return function_exists('posix_getpwuid') 
            ? posix_getpwuid(posix_geteuid())['name'] 
            : get_current_user();
    }
}