<!DOCTYPE html>
<html>
<head>
    <title>Connect</title>


    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <link href="gestaltung/hintergrund.css" rel="stylesheet" />
    <link href="gestaltung/profil.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<?php
include('./klassen/DB.php');
include('./klassen/anmeldung_klasse.php');

$nutzername1 = anmeldung_klasse::isLoggedIn();
$nutzername1 = DB::query('SELECT nutzername FROM nutzer WHERE id=:nutzername', array(':nutzername'=>$nutzername1));
foreach ($nutzername1 as $nutzername2) {
    $nutzername=$nutzername2['nutzername'];
}
?>
<div class="container">

    <!-- Static navbar -->
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">

                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Connect</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="profil.php?nutzername=<?php echo $nutzername; ?>">Mein Profil</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="abmeldung.php">Abmelden</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    &nbsp;&nbsp;<li class="active"><a href="#">Suchen</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
    </nav>

    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">



        <form action="suche.php" method="post">


            <input type="text" name="suchfeld" value="">&nbsp;&nbsp;


            <input type="submit" name="suche" value="Nutzer suchen">


        </form>
        <?php




        if (isset($_POST['suche'])) {
            $nutzer = DB::query('SELECT nutzer.nutzername FROM nutzer WHERE nutzer.nutzername LIKE :nutzername', array(':nutzername'=>'%'.$_POST['suchfeld'].'%'));
            foreach ($nutzer as $f){
                echo "<ul><h4><a href='profil.php?nutzername=".$f['nutzername']."'>".$f["nutzername"]."</a><br></h4></ul>";
            }
        }

        ?>

    </div> <!-- /container -->