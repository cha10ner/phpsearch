<?php    //стартуем, епт
$query = $_POST['query'];
$link = mysqli_connect("localhost", "s90297u0_xar0h", "mypass", "s90297u0_xar0h"); //серьёзно, вы думали тут будет пароль?
$sql = "SELECT name, description FROM informationsystem_items WHERE name LIKE '%$query%' OR description LIKE '%$query%' OR text LIKE '%$query%'";
$query = trim($query);
$query = mysqli_real_escape_string($link,$query);
$query = htmlspecialchars($query);
if ($link == false){
    print("<srch>"."Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error()."</srch>"); //всё пропало, шеф (если серьезно mysqli_connect_error() скажет где конкретно мы накосячили)
}
else {
    $result = mysqli_query($link, $sql); //про параметры не забываем
    }
    if ($result == false) {
        print("<srch>"."Произошла ошибка при выполнении запроса"."</srch>"); //ну, мало ли...
    }
    else
    if (!empty($query))
    {
        if (strlen($query) < 3)
        {
            print("<srch>".'Слишком короткий поисковый запрос'."</srch>");
        }
        else if (strlen($query) > 60)
        {
            print("<srch>".'Слишком длинный поисковый запрос'."</srch>");
        }
        else if (mysqli_affected_rows($link) == 0)
        {
            print("<srch>".'По вашему запросу ничего не найдено'."</srch>");
        }
        else
        {
            while ($row = mysqli_fetch_row($result)){ //пока читаем
            $sqlink0 = "SELECT structure_id FROM informationsystems WHERE id = (SELECT informationsystem_id FROM informationsystem_items WHERE name LIKE '$row[0]')";
			$qlink0 = mysqli_query($link, $sqlink0);
			$row0 = mysqli_fetch_row($qlink0);
			$sqlink1 = "SELECT path FROM informationsystem_groups WHERE id = (SELECT informationsystem_group_id FROM informationsystem_items WHERE name LIKE '$row[0]')";
			$qlink1 = mysqli_query($link, $sqlink1);
			$row1 = mysqli_fetch_row($qlink1);
			$sqlink2 = "SELECT id FROM informationsystem_items WHERE name LIKE '$row[0]'";
			$qlink2 = mysqli_query($link, $sqlink2);
			$row2 = mysqli_fetch_row($qlink2);
			if ($row0[0] == 9)
			{
			    print("<srch>"."<a href=../$row1[0]/$row2[0]>"."<u>".$row[0]."</u>"."</a>".$row[1]."<br />"."</srch>");
			}
			else
            print("<srch>"."<a href=../$row0[0]/$row1[0]/$row2[0]>"."<u>".$row[0]."</u>"."</a>".$row[1]."<br />"."</srch>"); //выводим строки через print
        }
        }
    }
    else
    {
        print("<srch>".'Задан пустой поисковый запрос'."</srch>");
    }
?>
