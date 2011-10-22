<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\NewsletterBundle\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Unique constraint.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class Unique extends Constraint
{
    public $message = 'The value for "%property%" already exists.';
    public $property;

    public function defaultOption()
    {
        return 'property';
    }

    public function requiredOptions()
    {
        return array('property');
    }
    
    public function validatedBy()
    {
        return 'sylius_newsletter.validator.unique';
    }

    /**
     * @see Symfony\Component\Validator.Constraint::getTargets()
     */
    public function getTargets()
    {
        return Constraint::CLASS_CONSTRAINT;
    }
}
