<?php
require_once ('conf.php');
global $yhendus;
// punktid nulliks UPDATE
if(isset($_REQUEST['punkt'])){
    $kask=$yhendus->prepare("
UPDATE konkurss SET punktid=0 WHERE id=?");
    $kask->bind_param("i", $_REQUEST['punkt']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
if(isset($_REQUEST['komment'])){
    $kask=$yhendus->prepare("
UPDATE konkurss SET kommentaar='' WHERE id=?");
    $kask->bind_param("i", $_REQUEST['komment']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}

//nimi lisamine konkurssi
if(!empty($_REQUEST['nimi'])){
    $kask=$yhendus->prepare("
INSERT INTO konkurss(nimi, pilt, lisamisaeg)
VALUES (?, ?, NOW())");
    $kask->bind_param("ss", $_REQUEST['nimi'], $_REQUEST['pilt']);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
// nimi näitamine avalik=1 UPDATE
if(isset($_REQUEST['avamine'])){
    $kask=$yhendus->prepare("
UPDATE konkurss SET avalik=1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST['avamine']);
    $kask->execute();
}
// nimi peitmine avalik=0 UPDATE
if(isset($_REQUEST['peitmine'])){
    $kask=$yhendus->prepare("
UPDATE konkurss SET avalik=0 WHERE id=?");
    $kask->bind_param("i", $_REQUEST['peitmine']);
    $kask->execute();
}
// kustutamine
if(isset($_REQUEST['kustuta'])){
    $kask=$yhendus->prepare("
DELETE FROM konkurss WHERE id=?");
    $kask->bind_param("i", $_REQUEST['kustuta']);
    $kask->execute();
}



?>
<!Doctype html>
<html lang="et">
<head>
    <title>Lisamine Pilt </title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<nav>
    <a href="haldus.php">Administreerimise leht</a>
    <a href="konkurss.php">Kasutaja leht</a>
    <a href="https://github.com/Georg-Gluhhov/Konkurs">      github</a>
    <a href="lisamine.php">lisamine</a>
</nav>
<h1>Lisamine Pilt</h1>
<?php
// tabeli konkurss sisu näitamine
$kask=$yhendus->prepare("
SELECT id, nimi, pilt, lisamisaeg, punktid, avalik, kommentaar FROM konkurss");
$kask->bind_result($id, $nimi, $pilt, $aeg, $punktid, $avalik, $kommentaar);
$kask->execute();


while($kask->fetch()){





    echo "</tr>";
}
echo "<table>";
?>
<h2>Uue pilti lisamine konkurssi</h2>
<form action="?">
    <input type="text" name="nimi" placeholder="Uus nimi">
    <br>
    <textarea name="pilt">Pildi linki aadress</textarea>
    <br>
    <input type="submit" value="Lisa">
</form>

</body>
</html>


