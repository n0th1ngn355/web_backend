<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();

if (!empty($_SESSION['uid'])) {
    session_destroy();
    setcookie('name',NULL,1);
    setcookie('email',NULL,1);
    setcookie('yob',NULL,1);
    setcookie('sex',NULL,1);
    setcookie('num_of_limbs',NULL,1);
    setcookie('biography',NULL,1);
    setcookie('superpowers',NULL,1);
    setcookie('policyCheckBox',NULL,1);
}
else{
  //header('Location: ./');
   
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_COOKIE['er_msg'])){
        $er_msg = $_COOKIE['er_msg'];
        setcookie('er_msg',NULL,1);
    }
    if (isset($_COOKIE['login'])){
        $login = $_COOKIE['login'];
        setcookie('login',NULL,1);
    }
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>5 задание</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.1.slim.min.js"
integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="/styles/labsStyle.css">
<a style='font-size:30px; text-decoration:none;' href='./'>На главную</a>

<form method="post" autocomplete="off" id="form" novalidate class="m-auto row g-4">
    <div class="col-12 m-auto">
        <label for="formLogin" class="form-label">Логин</label>
        <input name="login" id="formLogin" class="form-control<?php if(!empty($er_msg)) { print ' is-invalid';}?>" placeholder="Введите логин" value="<?php print $login; ?>">
    </div>
    <div class="col-12 m-auto">
        <label for="formPassword" class="form-label">Пароль</label>
        <input name="password" type="password" id="formPassword" class="form-control <?php if(!empty($er_msg)) { print ' is-invalid';}?>" placeholder="Введите пароль">
        <?php
            if(!empty($er_msg)){
                print('<div class="invalid-feedback">'.$er_msg.'</div>');
            } 
        ?>
        </div>
    <div class="col-12 d-flex">          
        <input type="submit" id="submitBtn" class="btn btn-success m-auto" value="Войти">
    </div>
</form>

<?php
}
else {
    if(empty($_POST['login']) || empty($_POST['password'])){
        setcookie('er_msg','Введите логин и пароль');
        header('Refresh: 0');
    }else{
        try{
            $user = 'u53011';
            $pass = '1234';
            $db = new PDO('mysql:host=localhost;dbname=u53011;', $user, $pass,
                  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            
            // $user = 'postgres';
            // $pass = 'root';
            // $dsn = "pgsql:host=127.0.0.1;port=5432;dbname=u53011;";
            // $db = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        
            $stmt = $db->prepare("select application_id, login, password from application where login=:login");
            $stmt->execute(['login'=>$_POST['login']]);
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $t = $stmt->fetchAll();
            if(empty($t)){
                setcookie('er_msg','Неверные учетные данные');
                header('Refresh: 0');
            }else{
                setcookie('login',$_POST['login']);
                if(password_verify($_POST['password'],$t[0]['password'])){
                    $_SESSION['uid'] = $t[0]['application_id'];
                    setcookie('login',NULL,1);
                    header('Location: ./');
                }else{
                    setcookie('er_msg','Неверные учетные данные');
                    header('Refresh: 0');
                }
            }
        } catch(PDOException $e){
            die($e->getMessage());
        }
    }

  //$_SESSION['uid'] = 123;

  //header('Location: ./');
}
