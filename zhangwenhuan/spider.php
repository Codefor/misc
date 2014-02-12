<?php
$format = "http://www.miaomu.com/bj/default.asp?page=%s&sortid=&txtitle=&sf=";
for($i = 1;$i<= 1166;$i++){
    $url = sprintf($format,$i);
    $data = file_get_contents($url);
    print_r(parse($data));
    //sleep(1);
}

function parse($html){
    $ret = array();

    $data = $html;
    $data = str_replace("\n","",$data);
    $data = str_replace("\r","",$data);

    $res = preg_match_all('/<TR>(.*?)<\/TR>/',$data,$matches);
    if($res > 0 ){
	foreach($matches[0] as $match){
	    $res2 = preg_match_all('/<TD(.*?)>(.*?)<\/TD>/',$match,$detail);
	    if($res2 > 0 ){
		$t = array();
		foreach($detail[2] as $item){
		    $t[] = trim($item);
		}
		$ret[] = $t;
	    }
	}
    }
    return $ret;
}

