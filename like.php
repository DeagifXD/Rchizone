<?php

require_once '../../../config.inc.php';


$db = Typecho_Db::get();


$cid = intval($_POST['cid']);


$row = $db->fetchRow(
    $db->select()
    ->from('table.fields')
    ->where('cid = ?', $cid)
    ->where('name = ?', 'likes')
);


if($row){
    $num = intval($row['str_value']) + 1;


    $db->query(
        $db->update('table.fields')
        ->rows(array(
            'str_value'=>$num
        ))
        ->where('cid=?',$cid)
        ->where('name=?','likes')
    );


}else{


    $db->query(
        $db->insert('table.fields')
        ->rows(array(
            'cid'=>$cid,
            'name'=>'likes',
            'type'=>'str',
            'str_value'=>'1'
        ))
    );


}


echo json_encode([
    'code'=>1,
    'count'=>$num ?? 1
]);