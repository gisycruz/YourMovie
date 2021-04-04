<?php
namespace Controllers;

use DAO\UserDao as UserDao;
use Models\User as User;
use DAO\UserBdDAO as UserBdDAO;
use Controllers\MovieController as MovieController;
use Controllers\ShoppingController as ShoppingController;
use Controllers\Functions;
use PDOException;

    class SessionController {
       
        private $userDAO ;

        public function __construct()
        {
           $this->userDAO = new UserBdDAO();
          
        }

        //SignUp function

        public function ShowSignUpView($message = "")
        {
            if(!isset($_SESSION["loginUser"])){
             
            require_once(VIEWS_PATH."signup.php");

            }
            else {

            $id_movie = $message;
           
            require_once(VIEWS_PATH."movie-list.php");
            }
        } 
        public function ShowLogInView($message = "")
        {

            require_once(VIEWS_PATH."login.php");
            
            /*else {
            $id_movie = $message;
            $message = "";
            require_once(VIEWS_PATH."movie-list.php");
            }*/
        }       
       public function ShowViewsProfileUser($id_user, $message =""){
             
        require_once(VIEWS_PATH."validate-sessionUser.php");

        $user = UserBdDAO::MapearUser($id_user);

        require_once(VIEWS_PATH."profile-user.php");

       }

        public function ShowAddCinema($message = "") 
        {

            require_once(VIEWS_PATH."validate-session.php");

            require_once(VIEWS_PATH."cinema-add.php");
        }

        public function ShowModifyUserViews($id_user , $message =""){

            require_once(VIEWS_PATH."validate-sessionUser.php");

            $user = UserBdDAO::MapearUser($id_user);

            require_once(VIEWS_PATH."modify_user.php");

        }
        
    
       public function CheckLogin($username, $password,$id_screening ="")
    {

        $user = $this->userDAO->GetByUserName($username);

        if($user != null)
        {
                
            if($user->getPassword() === $password)
            {

                     if($user->getRole() == 1){

                     $_SESSION["loginAdmid"] = $user;

                     $message = "Welcome admind Cinemas";

                     $this->ShowAddCinema($message);

                }else{
                    if(isset($id_screening)){

                     $this->LogInValidateUser($username,  $password,$id_screening);

                    }else{

                        $this->LogInValidateUser($username,  $password,$id_screening ="");
                    }
                     }

            }else{

                $this->ShowLogInView("incorrect Password ");

              }

        }else{
                $this->ShowLogInView("incorrect email ");

             }
    }

        public function LogInValidateUser($email,  $password,$id_screening)
     {

            $user = $this->userDAO->GetByUserName($email);
        
        if($user != null ){
    
                if($user->getPassword() == $password) {
    
    
                    $_SESSION["loginUser"] = $user;

                    if(isset($id_screening) && !empty($id_screening)){

                        $Shopping = new ShoppingController();

                        $Shopping->GetShopping($id_screening);

                    }else{

                    $movieController = new MovieController();
    
                    $movieController->listMovies("Welcome!");

                    }

                } else {

                $this->ShowLogInView("ERROR: Password incorrect!");
                
                }

        } else {
                $this->ShowLogInView("ERROR: The entered email is not registered , REGISTERED!!"); 

              }
    }

     public function SignUpValidate($email, $password, $password2,$firstName,$lastName,$dni,$birthDate) 
     {

        if($password==$password2){
        
             if($this->userDAO->GetByUserName($email)) {

               $this->ShowSignUpView("That mail is already in use.");
        
             }else {

                $newUser = new User($email, $password,2,$firstName,$lastName,$dni,$birthDate);

                $result = $this->userDAO->SaveUserInDB($newUser);

               if($result == 1) {

                     $this->ShowLogInView("Sign Up succesfully! Now you can log in.");

                  }else {

                     $this->ShowLogInView("Error in Sign Up, please try again.");
                 }
            }

        }else {

        $this->ShowSignUpView("Password's must be equal");

         }
    }

     public Function modifyUser($email, $password,$firstName,$lastName,$dni,$birthDate,$id_user){

        require_once(VIEWS_PATH."validate-sessionUser.php");

        try{
                   
            $result = $this->userDAO->ModifyUserInBd($id_user,$email, $password,$firstName,$lastName,$dni,$birthDate);

            if($result == 1){

            $this->ShowViewsProfileUser($id_user," User modified successfully !!");

            }
             else
            {
                $message = "ERROR: Failed , reintente";

               $this->ShowModifyUserViews($id_user, $message);
                
            }

              }catch(PDOException $ex){

                   $message = $ex->getMessage();

                   if(Functions::contains_substr($message, "Duplicate entry")) {

                       $message = "User already exists, must use different user!!!";

                       $this->ShowModifyUserViews($id_user, $message);

                    } 
                }

        } 
    


        //LogOutFunction

        public function SessionDestroy(){
            
              session_destroy();

              header("location:../index.php");  

         }

        
}
        
?>