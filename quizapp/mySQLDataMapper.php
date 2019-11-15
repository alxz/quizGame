<?php
// The class itself, it should look like this
class MySQL_DataMapper
{
    private $table = 'some_table';

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetchUserById($id)
    {
        $query = "SELECT * FROM `{$this->table}` WHERE `id` =:id";
        $stmt = $this->pdo->prepare($query);

        $stmt->execute(array(
           ':id' => $id
        ));

        return $stmt->fetch();
    }
}
?>
