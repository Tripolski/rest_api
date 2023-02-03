<?php

class User
{
    // Подключение к БД таблице "users"
    private $conn;
    private $table_name = "users";

    // Свойства
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $password;

    // Конструктор класса User
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // Метод для создания нового пользователя
    function create()
    {

        // Запрос для добавления нового пользователя в БД
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    firstname = :firstname,
                    lastname = :lastname,
                    email = :email,
                    password = :password";

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        // Инъекция
        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // Привязываем значения
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":email", $this->email);

        // Для защиты пароля
        // Хешируем пароль перед сохранением в базу данных
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(":password", $password_hash);

        // Выполняем запрос
        // Если выполнение успешно, то информация о пользователе будет сохранена в базе данных
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
    // Проверка, существует ли электронная почта в нашей базе данных
    function emailExists() {
    
        // Запрос, чтобы проверить, существует ли электронная почта
        $query = "SELECT id, firstname, lastname, password FROM " . $this->table_name . " WHERE email = ? LIMIT 0,1";
    
        // Подготовка запроса
        $stmt = $this->conn->prepare($query);
    
        // Инъекция
        $this->email=htmlspecialchars(strip_tags($this->email));
    
        // Привязываем значение e-mail
        $stmt->bindParam(1, $this->email);
    
        // Выполняем запрос
        $stmt->execute();
    
        // Получаем количество строк
        $num = $stmt->rowCount();
    
        // Если электронная почта существует,
        // Присвоим значения свойствам объекта для легкого доступа и использования для php сессий
        if ($num > 0) {
    
            // Получаем значения
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Присвоим значения свойствам объекта
            $this->id = $row["id"];
            $this->firstname = $row["firstname"];
            $this->lastname = $row["lastname"];
            $this->password = $row["password"];
    
            // Вернём "true", потому что в базе данных существует электронная почта
            return true;
        }
    
        // Вернём "false", если адрес электронной почты не существует в базе данных
        return false;
    }
    // Обновить запись пользователя
    public function update() {
    
        // Если в HTML-форме был введен пароль (необходимо обновить пароль)
        $password_set=!empty($this->password) ? ", password = :password" : "";
    
        // Если не введен пароль - не обновлять пароль
        $query = "UPDATE " . $this->table_name . " SET firstname = :firstname, lastname = :lastname, email = :email {$password_set} WHERE id = :id";
    
        // Подготовка запроса
        $stmt = $this->conn->prepare($query);
    
        // Инъекция (очистка)
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->email=htmlspecialchars(strip_tags($this->email));
    
        // Привязываем значения с HTML формы
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":email", $this->email);
    
        // Метод password_hash () для защиты пароля пользователя в базе данных
        if(!empty($this->password)){
            $this->password=htmlspecialchars(strip_tags($this->password));
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(":password", $password_hash);
        }
    
        // Уникальный идентификатор записи для редактирования
        $stmt->bindParam(":id", $this->id);
    
        // Если выполнение успешно, то информация о пользователе будет сохранена в базе данных
        if($stmt->execute()) {
            return true;
        }
    
        return false;
    }
    // Удалить запись пользователя
    function delete()
    {
        // запрос для удаления записи (товара)
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->id = htmlspecialchars(strip_tags($this->id));

        // привязываем id записи для удаления
        $stmt->bindParam(1, $this->id);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // метод для получения конкретного товара по ID
    function readOne()
    {
        // запрос для чтения одной записи (товара)
        $query = "SELECT id, firstname, lastname, email FROM " . $this->table_name . " WHERE id = ? LIMIT 0, 1";
                
        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // привязываем id товара, который будет получен
        $stmt->bindParam(1, $this->id);

        // выполняем запрос
        $stmt->execute();

        // получаем извлеченную строку
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // установим значения свойств объекта
        $this->id = $row["id"];
        $this->firstname = $row["firstname"];
        $this->lastname = $row["lastname"];
        $this->email = $row["email"];
    }
}

?>