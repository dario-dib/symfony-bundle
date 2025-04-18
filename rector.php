<?php

declare(strict_types=1);

/**
 * This file is part of DOCtor-RST.
 *
 * (c) Oskar Stark <oskarstark@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use Rector\Config\RectorConfig;
use Rector\Doctrine\Set\DoctrineSetList;
use Rector\PHPUnit\CodeQuality\Rector\Class_\PreferPHPUnitSelfCallRector;
use Rector\PHPUnit\CodeQuality\Rector\Class_\PreferPHPUnitThisCallRector;
use Rector\PHPUnit\CodeQuality\Rector\ClassMethod\ReplaceTestAnnotationWithPrefixedFunctionRector;
use Rector\PHPUnit\PHPUnit100\Rector\Class_\StaticDataProviderClassMethodRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Symfony\Set\SymfonySetList;
use Rector\ValueObject\PhpVersion;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->parallel();
    $rectorConfig->paths([
        __DIR__.'/.php-cs-fixer.dist.php',
        __DIR__.'/rector.php',
        __DIR__.'/src',
        __DIR__.'/tests',
    ]);

    $rectorConfig->phpVersion(PhpVersion::PHP_83);
    $rectorConfig->importNames();
    $rectorConfig->importShortClasses(false);
    $rectorConfig->phpstanConfigs([
        getcwd().'/phpstan.neon.dist',
        'vendor/phpstan/phpstan-webmozart-assert/extension.neon',
    ]);

    $rectorConfig->sets([
        SetList::PHP_83,
        PHPUnitSetList::PHPUNIT_CODE_QUALITY,
        PHPUnitSetList::PHPUNIT_110,
        SymfonySetList::SYMFONY_CODE_QUALITY,
    ]);

    $rectorConfig->skip([
        PreferPHPUnitThisCallRector::class,
        ReplaceTestAnnotationWithPrefixedFunctionRector::class,
        AddOverrideAttributeToOverriddenMethodsRector::class,
    ]);

    $rectorConfig->rule(PreferPHPUnitSelfCallRector::class);

    /**
     * @see https://github.com/rectorphp/rector-phpunit/blob/main/docs/rector_rules_overview.md#staticdataproviderclassmethodrector
     */
    $rectorConfig->rule(StaticDataProviderClassMethodRector::class);
};
