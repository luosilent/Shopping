<?php
header("Access-Control-Allow-Origin: *");//这个必写，否则报错
require "conexion.php";
$shopping = new ApptivaDB();
$res = array("error" => false);

$action = isset($_GET['action']) ? $_GET['action'] : "";
$type = isset($_GET['type']) ? $_GET['type'] : "";
$id = isset($_GET['id']) ? $_GET['id'] : "";

switch ($action) {
    case 'getShopping':
    $u = $shopping->select_shopping("shopping", $type);
        if ($u):
            $arr = array();
            while ($row = $u->fetch_assoc()) {
                $arr[] = $row;
            }
            $res['shoppingArray'] = $arr;
        else:
            $res['error'] = true;
        endif;
        break;
     case 'getDetail':
        $u = $shopping->select_shopping("shopping", $id);
            if ($u):
                $arr = array();
                while ($row = $u->fetch_assoc()) {
                    $arr[] = $row;
                }
                $res['detail'] = $arr;
            else:
                $res['error'] = true;
            endif;
            break;

	case 'search':
		$u = $shopping->search("shopping", "1", $_GET['search']);
		if ($u):
			$arr = array();
			while ($row = $u->fetch_assoc()) {
				$arr[] = $row;
			}
			$res['shopping'] = $arr;
		else:
			$res['error'] = true;
		endif;
		break;

}

echo(json_encode($res));//这里用echo而不是return


?>