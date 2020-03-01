<?php

class ApptivaDB
{
    private $host = "localhost";
    private $user = "root";
    private $pwd = "root";
    private $db = "project";
    public $conn;

    public function __construct()
    {
        $this->conn = new MySQLi($this->host, $this->user, $this->pwd, $this->db) or die(mysqli_error($this->conn));
        $this->conn->set_charset("utf8");
    }

    //按分类查询商品
    public function select_shopping($table, $type)
    {

        $sql = "select * from $table where type='$type'";

        $res = $this->conn->query($sql);

        return $res;
    }

    //按分类查询笔记
    public function select_note($table, $type)
    {

        $sql = "select * from $table where type='$type'";

        $res = $this->conn->query($sql);

        return $res;
    }

    //查找
    public function select($table, $condition)
    {
        $sql = "select * from $table";
        if ($condition == "note") {
            $sql .= " ORDER BY note_id DESC";
        }

        $res = $this->conn->query($sql);
        return $res;
    }

    //查找个人笔记
    public function select_my($table, $condition, $my)
    {
        $sql = "select * from $table where note_no = '$my'";
        $res = $this->conn->query($sql);
        return $res;
    }

    //按ID查找详情
    public function select_detail($table, $condition, $id)
    {
        $sql = "select * from $table where $condition ='$id' ";
        $res = $this->conn->query($sql);
        return $res;
    }

    //按user_id查找shoppingcar中的内容
    public function select_all($table, $condition, $user_id, $is_buy)
    {
        $sql = "select * from $table where user_id = $user_id and is_buy = $is_buy ";

        $res = $this->conn->query($sql);
        return $res;
    }

    //按ID查找shoppingcar中的内容
    public function select_buying($table, $condition, $user_id, $shopping_id, $is_buy = 0)
    {
        $sql = "select * from $table where user_id = $user_id and shopping_id = $shopping_id and is_buy = $is_buy";

        $res = $this->conn->query($sql);

        return $res;
    }

    //按user_id计算total
    public function select_num($table, $condition, $user_id, $is_buy)
    {
        $sql = "select sum(total) as total from $table where user_id = $user_id and is_buy = $is_buy";

        $res = $this->conn->query($sql);
        return $res;
    }

    //更新购物车商品数量
    public function update($table, $condition, $user_id, $shopping_id, $total, $is_buy = 0)
    {
        $sql = "update $table set total=$total WHERE user_id=$user_id and shopping_id=$shopping_id and is_buy = $is_buy ";
        $res = $this->conn->query($sql);
        // echo $sql;exit;
        return $res;
    }

    //更新购物车的商品状态（是否购买）
    public function update_buy($table, $condition, $user_id, $shopping_id, $is_buy)
    {
        $sql = "update $table set is_buy=$is_buy WHERE user_id=$user_id and shopping_id=$shopping_id ";
        $res = $this->conn->query($sql);
        // echo $sql;exit;
        return $res;
    }


    public function update_note($table, $condition, $id, $type)
    {
        $sql = "";
        if ($type == "add") {
            $sql = "update $table set $condition=$condition+1 WHERE id=$id ";
        } elseif ($type == "remove") {
            $sql = "update $table set $condition=$condition-1 WHERE id=$id ";
        }
        $res = $this->conn->query($sql);

        return $res;
    }


    public function select_my_note($table, $condition, $user_id, $note_id)
    {
        if ($note_id)
            $sql = "select * from $table where user_id = $user_id and note_id = $note_id";
        else
            $sql = "select * from $table where user_id = $user_id and $condition = 1";

        $res = $this->conn->query($sql);
//		 echo $sql;exit;
        return $res;

    }


    public function update_my_note($table, $condition, $note_id, $user_id, $type)
    {
        $val = ($type == "add") ? 1 : 0;
        $sql = "update $table set $condition=$val WHERE user_id=$user_id and note_id=$note_id ";
        $res = $this->conn->query($sql);
        // echo $sql;exit;
        return $res;
    }


    public function insert_my_note($table, $condition, $note_id, $user_id, $note_name, $note_image, $note_type, $note_content)
    {
        $collect = ($condition == "collect") ? 1 : 0;
        $praise = ($condition == "praise") ? 1 : 0;
        $create_time = date('Y-m-d H:i:s', time());
        $sql = "insert into $table (id,note_id, user_id, note_name,note_image,note_type,note_content, collect, praise,create_time) ";
        $sql .= "values ('','{$note_id}','{$user_id}','{$note_name}','{$note_image}','{$note_type}','{$note_content}','{$collect}','{$praise}','{$create_time}')";
        // echo $sql;exit;
        $res = $this->conn->query($sql);

        return $res;
    }

    //insert shoppingcar
    public function insert($table, $condition, $user_id, $shopping_id, $total, $shopping_name, $shopping_price, $shopping_img)
    {
        $create_time = date('Y-m-d H:i:s', time());
        $is_buy = 0;
        $sql = "insert into $table (user_id, shopping_id, total,shopping_name, shopping_price, shopping_img,create_time,is_buy) ";
        $sql .= "values ('{$user_id}','{$shopping_id}','{$total}','{$shopping_name}','{$shopping_price}','{$shopping_img}','{$create_time}','{$is_buy}')";
        $res = $this->conn->query($sql);

        return $res;
    }

    //按ID删除shoppingcar中的内容
    public function delete($table, $condition, $user_id, $shopping_id)
    {
        $sql = "delete from $table where user_id = $user_id and shopping_id =$shopping_id";
        $res = $this->conn->query($sql);
        return $res;
    }

    //按ID查找notes中的内容
    public function choose($table, $condition, $id)
    {
        $sql = "select * from $table where note_id =$id ";
        $res = $this->conn->query($sql);
        return $res;
    }

    //发现页分类
    public function fenlei($table, $condition, $class)
    {
        $sql = "select * from $table where note_class ='$class' ";
        $res = $this->conn->query($sql);
        return $res;
    }

    //搜索(发现页)
    public function search($table, $condition, $search)
    {
        $sql = "select * from $table where content like '%$search%' ";
        $res = $this->conn->query($sql);
        return $res;
    }

    // 搜索（商城页）
    public function finding($table, $condition, $search)
    {
        $sql = "select * from $table where shopping_name like '%$search%' ";
        $res = $this->conn->query($sql);
        return $res;
    }


}

?>