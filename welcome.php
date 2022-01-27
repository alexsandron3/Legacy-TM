<?php
    //VERIFICACAO DE SESSOES E INCLUDES NECESSARIOS E CONEXAO AO BANCO DE DADOS
    include_once("./includes/header.php");
    ?>
 
<!DOCTYPE html>
<html lang="en">
<head>
<?php include_once("./includes/mdbcss.php"); ?>

    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="mt-5">
        <h1>OLÁ, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h1>
        <hr>
    </div>
    <p>
        <a href="index.php" class="btn bg-info text-white">PÁGINA INICIAL</a>
        <a href="logout.php" class="btn bg-warning text-white">DESLOGAR</a>
        <a href="reset-password.php" class="btn bg-danger text-white">TROCAR DE SENHA</a>
        <!-- <a href="downloads/Fabio Passeios.exe" class="btn bg-dark text-white">BAIXAR APLICATIVO DESKTOP</a> -->
    </p>
</body>
</html>