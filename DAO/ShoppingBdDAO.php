<?php
namespace DAO;

use Models\Shopping as Shopping;
use DAO\IShopping as IShopping;
use DAO\Connection as Connection;
use DAO\UserBdDAO as UserBdDAO;
use DAO\ScreeningBdDAO as ScreeningBdDAO;
use FFI\Exception;

class ShoppingBdDAO implements IShopping{

    private $tableName = "shopping";
    private $connection;
    private $shoppingList = [];
    private static $instance;
    
    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
   public function addShopping(Shopping $shopping){

      $query = "INSERT INTO ".$this->tableName ."(iduser,idscreening , dateShopping,countrticket,priceRoom ,total) VALUE (:iduser,:idscreening, :dateShopping,:countrticket,:priceRoom,:total)";
       
      $parameters['iduser'] = $shopping->getUser()->getUserId();
      $parameters['idscreening'] =$shopping->getScreening()->getId_screening();
      $parameters['dateShopping'] =$shopping->getDateShopping();
      $parameters['countrticket'] =$shopping->getCountrtiket();
      $parameters['priceRoom'] = $shopping->getPriceRoom();
      $parameters['total'] =$shopping->getTotal();
      
      try{

         $this->connection = Connection::GetInstance();

         return $this->connection->ExecuteNonQuery($query,$parameters);

      }catch (Exception $ex){
     
        throw $ex;
    
      }

   }

   private function getAllShoppingfromDb(){

    $query = "SELECT * FROM ". $this->tableName ;

    try {

        $this->connection = Connection::GetInstance();

        $result = $this->connection->Execute($query);
       
    } catch (Exception $ex) {
        throw $ex;
    }

    return $result;

   }

   public function getAllShopping(){

     $shoppingArray = $this->getAllShopping();

     if(!empty($shoppingArray)){
            
        $result = $this->mapear($shoppingArray);
     
     if(is_array($result)){

        $this->shoppingList = $result;
     }
     else{

        $arrayResult[0] =$result;
        $this->shoppingList = $arrayResult;
     }
     return $this->shoppingList ;

   }else{

    return $errorArray[0] = "ERROR while reading the database.";
   }
}


   public function deleteShopping($id_shopping){

        $query = "call deleteShopping(?)";

        $parameters['id_shopping'] =$id_shopping;

        try{
            
            $this->connection = Connection::GetInstance();

           $result = $this->connection->Excecute($query,$parameters,QueryType::storedProcedure);

        }catch(Exception $ex){

            throw $ex;
        }

        return $result;
    }

    protected function mapear($value){

        $value = is_array($value) ? $value :[];

        $resp = array_map(function($p){

            $shopping = new Shopping();
         
            $shopping->setId_Shopping($p['id_shopping']);
            $shopping->setUser(UserBdDAO::MapearUser($p['iduser']));
            $shopping->setScreening(ScreeningBdDAO::MapearScreening($p['idscreening']));
            $shopping->setDateShopping($p['dateShopping']);
            $shopping->setCountrtiket($p['countrticket']);
            $shopping->setPriceRoom($p['priceRoom']);
            $shopping->setTotal($p['total']);

            return $shopping;
            
        },$value);

        return count($resp) > 1 ? $resp : $resp['0'];
    }
   

    public function GetShoppingById($searchidShopping)
        {
            $shopping = null;
    
            $query = "SELECT * FROM " . $this->tableName . " WHERE (id_shopping =:idshopping )";
           
            $parameters["idshopping"] = $searchidShopping;
    
            try{
    
                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, $parameters);
                 

            } catch (Exception $ex) {
                throw $ex;
            }
            
            $shopping  = $this->mapear($results);

