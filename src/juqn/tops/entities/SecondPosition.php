<?php

declare(strict_types=1);

namespace juqn\tops\entities;

use Himbeer\LibSkin\SkinConverter;
use juqn\tops\Tops;
use pocketmine\entity\Human;
use pocketmine\entity\Skin;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\utils\Config;

/**
 * Class SecondPosition
 * @package juqn\tops\entities
 */
class SecondPosition extends Human
{
	
	protected function initEntity(): void
	{
		parent::initEntity();
		$this->setNameTag("§l§6Top #2" . PHP_EOL . "§cNothing");
		$this->setNameTagAlwaysVisible(true);
		$this->setScale(0.7);
	}
	
	/**
	 * @param EntityDamageEvent $event
	 */
	public function attack(EntityDamageEvent $source): void
	{
		$source->setCancelled();
		parent::attack($source);
	}
	
	/**
	 * @param int $currentTick
	 * @return bool
	 */
	public function onUpdate(int $currentTick): bool
	{
		$result = $this->getTop($this);
		
		if ($result != null)
			$this->setNameTag("§l§6Top #2" . PHP_EOL . $result);
		return parent::onUpdate($currentTick);
	}
	
	/**
	 * @param SecondPosition $entity
	 * @return string|null
	 */
	private function getTop(SecondPosition $entity): ?string
	{
		$data = (new Config(Tops::getInstance()->getDataFolder() . 'kills.yml', Config::YAML));
		$kills = array_values($data);

		natsort($kills);
		$tops = array_reverse($kills);
		
		if ($tops[1] != null) {
			$playerName = array_search($tops[1], $data);
			$skinData = SkinConverter::imageToSkinDataFromPngPath(Tops::getInstance()->getDataFolder() . 'skins/' . $playerName . '.png');
			$entity->setSkin(new Skin('custom_skin', $skinData));
			return "§f" . $playerName . PHP_EOL . "§f" . $tops[1] . " §cKills";
		}
		return null;
	}
}