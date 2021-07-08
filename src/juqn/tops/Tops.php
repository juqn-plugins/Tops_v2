<?php

declare(strict_types=1);

namespace juqn\tops;

use juqn\tops\commands\TopCommand;
use juqn\tops\entities\FistPosition;
use juqn\tops\entities\SecondPosition;
use juqn\tops\entities\ThirdPosition;
use pocketmine\entity\Entity;

/**
 * Class Tops
 * @package juqn\tops
 */
class Tops extends PluginBase
{
	
	/** @var Tops */
	private static Tops $instance;
	
	public function onLoad()
	{
		self::$instance = $this;
	}
	
	public function onEnable()
	{
		# Config
		if (!is_dir($this->getDataFolder() . 'skins'))
			@mkdir($this->getDataFolder() . 'skins');
		$this->saveResource('kills.yml');
		
		# Commands
		$this->getServer()->getCommandMap()->register('/top', new TopCommand());

		# Entities
		Entity::registerEntity(FistPosition::class, true);
		Entity::registerEntity(SecondPosition::class, true);
		Entity::registerEntity(ThirdPosition::class, true);
		
		# Listener
		$this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
	}
	
	/**
	 * @return Tops
	 */
	public static function getInstance(): Tops
	{
		return self::$instance;
	}
}