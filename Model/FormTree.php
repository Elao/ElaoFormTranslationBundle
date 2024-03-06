<?php

/*
 * This file is part of the ElaoFormTranslation bundle.
 *
 * Copyright (C) Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormTranslationBundle\Model;

/**
 * A form Tree
 *
 * @author Thomas Jarrand <thomas.jarrand@gmail.com>
 *
 * @implements \Iterator<FormTreeNode>
 * @implements \ArrayAccess<int,FormTreeNode>
 */
class FormTree implements \Iterator, \Countable, \ArrayAccess
{
    /**
     * The FormTreeNode elements
     *
     * @var array<FormTreeNode>
     */
    private array $nodes;

    /**
     * Current position in the loop
     */
    private int $position = 0;

    /**
     * @param array<FormTreeNode> $nodes
     */
    public function __construct(array $nodes = [])
    {
        $this->nodes = $nodes;
    }

    /**
     * Add a parent node to the beginning of the tree
     *
     * @param FormTreeNode $node The node
     *
     * @return int The new number of elements in the Tree
     */
    public function addParent(FormTreeNode $node): int
    {
        return array_unshift($this->nodes, $node);
    }

    /**
     * Add a child node to the end of the tree
     *
     * @param FormTreeNode $node The node
     *
     * @return int The new number of elements in the Tree
     */
    public function addChild(FormTreeNode $node): int
    {
        return array_push($this->nodes, $node);
    }

    /**
     * Set the loop back to the start
     */
    #[\ReturnTypeWillChange]
    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * Return the length of the tree
     */
    public function count(): int
    {
        return \count($this->nodes);
    }

    /**
     * Return the current Node in the loop
     */
    #[\ReturnTypeWillChange]
    public function current(): FormTreeNode
    {
        return $this->nodes[$this->position];
    }

    /**
     * Return the current position in the loop
     */
    #[\ReturnTypeWillChange]
    public function key(): int
    {
        return $this->position;
    }

    /**
     * Increment current position
     */
    #[\ReturnTypeWillChange]
    public function next(): void
    {
        ++$this->position;
    }

    /**
     * Return whether or not the current position is valid
     */
    #[\ReturnTypeWillChange]
    public function valid(): bool
    {
        return $this->offsetExists($this->position);
    }

    /**
     * Return whether or not the given offset exists
     */
    #[\ReturnTypeWillChange]
    public function offsetExists($offset): bool
    {
        return isset($this->nodes[$offset]);
    }

    /**
     * Get the node at the given offset
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset): ?FormTreeNode
    {
        return $this->offsetExists($offset) ? $this->nodes[$offset] : null;
    }

    /**
     * Set the node at the given offset
     */
    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value): void
    {
        /* Not implemented: Use addParent and addChild methods */
    }

    /**
     * Unset node at the given offset
     */
    #[\ReturnTypeWillChange]
    public function offsetUnset($offset): void
    {
        /* Not implemented: FormTree nodes should not be unsetable */
    }
}
