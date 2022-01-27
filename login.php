<?php
// use Dotenv\Dotenv;

require  __DIR__ . '/vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/includes/');
$dotenv->load();

// Include config file
require_once "includes/pdoCONEXAO.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "INSIRA O USUÁRIO.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "INSIRA A SENHA.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, nivelAcesso, password FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $nivelAcesso, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            if (!isset($_SESSION)) {
                                session_start();
                            }
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["nivelAcesso"] = $nivelAcesso;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "SENHA INCORRETA";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = "NENHUMA CONTA COM ESSE NOME DE USUÁRIO";
                }
            } else {
                echo "OCORREU ALGUM ERRO, ENTRE EM CONTATO COM O ADMINISTRADOR DO SISTEMA";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("./includes/novoInclude.php"); ?>
    <link rel="stylesheet" href="config/style1.css">
    <link rel="stylesheet" href="config/bootstrap_login.css">

    <style type="text/css">
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>
<!-- <body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>INSIRA SUAS CREDENCIAS DE LOGIN.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Usuário</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Senha</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn bg-secondary text-white" value="Login">
            </div>
        </form>
    </div>    
</body> -->

<body class="d-flex h-100 text-center text-dark">

    <main class="form-signin">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="on">
            <img class="mb-4" src="img/logo.jpg" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Logar-se</h1>

            <div class="form-floating mb-2 <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>

                <input type="text" name="username" class="form-control" id="floatingInput" placeholder="Nome de usuário" value="<?php echo $username; ?>">

            </div>
            <div class="form-floating <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Senha">
                <span class="help-block"><?php echo $password_err; ?></span>

            </div>
            <input type="submit" class="btn bg-secondary text-white" value="Login">
            <p class="mt-5 mb-3 text-muted">&copy; 2021–2021</p>
        </form>
    </main>



</body>

</html>