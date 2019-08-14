<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\TypeTrait;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

trait ActionTrait
{
    protected $actionStatus;
    protected $agent;
    protected $endTime;
    protected $error;
    protected $instrument;
    protected $location;
    protected $object;
    protected $participant;
    protected $result;
    protected $startTime;
    protected $target;
}
