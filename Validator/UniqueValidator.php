<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\NewsletterBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Sylius\Bundle\NewsletterBundle\Model\SubscriberManagerInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\ValidatorException;

/**
 * Unique validator.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class UniqueValidator extends ConstraintValidator
{
    /**
     * @var SubscriberManager
     */
    protected $subscriberManager;

    /**
     * Constructor
     *
     * @param SubscriberManagerInterface $subscriberManager
     */
    public function __construct(SubscriberManagerInterface $subscriberManager)
    {
        $this->subscriberManager = $subscriberManager;
    }
    
    /**
     * Indicates whether the constraint is valid.
     *
     * @param Entity     $value
     * @param Constraint $constraint
     */
    public function isValid($value, Constraint $constraint)
    {
        $value = $value->{'get' . ucfirst($constraint->property)}();
        $subscriber = $this->subscriberManager->findSubscriberBy(array($constraint->property => $value));
        
        if ($subscriber) {
            return false;
        }
        
        return true;
    }
}
