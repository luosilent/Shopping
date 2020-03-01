<?php
header("Access-Control-Allow-Origin: *");//这个必写，否则报错

require "conexion.php";
$buying = new ApptivaDB();
$action = "select";
$res = array("error" => false);
if (isset($_GET['action']))
    $action = $_GET['action'];

$post = json_decode(file_get_contents("php://input"), true);
//请求的参数
if ($post) {
    $user_id = isset($post['user_id']) ? $post['user_id'] : "";
    $shopping_id = isset($post['shopping_id']) ? $post['shopping_id'] : "";
    $shopping_name = isset($post['shopping_name']) ? $post['shopping_name'] : "";
    $shopping_price = isset($post['shopping_price']) ? $post['shopping_price'] : "";
    $shopping_img = isset($post['shopping_img']) ? $post['shopping_img'] : "";
    $total = isset($post['total']) ? $post['total'] : "";
    $is_buy = isset($post['is_buy']) ? $post['is_buy'] : 0;
}

switch ($action) {
    //查询所有购物车的商品
    case 'select_all':
        $u = $buying->select_all("buying", "1", $_GET['user_id'], $is_buy = 0);
        if ($u):
            $arr = array();
            while ($row = $u->fetch_assoc()) {
                $arr[] = $row;
            }
            $res['buying'] = $arr;
        else:
            $res['error'] = true;
        endif;
        break;
    //查询已购买订单
    case 'select_buy':
        $u = $buying->select_all("buying", "1", $_GET['user_id'], $is_buy = 1);
        if ($u):
            $arr = array();
            while ($row = $u->fetch_assoc()) {
                $arr[] = $row;
            }
            $res['buying'] = $arr;
        else:
            $res['error'] = true;
        endif;
        break;
    //查询购物车商品数量
    case 'select_num':
        $u = $buying->select_num("buying", "1", $_GET['user_id'], $is_buy = 0);
        if ($u):
            $arr = array();
            while ($row = $u->fetch_assoc()) {
                //使用聚合函数total统计
                $arr = $row['total'];
            }
            $res['buying'] = $arr;
        else:
            $res['error'] = true;
        endif;
        break;
    //查询购物车的商品详情
    case 'select_buying':
        $u = $buying->select_buying("buying", "1", $user_id, $shopping_id, $is_buy = 0);
        if ($u):
            $arr = array();
            while ($row = $u->fetch_assoc()) {
                if ($row) {
                    $arr = $row;
                }
                
            }
            $res['buying'] = $arr;
        else:
            $res['error'] = true;
        endif;
        break;
    //更新购物车
    case 'update':
        $u = $buying->update("buying", "1", $user_id, $shopping_id, $total, $is_buy = 0);
        if ($u):
            $r = $buying->select_all("buying", "1", $user_id, $is_buy = 0);
            $arr = array();
            while ($row = $r->fetch_assoc()) {
                $arr[] = $row;
            }
            $res['buying'] = $arr;
        else:
            $res['error'] = true;
        endif;
        break;
    //更新购买订单
    case 'update_buy':
        $u = $buying->update_buy("buying", "1", $user_id, $shopping_id, $is_buy = 1);
        if ($u):
            $r = $buying->select_all("buying", "1", $user_id, $is_buy = 0);
            $arr = array();
            while ($row = $r->fetch_assoc()) {
                $arr[] = $row;
            }
            $res['buying'] = $arr;
        else:
            $res['error'] = true;
        endif;
        break;
    //删除购物车商品
    case 'delete':
        $u = $buying->delete("buying", "1", $user_id, $shopping_id);
        if ($u):
            $r = $buying->select_all("buying", "1", $user_id, $is_buy = 0);
            $arr = array();
            while ($row = $r->fetch_assoc()) {
                $arr[] = $row;
            }
            $res['buying'] = $arr;

        else:
            $res['error'] = "删除失败";
        endif;
        break;
    //添加商品到购物车
    case 'insert':
        $u = $buying->insert("buying", "1", $user_id, $shopping_id, $total,$shopping_name, $shopping_price, $shopping_img);
        if ($u):
            $r = $buying->select_buying("buying", "1", $user_id, $shopping_id, $is_buy = 0);
            $arr = array();
            while ($row = $r->fetch_assoc()) {
                $arr = $row;
            }
            if ($arr) {
                $res['buying'] = $arr;
            }else{
                $res['buying'] = [];
            }

        else:
            $res['error'] = "添加失败";
            #res['error']=true;
        endif;
        break;
}

echo(json_encode($res));
//这里用echo而不是return

?>