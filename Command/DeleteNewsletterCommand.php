<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\NewsletterBundle\Command;

use Sylius\Bundle\NewsletterBundle\EventDispatcher\Event\FilterNewsletterEvent;
use Sylius\Bundle\NewsletterBundle\EventDispatcher\SyliusNewsletterEvents;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;

/**
 * Command for console that deletes newsletter.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class DeleteNewsletterCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('sylius:assortment:newsletter:delete')
            ->setDescription('Deletes a newsletter.')
            ->setDefinition(array(
                new InputArgument('id', InputArgument::REQUIRED, 'The newsletter id'),
            ))
            ->setHelp(<<<EOT
The <info>sylius:assortment:newsletter:delete</info> command deletes a newsletter:

  <info>php sylius/console sylius:assortment:newsletter:delete 24</info>
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $newsletter = $this->getContainer()->get('sylius_newsletter.manager.newsletter')->findNewsletter($input->getArgument('id'));
        
        if (!$newsletter) {
            throw new \InvalidArgumentException(sprintf('The newsletter with id "%s" does not exist.', $input->getArgument('id')));
        }
        
        $this->getContainer()->get('event_dispatcher')->dispatch(SyliusNewsletterEvents::NEWSLETTER_DELETE, new FilterNewsletterEvent($newsletter));
        $this->getContainer()->get('sylius_newsletter.manipulator.newsletter')->delete($newsletter);

        $output->writeln(sprintf('Deleted newsletter with id: <comment>%s</comment>', $input->getArgument('id')));
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('id')) {
            $id = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please insert newsletter id: ',
                function($id = null)
                {
                    if (empty($id)) {
                        throw new \Exception('Newsletter id must be specified.');
                    }
                    if (!is_numeric($id)) {
                        throw new \Exception('Newsletter id must be integer.');
                    }
                    return $id;
                }
            );
            $input->setArgument('id', $id);
        }
    }
}
