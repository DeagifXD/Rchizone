<?php
/**
 * 点赞接口
 *
 * 通过 POST 提交 cid，返回 JSON：{ ok, likes }
 * 同一浏览器（Cookie）对同一篇文章只会计数一次。
 */

require_once dirname(__DIR__, 3) . '/config.inc.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

/**
 * 输出 JSON 并结束
 *
 * @param array $data
 * @param int $status
 */
function rchi_like_json(array $data, int $status = 200)
{
    \Typecho\Response::getInstance()->setStatus($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    rchi_like_json(['ok' => false, 'message' => 'Method Not Allowed'], 405);
}

/** 简单的同源校验，防止第三方站点偷偷刷赞 */
$refererHost = parse_url((string) ($_SERVER['HTTP_REFERER'] ?? ''), PHP_URL_HOST);
$requestHost = (string) ($_SERVER['HTTP_HOST'] ?? '');

if ($refererHost && $requestHost && $refererHost !== $requestHost) {
    rchi_like_json(['ok' => false, 'message' => 'Invalid referer'], 403);
}

$cid = isset($_POST['cid']) ? (int) $_POST['cid'] : 0;
if ($cid <= 0) {
    rchi_like_json(['ok' => false, 'message' => 'Invalid cid'], 400);
}

/** @var \Typecho\Db $db */
$db = \Typecho\Db::get();

$post = $db->fetchRow(
    $db->select('cid', 'type')
        ->from('table.contents')
        ->where('cid = ?', $cid)
        ->limit(1)
);

if (empty($post) || $post['type'] !== 'post') {
    rchi_like_json(['ok' => false, 'message' => 'Post not found'], 404);
}

$cookieName = 'rchi_liked_' . $cid;
$liked = isset($_COOKIE[$cookieName]);

$row = $db->fetchRow(
    $db->select('str_value')
        ->from('table.fields')
        ->where('cid = ?', $cid)
        ->where('name = ?', 'likes')
        ->limit(1)
);

$likes = $row ? (int) $row['str_value'] : 0;

if (!$liked) {
    $likes++;

    if ($row) {
        $db->query(
            $db->update('table.fields')
                ->rows(['str_value' => (string) $likes])
                ->where('cid = ?', $cid)
                ->where('name = ?', 'likes')
        );
    } else {
        $db->query(
            $db->insert('table.fields')->rows([
                'cid'         => $cid,
                'name'        => 'likes',
                'type'        => 'str',
                'str_value'   => (string) $likes,
                'int_value'   => 0,
                'float_value' => 0
            ])
        );
    }

    setcookie($cookieName, '1', [
        'expires'  => time() + 31536000,
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
}

rchi_like_json(['ok' => true, 'likes' => $likes, 'liked' => true]);
