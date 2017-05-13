<?php

namespace LinkORB\BasicUser\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Output\OutputInterface;

class HashPasswordCommand extends Command
{
    private $plaintext;

    protected function configure()
    {
        $this
            ->setDescription(
                'Generate a hashed password using PHP\'s password_hash with the PASSWORD_DEFAULT algorithm.'
            )
            ->setHelp('The command interactively asks for the password before printing its hash.')
            ->addOption(
                'cost',
                'c',
                InputOption::VALUE_REQUIRED,
                'Algorithmic cost of the hash function.',
                12
            )
        ;
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new Question('<question>Please provide the plain password:</question>');
        $question->setHidden(true);
        $question->setHiddenFallback(false);
        $this->plaintext = $helper->ask($input, $output, $question);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $hash = password_hash(
            $this->plaintext,
            PASSWORD_DEFAULT,
            [
                'cost' => $input->getOption('cost'),
            ]
        );
        $this->plaintext = null;

        $output->writeLn(
            [
                '<info>Hashed password:-</info>',
                "<comment>{$hash}</comment>",
            ]
        );
    }
}
