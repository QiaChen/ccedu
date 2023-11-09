<?php
/**
 * Initialize a dependency injection container that implemented PSR-11 and return the container.
 */

declare(strict_types=1);
/**
 * This file is part of CcEdu.
 *
 * @link     https://ccedu.cqq.me
 * @document https://github.com/qiachen/ccedu
 * @contact  i@cqq.me
 * @license  https://github.com/qiachen/ccedu/blob/master/LICENSE
 */
use Hyperf\Context\ApplicationContext;
use Hyperf\Di\Container;
use Hyperf\Di\Definition\DefinitionSourceFactory;

$container = new Container((new DefinitionSourceFactory())());

return ApplicationContext::setContainer($container);
