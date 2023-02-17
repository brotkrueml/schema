<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Provider;

use Brotkrueml\Schema\Core\Model\WebPageTypeInterface;
use TYPO3\CMS\Core\Package\PackageManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @internal
 */
final class WebPageTypeProvider
{
    /**
     * This method is super-ugly, but will be reworked with v3.0.
     * As it is called only once when building up the TCA cache it is okay for now.
     * @see https://github.com/brotkrueml/schema/issues/102
     * @see https://github.com/brotkrueml/schema/issues/75
     *
     * @return list<string[]>
     */
    public static function getTypesForTcaSelect(): array
    {
        $select = [['', '']];

        $packageManager = GeneralUtility::makeInstance(PackageManager::class);
        $packages = $packageManager->getActivePackages();
        $allTypeModels = [];
        foreach ($packages as $package) {
            $typeModelsConfiguration = $package->getPackagePath() . 'Configuration/TxSchema/TypeModels.php';
            if (\file_exists($typeModelsConfiguration)) {
                $typeModelsInPackage = require $typeModelsConfiguration;
                if (\is_array($typeModelsInPackage)) {
                    $allTypeModels = \array_merge($allTypeModels, $typeModelsInPackage);
                }
            }
        }

        $webPageTypes = [];
        foreach ($allTypeModels as $typeModel) {
            if (array_key_exists(WebPageTypeInterface::class, (new \ReflectionClass($typeModel))->getInterfaces())) {
                $type = \substr(\strrchr((string)$typeModel, '\\') ?: '', 1);
                // In PHP < 8.0 substr('', 1) returns false, in PHP >= 8.0 an empty string is returned, see: https://3v4l.org/Zk6kK
                // An empty string should not be used, here is something wrong with the type
                if ($type === false) { // @phpstan-ignore-line
                    continue;
                }
                if ($type === '') {
                    continue;
                }

                $webPageTypes[] = $type;
            }
        }

        \sort($webPageTypes);
        foreach ($webPageTypes as $type) {
            $select[] = [$type, $type];
        }

        return $select;
    }
}
