<?php
foreach (scandir(".") as $file)
{
	if (substr($file, -4) == ".txt")
	{
		echo "> Processing $file\n";
		foreach (explode("\n", file_get_contents($file)) as $line)
		{
			$line = str_replace("\r", "", $line);
			$name = explode("!", $line)[0];
			if (!file_exists($name))
			{
				echo "Downloading $name...\n";
				$data = file_get_contents("https://content.warframe.com/PublicExport/Manifest/".$line);
				$data = str_replace("\\r\r\n", "\\n", $data);
				$data = json_encode(json_decode($data, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
				file_put_contents($name, $data);
			}
		}
	}
}
