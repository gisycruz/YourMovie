<?php
namespace DAO;

use DAO\Iscreening as Iscreening;
use DAO\Connection as Connection;
use DAO\QueryType as QueryType;
use Models\Screening as Screening;
use DAO\MovieBdDao as MovieBdDAO;
use Models\Room as Room;
use DAO\RoomBdDao as RoomBdDAO;
use DAO\ShoppingBdDAO as ShoppingBdDAO;
use FFI\Exception;

 

    class ScreeningBdDAO implements Iscreening{

        private $connection;
        private $tableName = "screening";
        private $listScreening = [];



        public function SaveScreeningInBd(Screening $screening) {

            $sql = "INSERT INTO " .$this->tableName. "(idroom, idmovie, date_screening, hour_screening) VALUES (:idroom, :idmovie, :date_screening, :hour_screening)";

            $parameters["idroom"] = $screening->getRoom()->getId_room();
            $parameters["idmovie"] = $screening->getMovie()->getId_movie();
            $parameters["date_screening"] = $screening->getDate_screening();
            $parameters["hour_screening"] = $screening->getHour_screening();
    
            try {
                $this->connection = Connection::GetInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);
            } catch (Exception $ex) {
                throw $ex;
            }
        }

        private function getScreeningsFromDB(){
        
            $query = "SELECT * FROM " . $this->tableName;

            try {
            
                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($query);
    
            } catch (Exception $ex) {
                throw $ex;
            }
    
            return $result;
        }

        public function getAllScreening() {

            $screeningArray = $this->getScreeningsFromDB();

            if(!empty($screeningArray)) {
                
                $result = $this->mapear($screeningArray);
                
                if(is_array($result)) {
                    
                    $this->listScreening = $result;
                }
                else {
                    
                    $arrayResult[0] = $result;
                    $this->listScreening = $arrayResult;
                }
                
                return $this->listScreening;
            }
            else {
                return $errorArray[0] = "Error al leer la base de datos.";
            }
    
        }

        private function getScreeningsFromARoomDB($id_room){
        
            $query = "SELECT * FROM " . $this->tableName . " WHERE idroom = :idroom";

            $parameters["idroom"] = intval($id_room);

            try {
            
                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($query, $parameters);
    
            } catch (Exception $ex) {
                throw $ex;
            }
            
            return $result;
        
        }

        public function GetScreeningsFromARoom($id_room) {

            $screeningArray = $this->getScreeningsFromARoomDB($id_room);

            if(!empty($screeningArray)) {
                
                $result = $this->mapear($screeningArray);
                
                if(is_array($result)) {
                    
                    $this->listScreening = $result;
                }
                else {
                    
                    $arrayResult[0] = $result;
                    $this->listScreening = $arrayResult;
                }
                
                return $this->listScreening;
            }
            else {
                return $errorArray[0] = "Error al leer la base de datos.";
            }
    
        }

        private function getScreeningsFromAMovieDB($id_movie){
        
            $query = "SELECT * FROM " . $this->tableName . " WHERE idmovie = :idmovie ORDER BY date_screening ASC";

            $parameters["idmovie"] = intval($id_movie);

            try {
            
                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($query, $parameters);
    
            } catch (Exception $ex) {
                throw $ex;  
            }
            
            return $result;
        }

        public function GetScreeningsFromAMovie($id_movie) {

            $screeningArray = $this->getScreeningsFromAMovieDB($id_movie);
            

            if(!empty($screeningArray)) {
                
                $result = $this->mapear($screeningArray);
                
                if(is_array($result)) {
                    
                    $this->listScreening = $result;
                }
                else {
                    
                    $arrayResult[0] = $result;
                    $this->listScreening = $arrayResult;
                }
                
                return $this->listScreening;
            }
            else {
                return $errorArray[0] = "Error al leer la base de datos.";
            }

        }

        public function DeleteScreeningInDB($id_screening) {
  
            $sql = "DELETE FROM screening WHERE id_screening = :id_screening";
      
            $parameters["id_screening"] = $id_screening;
    
            try {
    
                $this->connection = Connection::GetInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);
    
            } catch (Exception $ex){
                throw $ex;
            }
        }
        public function ModifyScreeningInBd($movie, $date, $time, $id_screening) {

           
            $query = "UPDATE " . $this->tableName . " SET idmovie=:idmovie,date_screening =:date_screening,hour_screening =:hour_screening WHERE (id_screening=:id_screening)";
           
      
            $parameters["idmovie"] = $movie;
            $parameters["date_screening"] = $date;
            $parameters["hour_screening"] = $time;
            $parameters['id_screening'] = $id_screening;
    
            try {
                $this->connection = Connection::GetInstance();
                return $this->connection->ExecuteNonQuery($query, $parameters);
            } catch (Exception $ex) {
                throw $ex;
            }
    
        }
        
        protected function mapear($value) {

         
            $value = is_array($value) ? $value : [];

            $resp = array_map(function($p){
                $screening = new Screening(RoomBdDAO::MapearRoom($p["idroom"]),MovieBdDAO::MapearMovie($p["idmovie"]),$p['date_screening'] , $p['hour_screening']);
                $screening->setId_screening($p['id_screening']);
                return $screening;
    
            }, $value);
    
            return count($resp) > 1 ? $resp : $resp['0'];
        }

        public function GetScreeningById($searchidScreening){

            $screening = null;
    
            $query = "SELECT * FROM " . $this->tableName . " WHERE (id_screening = :id_screening) ";
    
            $parameters["id_screening"] = $searchidScreening;
    
            try{
    
                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, $parameters);
            
            } catch (Exception $ex) {
                throw $ex;
            }
            
            $return = $this->mapear($results);
    
    
            return $return;
        }  

        public static function MapearScreening($idScreeningToMapear) {

            $screeningDAOBdAux = new ScreeningBdDAO();

            return $screeningDAOBdAux->GetScreeningById($idScreeningToMapear);
        }


        private function GetScreeningsFromDateAndTimeDB($id_room , $date_screening, $hour_screening) {

            $query = "SELECT * FROM screening WHERE  idroom =:idroom  &&  date_screening = :date_screening  && hour_screening =:hour_screening";


            $parameters['idroom'] = $id_room;
            $parameters["date_screening"] = $date_screening;
            $parameters['hour_screening'] = $hour_screening;


            try{

                $this->connection = Connection::GetInstance();
                return $this->connection->Execute($query, $parameters);
               

            } catch (Exception $ex) {

                throw $ex->getMessage();
            }


        }
        public function GetScreeningsFromDateAndTime($id_room , $date_screening, $hour_screening) {

            $screeningArray = $this->GetScreeningsFromDateAndTimeDB($id_room ,$date_screening, $hour_screening);
            
            if(!empty($screeningArray)) {
                
                $result = $this->mapear($screeningArray);
                
                if(is_array($result)) {
                    
                    $this->listScreening = $result;
                }
                else {
                    
                    $arrayResult[0] = $result;

                    $this->listScreening = $arrayResult;
                }
               
                return $this->listScreening;
            }

        }

        public function unoccupiedSeatsFromScreening($id_screening){
            
          $unoccupiedSeatds = 0;

          $shoppingBdDAO = new ShoppingBdDAO();
    
          $quantityPurchasedScrrening = $shoppingBdDAO->sumNumberOfPurchasesOfaScreening($id_screening);
          //devuelve 0 si no tiene compra ,tiene lugar ,si no devuelve cantidas de compradas

           $screening = ScreeningBdDAO::MapearScreening($id_screening);

        //se restan a la cantidad de asientos de sala de la funcion 
         $unoccupiedSeatds = $screening->getRoom()->getCapacity() - $quantityPurchasedScrrening;


         return $unoccupiedSeatds;

         //si unoccupiedSeatds <=0 no hay lugar 
        
    }

          //levanta un screening con lugar
         public function screenigWhitSeatFree($id_screening){

            $screening = null;

            $unoccupiedSeatds = $this->unoccupiedSeatsFromScreening($id_screening);

            if($unoccupiedSeatds > 0){

                //hay lugar en la sala B
                $screening = ScreeningBdDAO::MapearScreening($id_screening);
            }
            
           return $screening;

           //si hay lugar devuelve el screening sino null

         }

         private function BringDatesOfScreeningsDb() {

            $query = "select distinct s.date_screening
                        from screening s;";

            try{

                $this->connection = Connection::GetInstance();
                return $this->connection->Execute($query);


            } catch (Exception $ex) {

                throw $ex->getMessage();
            }

        }

    }

       /* private function BringGenresOfScreeningsDb() {

            $query = "select distinct g.id_genre, g.genrename 
                        FROM movie m
                        inner join screening s
                        on m.id_movie = s.idmovie
                        inner join genre g
                        on m.idgenre = g.id_genre;";

            try{

                $this->connection = Connection::GetInstance();
                return $this->connection->Execute($query);


            } catch (Exception $ex) {

                throw $ex->getMessage();
            }

        }
        public function GetGenresOfScreenings() {
            
            $genderList = $this->BringGenresOfScreeningsDb();
            $result = [];

            if(!empty($genderList)) {
                
                foreach($genderList as $genre) {
                    array_push($result, GenreBdDAO::MapearGenre($genre["id_genre"]));
                }
                
                if(is_array($result)) {
                    
                    return $result;
                }
                else {
                    
                    $arrayResult[0] = $result;
                    return $arrayResult;
                }
            }
            else {
                return $errorArray[0] = "No hay generos cargados. ERROR";
            }

        }
       
        private function BringDatesOfScreeningsDb() {

            $query = "select distinct s.date_screening
                        from screening s;";

            try{

                $this->connection = Connection::GetInstance();
                return $this->connection->Execute($query);


            } catch (Exception $ex) {

                throw $ex->getMessage();
            }

        }
        
        public function GetDatesOfScreenings() {
            
            $datesList = $this->BringDatesOfScreeningsDb();

            if(!empty($datesList)) {

                return $datesList;
                
            }
            else {
                return $errorArray[0] = "No hay generos cargados. ERROR";
            }

        }*/

        
        
        
       

?>
