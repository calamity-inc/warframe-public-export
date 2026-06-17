<?php
foreach (scandir(".") as $file)
{
	if (substr($file, -4) == ".txt")
	{
		echo "> Processing $file\n";
		foreach (explode("\n", file_get_contents($file)) as $line)
		{
			$line = str_replace("\r", "", $line);
			if (!$line)
			{
				continue;
			}
			$name = explode("!", $line)[0];
			if (substr($name, 0, 13) == "ExportRecipes")
			{
				$name = "ExportRecipes.json";
			}
			if (($name != "ExportManifest.json" && $name != "ExportRecipes.json") || $file == "index_en.txt")
			{
				echo "Downloading $name...\n";
				$data = file_get_contents("https://content.warframe.com/PublicExport/Manifest/".$line);
				$data = str_replace("\0", "", $data); // Fix for ExportUpgrades_uk.json in 41.1.0
				$data = json_encode(json_decode($data, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
				file_put_contents($name, $data);
			}
		}
	}
}
