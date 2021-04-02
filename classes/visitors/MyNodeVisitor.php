<?php

namespace classes\visitors;

use PhpParser\NodeVisitorAbstract;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Name;

class MyNodeVisitor extends NodeVisitorAbstract
{
    /**
     * {@inheritdoc}
     */
//    public function enterNode(Node $node): Node
//    {
//        if (false === ($node instanceof ClassMethod)) {
//            return $node;
//        }
//
//        /** @var ClassMethod $node */
//        return new NullNode(
//            array_map(
//                function (ClassMethod $method) use ($node): ClassMethod {
//                    return new Node\Stmt\Const_([$method], $node->getAttributes());
//                },
//                $node->
//            )
//        );
//    }

}