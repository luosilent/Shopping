<?php
header("Access-Control-Allow-Origin: *");//这个必写，否则报错
require "conexion.php";
$note = new ApptivaDB();
$res = array("error" => false);

$action = isset($_GET['action']) ? $_GET['action'] : "";
$type = isset($_GET['type']) ? $_GET['type'] : "";
$id = isset($_GET['id']) ? $_GET['id'] : "";
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : "";
//请求的参数
$post = json_decode(file_get_contents("php://input"), true);
if ($post) {
	$id = isset($post['note_id']) ? $post['note_id'] : "";
	$user_id = isset($post['user_id']) ? $post['user_id'] : "";
	$condition = isset($post['condition']) ? $post['condition'] : "";
	$note_name = isset($post['note_name']) ? $post['note_name'] : "";
	$note_image = isset($post['note_image']) ? $post['note_image'] : "";
	$note_content = isset($post['note_content']) ? $post['note_content'] : "";
	$note_type = isset($post['note_type']) ? $post['note_type'] : "";
	$type = isset($post['type']) ? $post['type'] : "";
}


switch ($action) {
	case 'getNote':
		$u = $note->select_note("note", $type);
		if ($u):
			$arr = array();
			while ($row = $u->fetch_assoc()) {
				$arr[] = $row;
			}
			$res['notes'] = $arr;
		else:
			$res['error'] = true;
		endif;
		break;
	case 'getDetail':
		$u = $note->select_detail("note",'id', $id);
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
		$u = $note->search("note", "1", $_GET['search']);
		if ($u):
			$arr = array();
			while ($row = $u->fetch_assoc()) {
				$arr[] = $row;
			}
			$res['notes'] = $arr;
		else:
			$res['error'] = true;
		endif;
		break;

	case 'update_note':
		$u1 = $note->update_note("note", $condition, $id, $type);
		$u2 = $note->select_my_note("my_note", "note_id", $user_id, $id);
		if ($u2->num_rows == 0):
			$r = $note->insert_my_note("my_note", $condition, $id, $user_id, $note_name, $note_image, $note_type, $note_content);
		else:
			$r = $note->update_my_note("my_note", $condition, $id, $user_id, $type);
		endif;
		if ($r):
            $u4 = $note->select_detail("note",'id', $id);
            while ($row = $u4->fetch_assoc()) {
                $arr = $row;
            }
			$res['notes'] = $arr;
		else:
			$res['error'] = true;
		endif;
		break;

	case 'select_my_note':
		$u = $note->select_my_note("my_note", $condition, $user_id, $id = null);
		if ($u->num_rows != 0):
			$arr = array();
			while ($row = $u->fetch_assoc()) {
				$arr[] = $row;
			}
			$res['notes'] = $arr;
		else:
			$res['error'] = true;
		endif;
		break;

}

echo(json_encode($res));//这里用echo而不是return


