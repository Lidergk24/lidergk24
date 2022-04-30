<?
function getex($filename) {
return end(explode(".", $filename));
}
if($_FILES['upload'])
//var_dump($_FILES);
{
if (($_FILES['upload'] == "none") OR (empty($_FILES['upload']['name'])) )
{
$message = "Вы не выбрали файл";
}
else if ($_FILES['upload']["size"] == 0 OR $_FILES['upload']["size"] > 3050000)
{
$message = "Размер файла не соответствует нормам";
}
else if (($_FILES['upload']["type"] != "image/jpeg") AND ($_FILES['upload']["type"] != "image/jpeg") AND ($_FILES['upload']["type"] != "image/png") AND ($_FILES['upload']["type"] != "application/pdf"))
{
$message = "Допускается загрузка только картинок JPG и PNG и PDF.";
}
else if (!is_uploaded_file($_FILES['upload']["tmp_name"]))
{
$message = "Что-то пошло не так. Попытайтесь загрузить файл ещё раз.";
}
else{
$name =rand(1, 1000).'-'.md5($_FILES['upload']['name']).'.'.getex($_FILES['upload']['name']);
move_uploaded_file($_FILES['upload']['tmp_name'], "images/".$name);
$environment = include_once($_SERVER['DOCUMENT_ROOT'] . '/config/environment.php');
$full_path = $environment["base_url"].'/template/js/ckeditor/images/'.$name;
$message = "Файл ".$_FILES['upload']['name']." загружен";

//$size=@getimagesize('images/'.$name);
//if($size[0]<50 OR $size[1]<50){
//unlink('images/'.$name);
//$message = "Файл не является допустимым изображением";
//$full_path="";
//}
}
$callback = $_REQUEST['CKEditorFuncNum'];
echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("'.$callback.'", "'.$full_path.'", "'.$message.'" );</script>';
}
?>