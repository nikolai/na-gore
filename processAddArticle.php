<?php
	$head    = $_POST['txthead'];
	$author  = $_POST['txtauthor'];
	$date    = $_POST['txtdate'];
	$message = $_POST['txtmessage'];
	$subject = $_POST['txtsubject'];

	$dirpath  = "articles/2009/";
	$filename = "test.php"; 
	
	$datearray = explode(".", $date);
	
	if( is_dir($dirpath) )
	{
		if( $dir = opendir($dirpath) )
		{
			if( @mkdir($dirpath.$datearray[1]) )
			{
				if( @mkdir($dirpath.$datearray[1] ."/". $datearray[0]) )
					$dirpath = $dirpath.$datearray[1] ."/". $datearray[0];
				else
					$dirpath = $dirpath.$datearray[1] ."/". $datearray[0];
			}
			else
			{
				if( @mkdir($dirpath.$datearray[1] ."/". $datearray[0]) )
					$dirpath = $dirpath.$datearray[1] ."/". $datearray[0];
				else
					$dirpath = $dirpath.$datearray[1] ."/". $datearray[0];
			}
		}
		else
		{
			$dirpath = @mkdir( $dirpath.$datearray[1]."/".$datearray[0] );
		}
	}

	$content = '
		<?php
			$page_title 	= '. $head .';
			$author 		= '. $author .';
			$public_date 	= '. $date .';
			$theme 			= '. $subject .';
		?>
		<p>'.$message.'</p>;
	';
	
	if( !($fp = fopen($dirpath."/".$filename, "w")) )
	{
		echo "Не удалось открыть файл $filename для записи.";
				
		exit;
	}
			
	if( fwrite($fp, $content) == false )
	{
		echo "Не удалось осуществить запись в файл $filename.";
			
		exit;
	}
			
	fclose($fp);
	
	@header("Location: addArticle.php?path=$dirpath");	
?>