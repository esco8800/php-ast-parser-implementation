<?php

namespace classes;

use PhpParser\ParserFactory;
use PhpParser\Error;
use PhpParser\PrettyPrinter\Standard;

class Generator
{

    public function run()
    {
        $modelInitialPath = __DIR__ . '/initial/Museum.php';
        $modelChangedPath = __DIR__ . '/changed/Museum.php';
        $modelOutputPath = __DIR__ . '/output/Museum.php';

        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);

        try {
            $astInitial = $parser->parse(file_get_contents($modelInitialPath));
            $astChanged = $parser->parse(file_get_contents($modelChangedPath));

            $prettyPrinter = new Standard;
            file_put_contents($modelOutputPath, $prettyPrinter->prettyPrintFile($astInitial));

        } catch (Error $error) {
            echo "Parse error: {$error->getMessage()}\n";
            return;
        }
    }



}