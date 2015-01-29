<?php


namespace Briedis\ApiBuilder;


use Briedis\ApiBuilder\Items\BaseItem;
use Briedis\ApiBuilder\Items\Float;
use Briedis\ApiBuilder\Items\Integer;
use Briedis\ApiBuilder\Items\String;
use Briedis\ApiBuilder\Items\Structure;

class StructureBuilder{
	/**
	 * @var string
	 */
	private $structureName;

	/**
	 * @var BaseItem[]
	 */
	private $items = [];

	/**
	 * @var BaseItem
	 */
	private $lastItem;

	/**
	 * Create a new structure
	 * @param string $structureName
	 */
	public function __construct($structureName = ''){
		$this->structureName = $structureName;
	}

	private function addItem($item){
		$this->items[$item->name] = $item;
		$this->lastItem = $item;
		return $this;
	}

	/**
	 * Integer type
	 * @param string $name
	 * @param string $description
	 * @return StructureBuilder
	 */
	public function int($name, $description = ''){
		return $this->addItem(new Integer($name, $description));
	}

	/**
	 * String type
	 * @param string $name
	 * @param string $description
	 * @return StructureBuilder
	 */
	public function string($name, $description = ''){
		return $this->addItem(new String($name, $description));
	}

	/**
	 * Float type
	 * @param $name
	 * @param string $description
	 * @return StructureBuilder
	 */
	public function float($name, $description = ''){
		return $this->addItem(new Float($name, $description));
	}

	/**
	 * Set item as another structure
	 * @param string $name
	 * @param StructureBuilder $structure
	 * @param string $description
	 * @return StructureBuilder
	 */
	public function struct($name, StructureBuilder $structure, $description = ''){
		$item = new Structure($name, $description);
		$item->structure = $structure;
		return $this->addItem($item);
	}

	/**
	 * Mark item as optional
	 * @return self
	 */
	public function optional(){
		$this->lastItem->isOptional = true;
		return $this;
	}

	/**
	 * Mark item as enum and specify valid values
	 * @param array $values
	 * @return self
	 */
	public function enum(array $values){
		$this->lastItem->isEnum = true;
		$this->lastItem->enumValues = $values;
		return $this;
	}

	/**
	 * Mark item as an array
	 * @return self
	 */
	public function many(){
		$this->lastItem->isArray = true;
		return $this;
	}
}