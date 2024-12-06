<?php
class User
{
    // Mỗi file Model tương ứng với một Table
    // Đây là 1 file Model, nó sẽ có những biến tương ứng với các cột của table trong Database
    // Do trong cơ sở dữ liệu, bảng "users" (Tên bảng thường để số nhiều, tên model để số ít) có 4 cột là: id, username, password và role thì mình sẽ tạo 4 biến tương ứng tại model
    private $id;
    private $username;
    private $password;
    private $role;

    // Đây gọi là hàm khởi tạo, nó thường có 2 hàm khởi tạo cơ bản nhất là hàm khởi tạo không tham số và hàm khởi tạo có tham số.
    // Ví dụ mình muốn tạo một User bằng hàm khởi tạo thì có thể viết là: $user = new User("ledinhtu880", "123456", "user") thì sẽ tạo được một biến có kiểu là User
    // Có thể lấy được username của biến đó bằng cách gọi hàm $user->getUsername(); thì kết quả sẽ là ledinhtu880 

    public function __construct($username, $password, $role)
    {
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getRole()
    {
        return $this->role;
    }
    public function setPassword($newPassword)
    {
        $this->password = $newPassword;
    }
    public function checkPassword($inputPassword)
    {
        return $this->password == $inputPassword;
    }
}
