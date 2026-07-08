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
 * A node of the form Tree
 *
 * @author Thomas Jarrand <thomas.jarrand@gmail.com>
 */
class FormTreeNode
{
    /**
     * The name of the node
     *
     * @var string
     */
    private $name;

    /**
     * Whether or not the node has labeled children.
     *
     * @var bool
     */
    private $children;

    /**
     * Whether or not the node is a collection.
     *
     * @var bool
     */
    private $collection;

    /**
     * Whether or not the node is a prototype.
     *
     * @var bool
     */
    private $prototype;

    /**
     * Constructor
     *
     * @param string $name       The node's name
     * @param bool   $children   Whether or not the node has labeled children
     * @param bool   $collection Is the node a collection
     * @param bool   $prototype  Is the node a prototype
     */
    public function __construct($name, $children = false, $collection = false, $prototype = false)
    {
        $this->name = (string) $name;
        $this->children = (bool) $children;
        $this->collection = (bool) $collection;
        $this->prototype = (bool) $prototype;
    }

    /**
     * Get the name of the node
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Does the node has labeled children?
     *
     * @return bool
     */
    public function hasChildren()
    {
        return $this->children;
    }

    /**
     * Is the node a collection?
     *
     * @return bool
     */
    public function isCollection()
    {
        return $this->collection;
    }

    /**
     * Is the node a prototype?
     *
     * @return bool
     */
    public function isPrototype()
    {
        return $this->prototype;
    }
}
