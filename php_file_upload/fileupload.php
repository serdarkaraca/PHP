<?PHP

if(isset($_FILES['dosya']))
{
	echo "Dosya Geldi İşleme Başlanıyor... <br>";
	
	$Error = $_FILES['dosya']['error'];
	if($Error != 0)
	{
		echo "Dosyada Bir Hata Mevcut. <br>";
	}
	else
	{
		$file_size = $_FILES['dosya']['size'];
		if($file_size > (1024*1024*5)) // Max Dosya Boyutunu 5 Mb Olarak Belirledik.
		{
			echo "Dosya boyutu 5 MB'den büyük olamaz. <br>";
		}
		else
		{
			$file_type = $_FILES['dosya']['type']; // dosya tipini aldık.
			$file_name = $_FILES['dosya']['name']; // dosya adını aldık.
			$file_extension = explode('.', $file_name); 
			// dosya uzantısını aldık. dosya adında ki '.' (nokta) ve sonrasını.
			$file_extension = $file_extension[count($file_extension)-1]; 
			// dosya uzantısından '.' (noktayı) kaldırdık.
			$target_folder = 'dosyalar/';
			
			if($file_extension != 'jpg')
			/*
			Yüklenebilecek dosya tiplerini buradan belirtebiliriz. Biz şimdilik
			sadece .jpg olanların yüklenmesini yazdık.
			*/
			{
				echo "Sadece .jpg uzantılı dosyaları yükleyebilirsiniz. <br>";
			}
			else
			{
				$temp_file = $_FILES['dosya']['tmp_name'];
				move_uploaded_file($temp_file, $target_folder . $file_name);
				//Sunucu üzerinde ki temp dosyayı dosyalar klasörüne taşıdık.
				
				echo "Dosyanız <b>" .$target_folder. "</b> Klasörüne  <b>" . $file_name. " </b> Adıyla Yüklendi.";
			}
		}
	}
}
else
{
	echo "Dosya Gelmedi";
}