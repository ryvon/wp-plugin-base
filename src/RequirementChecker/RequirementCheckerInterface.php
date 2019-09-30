<?php

namespace Ryvon\Plugin\RequirementChecker;

interface RequirementCheckerInterface
{
    /**
     * @return string[]|null The requirement errors to show the user.
     */
    public function check(): ?array;
}
