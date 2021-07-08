<?php

declare(strict_types=1);

namespace juqn\tops;

use Himbeer\LibSkin\SkinConverter;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Player;
use pocketmine\utils\Config;

/**
 * Class EventListener
 * @package juqn\tops
 */
class EventListener implements Listener
{
	
	/**
	 * @param PlayerDeathEvent $event
	 */
	public function handleDeath(PlayerDeathEvent $event): void
	{
		$config = new Config(Tops::getInstance()->getDataFolder() . 'kills.yml', Config::YAML);
		
		$player = $event->getPlayer();
		$cause = $player->getLastDamageCause();
		
		if ($cause instanceof EntityDamageByEntityEvent) {
			$damager = $cause->getDamager();
			
			if ($damager instanceof Player) {
				$config->set($player->getName(), $config->get($player->getName()) + 1);
				$config->save();
			}
		}
	}
	
	/**
	 * @param PlayerJoinEvent $event
	 */
	public function handleJoin(PlayerJoinEvent $event): void
	{
		$player = $event->getPlayer();
		SkinConverter::skinDataToImageSave($player->getSkin()->getSkinData(), Tops::getInstance()->getDataFolder() . 'skins/' . $player->getName() . '.png');
	}
}