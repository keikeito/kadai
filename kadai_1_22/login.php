<?php

    $salt = "mwefCMEP28DjwdW3lwdS239vVS";
    
    //セッション開始
    session_start();

    $pdo = new PDO('mysql:dbname=gskadai_1_16;host=localhost','root','');

    //$status = "none";

    $password = md5($_POST["password"] . $salt);
    $email = $_POST["email"];

    //セッションにセットされていたらログイン済み
    if(isset($_SESSION["username"]))
    $status = "logged_in";
    else if(!empty($_POST["email"]) && !empty($_POST["password"])){
        //ユーザ名、パスワードが一致する行を探す

        $stmt = $pdo->prepare("SELECT * FROM gskadai_1_16_table WHERE email=:email AND password=:password ");
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);
        $status = $stmt->execute();

        //結果を保存
        //$stmt->store_result();
        
        //結果の行数が1だったら成功
//        if($stmt->num_rows == 1){
//            $status = "ok";
//            //セッションにユーザ名を保存
//            $_SESSION["username"] = $_POST["username"];
//        }else
//            $status = "failed";
        
        $name="";
        //$email="";
        $age="";
        if($status==false){
            //execute（SQL実行時にエラーがある場合）
            $error = $stmt->errorInfo();
            exit("ErrorQuery:".$error[2]);
        }else{
            while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
            $name = $result["name"];
            //$email = $result["email"];
            //$password= $result["password"];
            $age= $result["age"];
                
            //$_SESSION["name"] = $_POST["name"];
            $_SESSION["name"] = $name;
            header("Location: index.php");
            exit;
            }
        }
    }

?>