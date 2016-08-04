<?php

namespace HexletPsrLinter\Linter;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Node\Stmt;
use PhpParser\PrettyPrinter;
use PhpParser\NodeTraverser;

/**
 * Class SideEffectsDeclarationsVisitor
 * @package HexletPsrLinter\Linter
 */
class SideEffectsDeclarationsVisitor extends NodeVisitorAbstract
{
    private $sideEffects;
    private $declarations;

    /**
     * @param Node $node
     * @return int
     */
    public function enterNode(Node $node)
    {
        if (!($node instanceof Stmt\Namespace_)) {
            $this->sideEffects |= $this->isSideEffect($node);
            $this->declarations |= $this->isDeclaration($node);
            return NodeTraverser::DONT_TRAVERSE_CHILDREN;
        }
    }

    /**
     * @return bool
     */
    public function isMixed()
    {
        return $this->sideEffects && $this->declarations;
    }

    /**
     * @param $node
     * @return mixed
     */
    private function isSideEffect($node)
    {
        $sideEffectNodeTypes = [
            Node\Expr::class,
            Node\Stmt\Echo_::class
        ];

        foreach ($sideEffectNodeTypes as $type) {
            if ($node instanceof $type) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * @param $node
     * @return bool
     */
    private function isDeclaration($node)
    {
        $excludeTypes = [
            Node\Stmt\Echo_::class,
        ];
        $declarationNodeTypes = [
            Node\Stmt::class,
        ];

        foreach ($excludeTypes as $type) {
            if ($node instanceof $type) {
                return false;
            }
        }

        foreach ($declarationNodeTypes as $type) {
            if ($node instanceof $type) {
                return true;
            }
        }

        return false;
    }
}
