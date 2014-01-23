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
	 * Weither or not the node has labeled children.
	 *
	 * @var boolean
	 */
	private $children;

	/**
	 * Weither or not the node is a collection.
	 *
	 * @var boolean
	 */
	private $collection;

	/**
	 * Weither or not the node is a prototype.
	 *
	 * @var boolean
	 */
	private $prototype;

	/**
	 * Constructor
	 *
	 * @param string  $name
	 * @param boolean $children
	 * @param boolean $collection
	 * @param boolean $prototype
	 */
	public function __construct($name, $children = false, $collection = false, $prototype = false)
	{
		$this->name       = (string) $name;
		$this->children   = (boolean) $children;
		$this->collection = (boolean) $collection;
		$this->prototype  = (boolean) $prototype;
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
	 * @return boolean
	 */
	public function hasChildren()
	{
		return $this->children;
	}

	/**
	 * Is the node a collection?
	 *
	 * @return boolean
	 */
	public function isCollection()
	{
		return $this->collection;
	}

	/**
	 * Is the node a prototype?
	 *
	 * @return boolean
	 */
	public function isPrototype()
	{
		return $this->prototype;
	}
}
