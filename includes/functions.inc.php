<?php

function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

function emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat){
    if(empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat)){
        return true;
    }
    return false;
}

function emptyCardInfo($name, $desc, $price, $category){
    if(empty($name) || empty($desc) || empty($price) || empty($category)){
        return true;
    }
    return false;
}

function invalidUid($username) {
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        return true;
    }
    return false;
}

function invalidEmail($email) {
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }
    return false;
}

function pwdMatch($pwd, $pwdRepeat) {
    if($pwd !== $pwdRepeat){
        return true;
    }
    return false;
}
/*
function uidExists($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../signup.php?error=statementfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        return false;
    }
    mysqli_stmt_close($stmt);
}
*/

function uidExists($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE usersEmail = ? OR usersUid = ?";
    $stmt = $conn->prepare($sql);
    if(!$stmt) {
        header("Location: ../signup.php?error=statementfailed");
        exit();
    }
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($row = $result->fetch_assoc()){
        return $row;
    } else {
        return false;
    }
    $stmt->close();
}


/*
function createUser($conn, $name, $email, $username, $pwd) {
    $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd)
    VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../signup.php?error=statementfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: ../signup.php?error=none");
    exit();
}
*/
function createUser($conn, $name, $email, $username, $pwd) {
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd)
    VALUES (?,?,?,?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        header("Location: ../signup.php?error=statementfailed");
        exit();
    }

    $stmt->bind_param("ssss", $name, $email, $username, $hashedPwd);
    $stmt->execute();
    $stmt->close();
    header("Location: ../signup.php?error=none");
    exit();
}

function emptyInputLogin($username, $pwd) {
    if (empty(trim($username)) || empty(trim($pwd))) {
        return true;
    }
    return false;
}

function invalidLogin($username) {
    if (!(invalidEmail($username) && invalidUid($username))) {
        return true;
    }
    return false;
}

function loginUser($conn, $username, $pwd) {
    $uidExists = uidExists($conn, $username, $username);

    if($uidExists === false) {
        header("Location: ../login.php?error=wrongLogin");
        exit();
    } 
    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("Location: ../login.php?error=wrongLogin");
        exit();
    } else if ($checkPwd === true){
        session_start();
        $_SESSION["userid"] = $uidExists["usersId"];
        $_SESSION["username"] = $uidExists["usersName"];
        $_SESSION["usermail"] = $uidExists["usersEmail"];
        $_SESSION["userUid"] = $uidExists["usersUid"];
        $_SESSION["balance"] = $uidExists["coins"];
        header("Location: ../login.php?error=success");
        exit();
    }
}

function getCards($conn, $categories) {

    $result = "";
    if(empty($categories)) {
        $sql = "SELECT * FROM cards";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $categoryAmount = implode(",", array_fill(0,count($categories), "?"));
        $types = str_repeat("i", count($categories));
        $sql = "SELECT * FROM cards WHERE category_id IN ($categoryAmount)";

        $stmt = $conn->prepare($sql);

        $params = array_merge([$types], $categories);
        $refParams = [];
        $refParams[] = &$params[0]; 
        foreach ($categories as &$category) {
            $refParams[] = &$category; 
        }
        call_user_func_array([$stmt, "bind_param"], $refParams);
        $stmt->execute();
        $result = $stmt->get_result();
    }
    $stmt->close();
    return $result;
}
function checkEmptyArray($arr) {
    foreach($arr as $val) {
        if(empty($val))
            return true;
    }
    return false;
}
function cleanArray($arr) {
    foreach($arr as $text) {
        $text = trim($text);
        $text = stripslashes($text);
        $text = htmlspecialchars($text);
    }
    return $arr;
}

function addCoins($conn, $userid, $surveyId) {
    $sql = "SELECT coins FROM surveys WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $surveyId);
    $stmt->execute();
    $result = $stmt->get_result();
    $coins = 0;
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $coins = $row["coins"];
        $sql = "UPDATE users SET coins = coins+ ? WHERE usersid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $coins, $userid);
        $stmt->execute();
        $stmt->close();
    }
    return $coins;
}
function checkCardPrivilige($conn, $userid) {
    $sql = "SELECT * FROM priviliges WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i",$userid);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0 ){
        $row = $result->fetch_assoc();
        return $row["card_upload"];
    }
    $stmt->close();
    return false;
}

function checkTaskPrivilige($conn, $userid) {
    $sql = "SELECT * FROM priviliges where user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i",$userid);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        return $row["task_upload"];
    }
    $stmt->close();
    return false;
}