<!-- db.php -->
<?php
class Database{
    private $db;

    public function __construct()
    {
        $config = parse_ini_file('config.ini');

        $dsn = 'mysql:host='. $config['hostname']. ';dbname='. $config['database'].';charset=utf8';
        $user = $config['username'];
        $password = $config['password'];

        try{
            $this->db = new PDO($dsn, $user, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die('Erro de conexão: '.$e->getMessage());
        }
    }

    public function getPDO()
    {
        return $this->db;
    }
}