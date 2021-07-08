<?php

declare(strict_types=1);

namespace juqn\tops\entities;

use Himbeer\LibSkin\SkinConverter;
use juqn\tops\Tops;
use pocketmine\entity\Human;
use pocketmine\entity\Skin;
use pocketmine\utils\Config;

/**
 * Class ThirdPosition
 * @package juqn\tops\entities
 */
class ThirdPosition extends Human
{
	
	protected function initEntity(): void
	{
		parent::initEntity();
		$this->setNameTag("§l§6Top #3" . PHP_EOL . "§cNothing");
		$this->setNameTagAlwaysVisible(true);
		$this->setScale(0.7);
	}
	
	/**
	 * @param int $currentTick
	 * @return bool
	 */
	public function onUpdate(int $currentTick): bool
	{
		$result = $this->getTop($this);
		
		if ($result != null)
			$this->setNameTag("§l§6Top #3" . PHP_EOL . $result);
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
		
		if ($tops[2] != null) {
			$playerName = array_search($tops[2], $data);
			$skinData = SkinConverter::imageToSkinDataFromPngPath(Tops::getInstance()->getDataFolder() . 'skins/' . $playerName . '.png');
			$entity->setSkin(new Skin('custom_skin', $skinData));
			return "§f" . $playerName . PHP_EOL . "§f" . $tops[2] . " §cKills";
		}
		return null;
	}
}