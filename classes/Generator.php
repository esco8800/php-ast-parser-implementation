<?php

namespace classes;

use PhpParser\{Lexer, NodeTraverser, NodeVisitor, Parser, PrettyPrinter, NodeFinder, Error};
use classes\visitors\MyNodeVisitor;
use PhpParser\Node\Stmt\ClassMethod;
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
        $this->lexer = new Lexer\Emulative([
            'usedAttributes' => [
                'comments',
                'startLine', 'endLine',
                'startTokenPos', 'endTokenPos',
            ],
        ]);
        $this->parser = new Parser\Php7($this->lexer);
        $this->traverser = new NodeTraverser();
        $this->traverser->addVisitor(new NodeVisitor\CloningVisitor());
        $this->traverser->addVisitor(new MyNodeVisitor);
        $this->printer = new PrettyPrinter\Standard();
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

        $oldStmts = $this->parser->parse(file_get_contents($modelInitialPath));
        $oldTokens = $this->lexer->getTokens();

        $changedStmts = $this->parser->parse(file_get_contents($modelChangedPath));
        $changedTokens = $this->lexer->getTokens();

        $newStmts = $this->replaceGroupUseStatements($oldStmts, $changedStmts);

//        $newStmts = $this->traverser->traverse($changedStmts);

         // MODIFY $newStmts HERE

        $newCode = $this->printer->printFormatPreserving($newStmts, $changedStmts, $changedTokens);
        file_put_contents($modelOutputPath, $newCode);
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
        return array_merge($diff, $changedClassMethods);
    }

    /**
     * @param Node[] $oldStmts
     * @param Node[] $changedStmts
     *
     * @return Node[]
     */
    private function replaceGroupUseStatements(array $oldStmts, array $changedStmts): array
    {
        $newMethods = $this->getMergeMethods($oldStmts, $changedStmts);

        foreach ($oldStmts as $oldStmt) {
            if (false === ($oldStmt instanceof Class_)) {
                continue;
            }

            /** @var Class_ $oldStmt */
            $statements = $oldStmt->stmts;

            $newStatements = [];

            foreach ($statements as $statement) {
                if ($statement instanceof ClassMethod) {
                    continue;
                } else {
                    $newStatements[] = $statement;
                }
            }
            $newNodes = array_merge($newMethods, $newStatements);
            $oldStmt->stmts = $newNodes;
        }
        return $oldStmts;
    }

}