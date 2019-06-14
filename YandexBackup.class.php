<?
/**
 * @author Nikola Nemirovskiy
 * Сервис сохранения и управления резервными копиями на яндекс диске
 */
class YandexBackup
{
	private $pathBase = __DIR__	;
	private $configFile = ".config.php";
	private $prefix = __CLASS__;
	private $config = null;

	/**
	*	метод получения конфигурации
	*	если нет файла вернет false
	*/
	private function getConfig(){
		if($this->config === null)
		{
			$this->config = include($this->pathBase.DIRECTORY_SEPARATOR.$this->configFile);
		}
		return $this->config;
	}

	/**
	*	Метод сохранения конфигурации в файл
	*/
	private function configSave(){
		$path = $this->pathBase.DIRECTORY_SEPARATOR.$this->configFile;
		$result = "<? return array(\n";
		foreach ($this->config as $key => $value) {
			$result .= "	'$key' => '$value',\n";
		}
		$result .= ");";
		file_put_contents($path, $result);
	}

	private function installStep1(){
		$result  = '<form method="POST">';
		$result .= '<p>Начальная настройка</p>';
		$result .= '<p>Шаг 1 - Регистрация приложения</p>';
		$result .= '<input type="text" placeholder="Application ID" name="';
		$result .= $this->prefix;
		$result .= '[APP_ID]"><br>';
		$result .= '<input type="text" placeholder="Application Password" name="';
		$result .= $this->prefix;
		$result .= '[APP_PASS]"><br>';
		$result .= '<input type="submit" value="Далее">';
		$result .= '</form>';
		return $result;
	}

	private function installStep2(){
		$result  = '<form method="POST">';
		$result .= '<p>Начальная настройка</p>';
		$result .= '<p>Шаг 2 - Получение токена</p>';
		$result .= '<input type="text" placeholder="Код подтверждения" name="';
		$result .= $this->prefix;
		$result .= '[CODE]"><br>';
		$result .= '<a target="_blank" ';
		$result .= 'href="https://oauth.yandex.ru/authorize?response_type=code&client_id=';
		$result .= $this->config["ID"];
		$result .= '">Получить токен</a><br>';
		$result .= '<input type="submit" value="Далее">';
		$result .= '</form>';
		return $result;
	}
}
