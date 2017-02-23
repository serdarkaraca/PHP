<?PHP

/*
Hazırlayan / Created : Serdar KARACA
http://serdarkaraca.com
serdarkaraca13@gmail.com
*/


class DB_Class {

    private $db;
    private $dsn;
    private $user;
    private $password;



    function __construct() {
        $this->dsn = 'mysql:host=127.0.0.1;dbname=serdarkaraca;charset=utf8';
        $this->user = 'serdarkaraca';
        $this->password = 'serdarkaraca';
    }

    private function _OpenConnection() {
        try
        {
            $this->db = new PDO($this->dsn, $this->user, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        }
        catch (PDOException $e)
        {
            echo 'Veritabanı bağlantısı başarısız oldu: ' . $e->getMessage();
        }

    }

    private function _CloseConnection()
    {
        $this->db = null;
    }

    function insert($_table, $_data)
    {
        $_result = 0;
        $_area1 = "";
        $_area2 = "";
        foreach ($_data as $_key => $_value) {
            $_area1 .= $_key . ",";
            $_area2 .= ":".$_key.",";
        }
        $_area1 = substr($_area1,0,strlen($_area1)-1);
        $_area2 = substr($_area2,0,strlen($_area2)-1);
        $this->_OpenConnection();
        $query = $this->db->prepare("INSERT INTO ".$_table." (".$_area1.") VALUES (".$_area2.")");
        $query->execute($_data);
        if ( $query ) $_result = $this->db->lastInsertId(); else $_result = 0;
        $this->_CloseConnection();
        return $_result;
    }

    function select($column,$_table,$where="",$_values)
    {
        $_result = null;
        $this->_OpenConnection();
        $query = $this-> db->prepare("SELECT ".$column." FROM " . $_table . " " . $where);
        if($_values==NULL)
        {
            $query -> execute();
        }
        else
        {
            $query->execute($_values);
        }

        if ($query) $_result = $query; else $_result = null;
        $this->_CloseConnection();
        return $_result;
    }


    function update($_table, $_data, $where="")
    {
        $_result = "";
        $_area = "";
        foreach ($_data as $_key => $_value) $_area .= $_key . "= :".$_key.",";
        $_area = substr($_area,0,strlen($_area)-1);
        if($where!="") $where = " WHERE ".$where;
        $this->_OpenConnection();

        $query = $this->db->prepare("UPDATE ".$_table." SET ".$_area.$where);
        $update = $query->execute($_data);
        if ( $update ) $_result = $query->rowCount(); else $_result = 0;
        $this->_CloseConnection();
        return $_result;
    }

    function delete($_table,$where="")
    {
        $_result = "";
        $this->_OpenConnection();
        $query = $this->db->prepare("DELETE FROM ".$_table." Where ".$where);
        $query->execute();
        $this->_CloseConnection();
        return $_result;
    }




}
