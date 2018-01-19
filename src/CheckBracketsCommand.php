<?php

namespace App;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

use Brackets\Checker;

class CheckBracketsCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:check-brackets')
            ->setDescription('Checks brackets in a given file.')
            ->addArgument('file', InputArgument::REQUIRED, 'Provide path to file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $checker = new Checker();

        $file = $input->getArgument('file');

        if (!file_exists($file)) {
            $output->writeln('File does not exist!');
            return false;
        }

        $str = file_get_contents($file);
        if(!$str){
            $output->writeln('Could not get file contents!');
            return false;
        }

        try{
            if($checker->check($str)){
                $output->writeln('Brackets are ok!');
            } else {
                $output->writeln('Incorrect brackets!');
            }

        } catch (\InvalidArgumentException $e){
            $output->writeln($e->getMessage());
        }
    }
}