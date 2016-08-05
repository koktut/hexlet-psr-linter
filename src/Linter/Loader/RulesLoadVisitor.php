<?php

namespace HexletPsrLinter\Linter\Loader;

use function HexletPsrLinter\getTargetFiles;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Node;

/**
 * Class RulesLoaderVisitor
 * @package HexletPsrLinter\Linter
 */
class RulesLoadVisitor extends NodeVisitorAbstract
{
    private $namespace;
    private $className;

    /**
     * @param Node $node
     * @return int
     */
    public function enterNode(Node $node)
    {
        if ($node instanceof Node\Stmt\Namespace_) {
            $this->namespace = $node->name;
        }
        if ($node instanceof Node\Stmt\Class_) {
            $this->className = $node->name;
            return NodeTraverser::DONT_TRAVERSE_CHILDREN;
        }
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return $this->className;
    }
}
