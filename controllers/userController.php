<?php
// require_once "../includes/functions.inc.php";
class UserController {
    private $UserRepository;

    public function __construct(UserRepository $UserRepository){
        $this->UserRepository = $UserRepository;
    }

    public function CreateUser() {
        $name = clean_input($_POST["name"]);
        $email = clean_input($_POST["email"]);
        $username = clean_input($_POST["uid"]);
        $pwd = clean_input($_POST["pwd"]);
        $pwdRepeat = clean_input($_POST["pwdrepeat"]);
        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        if (emptyInputSignup($name , $email, $username, $pwd, $pwdRepeat) !== false) {
            echo "ცარიელი ველი არ შეიძლება";
            return;
        }
        if (invalidUid($username) !== false) {
            echo "მიუთითე ვალიდური სიმბოლოები!";
            return;
        }
        if (invalidEmail($email) !== false ) {
            echo "არასწორი მეილის ფორმატი";
            return;
        }
        if (pwdMatch($pwd, $pwdRepeat) !== false) {
            echo "პაროლები უნდა ემთხვეოდეს ერთმანეთს";
            return;
        }
        if($this->UserRepository->UserExists($username, $email)){
            echo "მომხმარებელი უკვე რეგისტრირებულია";
            return;
        }
        $user = new User($name,$email, $username, $hashedPwd, 0);
        $this->UserRepository->save($user);
        return true;
    }
    public function LoginUser() {
        $username = $_POST["name"];
        $pwd = $_POST["pwd"];
        $user = $this->UserRepository->UserExists($username, $username);
        if(!$user){
            return "არ არსებობს მომხმარებელი";
        }
        if(password_verify($pwd, $user["usersPwd"])){
            $logged_user = new User(
                $user["usersName"],
                $user["usersEmail"],
                $user["usersUid"],
                $user["usersPwd"],
                $user["coins"]
            );
            $_SESSION["userid"] = $user["usersId"];
            $_SESSION["username"] = $user["usersName"];
            $_SESSION["usermail"] = $user["usersEmail"];
            $_SESSION["userUid"] = $user["usersUid"];
            $_SESSION["balance"] = $user["coins"];
            $_SESSION["user"] = serialize($logged_user);
            $_SESSION["cart"] = checkCart($this->UserRepository->getDB(), $user["usersId"]);
            return "თქვენ წარმატებით გაიარეთ ავტორიზაცია";
        } else {
            return "პაროლი ან იმეილი არასწორია";
        }
        
    }
}