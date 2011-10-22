<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\NewsletterBundle\Form\DataTransformer;

use Sylius\Bundle\NewsletterBundle\Model\NewsletterInterface;
use Sylius\Bundle\NewsletterBundle\Model\NewsletterManagerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Newsletter to id transformer.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class NewsletterToIdTransformer implements DataTransformerInterface
{
    /**
     * Newsletter manager.
     * 
     * @var NewsletterManagerInterface
     */
    protected $newsletterManager;
    
    /**
     * Constructor.
     * 
     * @param NewsletterManagerInterface $newsletterManager
     */
    public function __construct(NewsletterManagerInterface $newsletterManager)
    {
        $this->newsletterManager = $newsletterManager;
    }
    
    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if (null == $value) {
            return null;
        }
        
        if (!$value instanceof NewsletterInterface) {
            throw new UnexpectedTypeException($value, 'Sylius\Bundle\NewsletterBundle\Model\NewsletterInterface');
        }
        
        return $value->getId();
    }
    
    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        if ($value == null || $value == '') {
            return null;
        }
        
        if (!is_numeric($value)) {
            throw new UnexpectedTypeException($value, 'numeric');
        }
        
        $newsletter = $this->newsletterManager->findNewsletter($value);
        
        if (!$newsletter) {
            throw new TransformationFailedException('Newsletter with given id does not exist.');
        }
        
        return $newsletter;
    }
}
