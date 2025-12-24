<?php

declare(strict_types=1);

/**
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 *
 * @author  Korotkov Danila (Jagepard) <jagepard@yandex.ru>
 * @license https://mozilla.org/MPL/2.0/  MPL-2.0
 */


namespace Rudra\Annotation;

interface AnnotationInterface
{
    /**
     * @param string $className
     * @param string|null $methodName
     * @return array
     */
    public function getAnnotations(string $className, ?string $methodName = null): array;

    /**
     * @param string $className
     * @param string|null $methodName
     * @return array
     */
    public function getAttributes(string $className, ?string $methodName = null): array;
}
