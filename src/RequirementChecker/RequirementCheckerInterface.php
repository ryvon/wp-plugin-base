<?php

namespace Ryvon\Plugin\RequirementChecker;

interface RequirementCheckerInterface
{
    /**
     * @return string[] Errors
     */
    public function verify(): array;
}
