<?php
namespace Controllers;

use Models\User as User;
use DAO\UserBdDAO as UserBdDAO;
use Controllers\MovieController as MovieController;
use Controllers\ShoppingController as ShoppingController;
use Controllers\Functions;
use PDOException;

    class SessionController {
       
        private $userDAO ;
        private $movieController;
        private $Shopping;

        public function __construct()
        {
           $this->userDAO = new UserBdDAO();
           $this->movieController = new MovieController();
           $this->Shopping = new ShoppingController();
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


                     $this->movieController->listMovies("Welcome admind");

                }else{
                    if(isset($id_screening)){

                     $this->LogInValidateUser($username,$password,$id_screening);

                    }else{

                        $this->LogInValidateUser($username,$password,$id_screening ="");
                    }
                     }

            }else{

                $this->ShowLogInView("incorrect Password ");

              }

        }else{
                $this->ShowLogInView("incorrect email ");

             }
    }

        public function LogInValidateUser($email,$password,$id_screening)
     {

            $user = $this->userDAO->GetByUserName($email);
        
        if($user != null ){
    
                if($user->getPassword() == $password) {
    
    
                    $_SESSION["loginUser"] = $user;

                    if(isset($id_screening) && !empty($id_screening)){

                        

                        $this->Shopping->GetShopping($id_screening);

                    }else{

                   
    
                    $this->movieController->listMovies("Welcome!");

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

               $this->ShowModifyUserViews($id_user,"ERROR: Failed , reintente");
                
            }

              }catch(PDOException $ex){

                   if(Functions::contains_substr($ex->getMessage(), "Duplicate entry")) {

                       $this->ShowModifyUserViews($id_user,"User already exists, must use different user!!!");

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