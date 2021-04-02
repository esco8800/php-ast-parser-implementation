<?php

namespace classes;

use PhpParser\{Lexer, NodeTraverser, NodeVisitor, Parser, PrettyPrinter, NodeFinder, Error};
use classes\visitors\MyNodeVisitor;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\ParserFactory;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;

class Generator
{
    private $parser;
    private $lexer;
    private $traverser;
    private $printer;

    public function __construct()
    {
//        $this->lexer = new Lexer\Emulative([
//            'usedAttributes' => [
//                'comments',
//                'startLine', 'endLine',
//                'startTokenPos', 'endTokenPos',
//            ],
//        ]);
//        $this->parser = new Parser\Php7($this->lexer);
        $this->parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
//        $this->traverser = new NodeTraverser();
//        $this->traverser->addVisitor(new NodeVisitor\CloningVisitor());
//        $this->traverser->addVisitor(new MyNodeVisitor);
        $this->printer = new PrettyPrinter\Standard(['shortArraySyntax']);
    }


    public function run()
    {
        try {

            $this->generateModel();

        } catch (Error $error) {
            echo "Parse error: {$error->getMessage()}\n";
            return;
        }
    }

    public function generateModel()
    {
        $modelInitialPath = __DIR__ . '/initial/Museum.php';
        $modelChangedPath = __DIR__ . '/changed/Museum.php';
        $modelOutputPath = __DIR__ . '/output/Museum.php';

        $oldStmts = $this->getOldSmtms($modelInitialPath);

        $changedStmts = $this->parser->parse(file_get_contents($modelChangedPath));
//        $changedTokens = $this->lexer->getTokens();

        $newStmts = $this->replaceGroupUseStatements($oldStmts, $changedStmts);
//        $newStmts = $this->traverser->traverse($newStmts);

         // MODIFY $newStmts HERE

        $newCode = $this->printer->prettyPrintFile($newStmts);
        file_put_contents($modelOutputPath, $newCode);
    }

    protected function getOldSmtms($modelInitialPath): array
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        return $parser->parse(file_get_contents($modelInitialPath));
    }

    /**
     * @param $stmts
     * @return \PhpParser\Node[]
     */
    protected function getClassMethods($stmts)
    {
        $nodeFinder = new NodeFinder();
        return $nodeFinder->findInstanceOf($stmts, ClassMethod::class);
    }


    /**
     * @param $oldStmts
     * @param $changedStmts
     * @return ClassMethod[]
     */
    protected function getMergeMethods($oldStmts, $changedStmts)
    {
        $oldClassMethods = $this->getClassMethods($oldStmts);
        $changedClassMethods = $this->getClassMethods($changedStmts);

        $diff = [];

        /**
         * @var ClassMethod $oldClassMethod
         * @var ClassMethod $changedClassMethod
         */
        foreach ($oldClassMethods as $oldClassMethod) {
            $flag = 0;
            foreach ($changedClassMethods as $changedClassMethod) {
                if ($oldClassMethod->name->name === $changedClassMethod->name->name) {
                    $flag = 1;
                }
            }
            if (!$flag) {
                $diff[] = $oldClassMethod;
            }
        }

        return $diff;
    }

    /**
     * @param array $oldStmts
     * @param array $changedStmts
     *
     * @return array
     */
    private function replaceGroupUseStatements(array $oldStmts, array $changedStmts): array
    {
        $diff = $this->getMergeMethods($oldStmts, $changedStmts);

        foreach ($changedStmts as $changedStmt) {
            foreach ($changedStmt->stmts as $stmt) {

                if (false === ($stmt instanceof Class_)) {
                    continue;
                }

                $stmt->stmts = array_merge($stmt->stmts, $diff);
                var_dump($stmt->stmts);
            }
        }

        return $changedStmts;
    }

}