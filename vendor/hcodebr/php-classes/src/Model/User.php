<?php

 namespace Hcode\Model;
 use \Hcode\DB\Sql;
 use \Hcode\Model;


class User extends Model {
  const SESSION = "User";

public static function login($longin, $password){

    $sql = new Sql();

    $results = $sql->select("SELECT * FROM tb_users Where deslogin = :LOGIN", array (":LOGIN"=>$longin
    
    
     ));

    if(count($results)===0){

        throw new \Exception("usuario inexistente ou senha invalida", 1); // colocar a barra para acha exception principal
        
    }

    $data = $results[0];
     if(password_verify($password, $data["despassword"])=== true){  // vereificando se  a senha esta correta

        $user = new User();
        $user->setData($data);  

        $_SESSION[User::SESSION]= $user->getValues();
        
        return $user;


     } else {

        throw new \Exception("usuario inexistente ou senha invalida", 1);
     }

}

public static function verifyLogin($inadmin = true){


   if(
      !isset($_SESSION[User::SESSION]) || 
        !$_SESSION[User::SESSION] ||
       !(int)$_SESSION[User::SESSION] ["iduser"] > 0 ||
        (bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin
   ){

      header("Location: /admin/login");
      exit;
   }

}

  public static function logout(){

   $_SESSION[User::SESSION]= NULL;

  }
  
  public static function listALL(){

     $sql= new Sql();
     return $sql-> select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) ORDER BY b.desperson" );
}

public  function save(){

       $sql = new Sql();
       $results = $sql->select("Call sp_users_save(:desperson, :deslogin, 
       :despassword, :desemail, :nrphone, :inadmin)", array(

        ":desperson"=> $this->getdesperson(),
        ":deslogin"=> $this->getdeslogin(),
         "despassword"=>$this->getdespassword(),
         ":desemail"=>$this->getdesemail(),
         ":nrphone"=>$this->getnrphone(),
         ":inadmin" =>$this->getinadmin()
          
      ));

      $this->setData($results[0]);

}


public function get($iduser)
{
 
 $sql = new Sql();
 
 $results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) WHERE a.iduser = :iduser;", array(
 ":iduser"=>$iduser
 ));
 
 $data = $results[0];
 
 $this->setData($data);
 
 }


}





?>