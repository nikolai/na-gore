<?php
	require_once('futures.php');

	$datearray = getDates();
?>
<html>
	<head>
		<title>Форма добавления статей</title>
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	</head>
	<body>
		<form name="addarticle" method="post" action="processAddArticle.php">
			<table width="50%" border="0">
				<tr>
					<td>
						<table border="0" style="background:#96E066;" width="100%">
							<tr>
								<td><label for="idhead">Заголовок</label></td>
								<td><input type="text" name="txthead" id="idhead" size="30" /></td>
								<td><div id="errorhead" /></td>
							</tr>
							<tr>
								<td><label for="idauthor">Автор</label></td>
								<td><input type="text" name="txtauthor" id="idauthor" size="30" /></td>
								<td><div id="errorauthor" /></td>
							</tr>
							<tr>
								<td><label for="iddate">Дата публикации</label></td>
								<td><input type="text" name="txtdate" id="iddate" size="30" value="<?php echo $datearray[2].'.'.$datearray[1].'.'.$datearray[0];?>" /></td>
								<td><div id="errordate" /></td>
							</tr>
							<tr>
								<td><label for="idmessage">Сообщение</label></td>
								<td><textarea name="txtmessage" id="idmessage"></textarea></td>
								<td><div id="errormessage" /></td>
							</tr>
							<tr>
								<td><label for="idsubject">Тема</label></td>
								<td><input type="text" name="txtsubject" id="idsubject" size="30" /></td>
								<td><div id="errorsubject" /></td>
							</tr>				
							<tr>
								<td><label for="addfirst">Добавить на первую страницу</label></td>
								<td><input type="checkbox" id="addfirst" checked="true" /></td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td colspan="2"><input type="submit" name="btnAdd" id="idadd" value="Добавить" /></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="color:#004FAF;">
						<div id="info">
							<?php
								$info = $_GET['path'];
							
								echo "Файл создан в директории: ". $info;
							?>
						</div>
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>