--TEST--
MongoCode insertion with optional scope
--SKIPIF--
<?php require_once "tests/utils/standalone.inc";?>
--FILE--
<?php
require_once "tests/utils/server.inc";
$mongo = mongo_standalone();
$coll = $mongo->selectCollection(dbname(), 'mongocode');
$coll->drop();

$codeStr = 'return (x < 5);';

$coll->insert(array('_id' => 1, 'code' => new MongoCode($codeStr)));
$result = $coll->findOne(array('_id' => 1));
echo $result['code']->code . "\n";
echo json_encode($result['code']->scope) . "\n";

$coll->insert(array('_id' => 2, 'code' => new MongoCode($codeStr, array('x' => 2))));
$result = $coll->findOne(array('_id' => 2));
echo $result['code']->code . "\n";
echo json_encode($result['code']->scope) . "\n";
?>
--EXPECT--
return (x < 5);
[]
return (x < 5);
{"x":2}
