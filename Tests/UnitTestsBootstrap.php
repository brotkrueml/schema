<?php
call_user_func(function () {
    /** @noinspection PhpFullyQualifiedNameUsageInspection */
    $testbase = new \TYPO3\TestingFramework\Core\Testbase();
    $testbase->enableDisplayErrors();
    $testbase->defineBaseConstants();
});
