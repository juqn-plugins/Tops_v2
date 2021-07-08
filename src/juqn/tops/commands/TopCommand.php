<?php

declare(strict_types=1);

namespace juqn\tops\commands;

use juqn\tops\entities\FistPosition;
use juqn\tops\entities\SecondPosition;
use juqn\tops\entities\ThirdPosition;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

/**
 * Class TopCommand
 * @package juqn\tops\commands
 */
class TopCommand extends Command
{
	
	/**
	 * TopCommand construct.
	 */
	public function __construct()
	{
		parent::__construct('tops');
		$this->setPermission('tops.command.permission');
	}
	
	/**
	 * @param CommandSender $sender
	 * @param string $commandLabel
	 * @param array $args
	 */
	public function execute(CommandSender $sender, string $commandLabel, array $args): void
	{
		if (!$sender instanceof Player)
			return;
		
		if (!$this->testPermission($sender))
			return;
		
		if (!isset($args[0])) {
			$sender->sendMessage(TextFormat::RED . 'Select a top using /tops (1/2/3) or /tops kill');
			return;
		}
		
		switch (strtolower($args[0])) {
			case '1':
				$nbt = Entity::createBaseNBT($sender->asVector3(), null, $sender->getYaw(), $sender->getPitch());
				$entity = new FistPosition($sender->getLevel(), $nbt);
				$entity->setImmobile(true);
				$entity->spawnToAll();
				$sender->sendMessage("§aYou placed top number 1");
				break;
			
			case '2':
				$nbt = Entity::createBaseNBT($sender->asVector3(), null, $sender->getYaw(), $sender->getPitch());
				$entity = new SecondPosition($sender->getLevel(), $nbt);
				$entity->setImmobile(true);
				$entity->spawnToAll();
				$sender->sendMessage("§aYou placed top number 2");
				break;
			
			case '3':
				$nbt = Entity::createBaseNBT($sender->asVector3(), null, $sender->getYaw(), $sender->getPitch());
				$entity = new ThirdPosition($sender->getLevel(), $nbt);
				$entity->setImmobile(true);
				$entity->spawnToAll();
				$sender->sendMessage("§aYou placed top number 3");
				break;
			
			case 'kill':
				foreach ($sender->getLevel()->getEntities() as $entity) {
					if ($entity instanceof FistPosition || $entity instanceof SecondPosition || $entity instanceof ThirdPosition)
						$entity->kill();
				}
				$sender->sendMessage("§aAll Tops removed correctly.");
				break;
		}
	}
}