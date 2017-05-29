<?php

function array_to_string($string)
{

  if (is_array($string))
  {
    static $new_string ='';
    foreach($string as $row)
    {
      $new_string .="$row";
    }
    return ($new_string);
  }else{
    return ($string);
  }
  //$new_string =str_replace(',',';',$new_string);
}

//dump(basename('array.php','.php'));
$arr ='a,b,c,d';
$arr2 =[
  1=>'a',
  2=>'b',
  3=>'c'
];
//var_dump(array_to_string($arr2));


/**
 * string_to_array()
 */
function string_to_array($string)
{
  if (is_string($string))
  {
    $string =explode(',',$string);
  }
  return $string;
}

//var_dump(string_to_array($arr));

/**
 * random array
 */
 $arr =[
 1=>'John',
 2=>'Sam',
 3=>'Grace'
];
//It cant work;
function rand_arr($arr)
{
    $len =count($arr);
    function reject($arr[$rand_key],$len)
    {
        if (isset($arr[$rand_key]))
        {
          $rand_key=rand(1,$len);
          reject($rand_key);
        }
        return $rand_key;
    }


    foreach ($arr as $key => $value)
    {
        $rand_key=rand(1,$len);
        $arr[reject($rand_key,$len)] =$value;
    }
    return $arr;
}

var_dump(rand_arr($arr));


 ?>
