<?php
$a ='hello';
$b=&$a;
unset($b);
$b='world';
echo $a;
$var =false;

if (empty($var)) {
  echo "null";
}else{
  echo "
  have value";
}

function p()
{
  return 1;
}
if (p()) {
  echo "true";
}


 ?>