            return $shopping ;
    
        }
        
        public static function MapearShopping($idShoppingToMapear) {

            $shoppingDAOBdAux = new ShoppingBdDAO();

            return $shoppingDAOBdAux->GetShoppingById($idShoppingToMapear);
        } 




        
        public function GetIdShoppingById($id_user, $date){

            $query = "SELECT id_shopping from ". $this->tableName." where( iduser =:iduser && dateshopping = :dateshopping )";
           
            $parameters["iduser"] = $id_user;
            $parameters['dateshopping'] =$date;
           
            try{
    
                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, $parameters);
                 
               
            } catch (Exception $ex) {
                throw $ex;
            }


            $id_shopping = 0;

            foreach($results as $res){
               
                $id_shopping = $res['id_shopping'];
            }
                
              return $id_shopping;
        }



        public function sumNumberOfPurchasesOfaScreening($id_screening){

           $query ="SELECT ifnull(sum(countrticket),0) suma from ". $this->tableName." WHERE idscreening = (:id_screening)";

           $parameters['id_screening'] =$id_screening;

           try{
    
            $this->connection = Connection::GetInstance();
            $results = $this->connection->Execute($query, $parameters);
           
        } catch (Exception $ex) {
            throw $ex;
        }

          $suma = null;

        if(!empty($results)){

            foreach($results as $res){
               
                $suma = $res['suma'];
            }
               
        }
        return $suma;
        
    }

    public function sumNumberOfPurchasesOfaCinema($id_cinema){

        $query ="SELECT ifnull(sum(s.countrticket),0) suma 
        from shopping s
        inner join screening sc
        on s.idscreening = sc.id_screening
        inner join room r
        on sc.idroom = r.id_room
        where r.idcinema =(:idcinema)";

        $parameters['idcinema'] =$id_cinema;

        try{
 
         $this->connection = Connection::GetInstance();
         $results = $this->connection->Execute($query, $parameters);
        
     } catch (Exception $ex) {
         throw $ex;
     }

       $suma = null;

     if(!empty($results)){

         foreach($results as $res){
            
             $suma = $res['suma'];
         }
            
     }
     return $suma;
     
 } 
 public function sumMoneyOfPurchasesOfaCinema($id_cinema){

    $query ="SELECT ifnull(sum(s.total),0)suma 
    from shopping s
    inner join screening sc
    on s.idscreening = sc.id_screening
    inner join room r
    on r.id_room = sc.idroom
   where r.idcinema =(:idcinema)";

    $parameters['idcinema'] =$id_cinema;

    try{

     $this->connection = Connection::GetInstance();
     $results = $this->connection->Execute($query, $parameters);
    
 } catch (Exception $ex) {
     throw $ex;
 }

   $suma = null;

 if(!empty($results)){

     foreach($results as $res){
        
         $suma = $res['suma'];
     }
        
 }
 return $suma;
 
} 
    
    public function sumNumberOfPurchasesOfaMovie($id_movie){

        $query ="SELECT ifnull(sum(s.countrticket),0)suma 
        from shopping s
        inner join screening sc
        on s.idscreening = sc.id_screening
        inner join movie m
        on sc.idmovie = m.id_movie
        where sc.idmovie =(:idmovie)";

        $parameters['idmovie'] =$id_movie;

        try{
 
         $this->connection = Connection::GetInstance();
         $results = $this->connection->Execute($query, $parameters);
        
     } catch (Exception $ex) {
         throw $ex;
     }

       $suma = null;

     if(!empty($results)){

         foreach($results as $res){
            
             $suma = $res['suma'];
         }
            
     }
     return $suma;
     
 }
 public function sumMoneyOfPurchasesOfaMovie($id_movie){

    $query ="SELECT ifnull(sum(s.total),0)suma 
    from shopping s
    inner join screening sc
    on s.idscreening = sc.id_screening
    inner join movie m
    on sc.idmovie = m.id_movie
    where sc.idmovie =(:idmovie)";

    $parameters['idmovie'] =$id_movie;

    try{

     $this->connection = Connection::GetInstance();
     $results = $this->connection->Execute($query, $parameters);
    
 } catch (Exception $ex) {
     throw $ex;
 }

   $suma = null;

 if(!empty($results)){

     foreach($results as $res){
        
         $suma = $res['suma'];
     }
        
 }
 return $suma;
 
}


}
