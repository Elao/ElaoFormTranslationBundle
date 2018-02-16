<?php

/**
 * This file is part of the ElaoFormTranslation bundle.
 *
 * Copyright (C) 2014 Elao
 *
 * @author Elao <contact@elao.com>
 */

namespace Elao\Bundle\FormTranslationBundle\Model;

/**
 * A form Tree
 *
 * @author Thomas Jarrand <thomas.jarrand@gmail.com>
 */
class FormTree implements \Iterator, \Countable, \ArrayAccess
{
    /**
     * The FormTreeNode elements
     *
     * @var array
     */
    private $nodes;

    /**
     * Current position in the loop
     *
     * @var integer
     */
    private $position = 0;

    /**
     * Constructor
     *
     * @param array $nodes
     */
    public function __construct($nodes = array())
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
    public function addParent(FormTreeNode $node)
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
    public function addChild(FormTreeNode $node)
    {
        return array_push($this->nodes, $node);
    }

    /**
     * Set the loop back to the start
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Return the length of the tree
     *
     * @return int
     */
    public function count()
    {
        return count($this->nodes);
    }

    /**
     * Return the current Node in the loop
     *
     * @return FormTreeNode
     */
    public function current()
    {
        return $this->nodes[$this->position];
    }

    /**
     * Return the current position in the loop
     *
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Increment current position
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Return whether or not the current position is valid
     *
     * @return int
     */
    public function valid()
    {
        return $this->offsetExists($this->position);
    }

    /**
     * Return whether or not the given offset exists
     *
     * @param mixed $offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->nodes[$offset]);
    }

    /**
     * Get the node at the given offset
     *
     * @param mixed $offset
     *
     * @return FormTreeNode
     */
    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->nodes[$offset] : null;
    }

    /**
     * Set the node at the given offset
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        /* Not implemented: Use addParent and addChild methods */
    }

    /**
     * Unset node at the given offset
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        /* Not implemented: FormTree nodes should not be unsetable */
    }
}
