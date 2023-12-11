<?php 

class Database {


      public $pdo;

      public function __construct($db="test" , $user="root" , $pass="" , $host="localhost:3307")   {

        try { 

              $this->pdo = new PDO ("mysql:host=$host;dbname=$db", $user, $pass);
              $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

              echo "connected to database $db";
        }    catch(PDOException $e) {
              echo "Connection failed: " . $e->getMessage();
        }
      }
        public function insertUser($email, $password)
        {
            $sql = "INSERT INTO users VALUES (null, :email, :password)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'email' => $email,
                'password' => $password
            ]);
        }

        public function selectUser()
        {
            $stmt = $this->pdo->query("SELECT * FROM users");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
     
        public function selectOneUser($id)
        {
            $stmt = $this->pdo->query("SELECT * FROM users WHERE id = ?");
            $stmt->execute(['id']);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function editUser($id, $email, $password)
        {
            $stmt = $this->pdo->prepare("UPDATE users SET email = :email, password = :password WHERE id = :id");
            $password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->execute([
                'id' => $id,
                'email' => $email,
                'password' => $password
            ]);
        }
     
        public function deleteUser($id)
        {
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute([$id]);
        }
    }
    
      
     

   
?>