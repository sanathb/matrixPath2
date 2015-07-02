<?php
/*
 * Given a matrix m*n, calculate all possible paths from left top to right bottom. 
 * *Precondition: 
 * Element can be traversed only once and you can move up,down, left or right
*/

function is_right_border($val)
{
    global $matrix;
    global $m,$n;
    
    if( ($val+1) %  $n == 0) {
        return 1;
    } else {
        return 0;
    }
}

function is_left_border($val)
{
    global $matrix;
    global $m,$n;    
    if( ($val) %  $n == 0) {
        return 1;
    } else {
        return 0;
    }
}

function is_top_row($val)
{
    global $matrix;
    
    if(in_array($val, $matrix[0])) {
        return 1;
    } else {
        return 0;
    }
    
}

function is_bottom_row($val)
{
    global $matrix;
    global $m,$n;    
    
    if(in_array($val, $matrix[($n-1)] ) ) {
        return 1;
    } else {
        return 0;
    }
    
}

//Matrix dimensions. 
//Assign values to these thru GET or POST to change dimensions
$m = 3;
$n = 3;

$matrix = array();
$i = 0;
$val = 0;//values in matrix ABCD... or 1,2,3,4....
for($i=0;$i<$m; $i++) {
    for($j=0;$j<$n;$j++) {
        $matrix[$i][$j] = $val++;        
    }
}



//echo json_encode($matrix);

for($i=0;$i<=$m;$i++) {
    for($j=0;$j<=$n;$j++) {
        echo " " . $matrix[$i][$j];
    }
    echo "<br>";
}


function get_left($val)
{
    if(is_left_border($val)) {
        return null;
    } else {
        return $val-1;
    }
}

function get_right($val)
{
    if(is_right_border($val)) {
        return null;
    } else {
        return $val+1;
    }
}

function get_up($val)
{
    global $m,$n;
    if(is_top_row($val)) {
        return null;
    } else {
        return $val-$n;
    }
}

function get_down($val)
{
    global $m,$n;
    if(is_bottom_row($val)) {
        return null;
    } else {
        return $val+$n;
    }
}

function get_neighbours($val)
{
    $up_element = get_up($val);
    $down_element = get_down($val);
    $right_element = get_right($val);
    $left_element = get_left($val);
    
    $return_data = array();
    
    if($up_element !== NULL ) {
        array_push($return_data, $up_element);
    }
    if($down_element !== NULL ) {
        array_push($return_data, $down_element);
    }
    if($right_element !== NULL ) {
        array_push($return_data, $right_element);
    }
    if($left_element !== NULL ) {
        array_push($return_data, $left_element);
    }
    
    return $return_data;
}

$trace_paths = array();
$matrix_sub_paths = array();

$last_element = $matrix[$m-1][$n-1];
$neighbour_elements = array();
//echo "last element: ". $last_element;
$neighbour_elements = get_neighbours($last_element);
//$neighbour_elements = get_neighbours(1);
/*echo "<pre>";
echo "neighbouring elements: ";
print_r($neighbour_elements);
*/

foreach($neighbour_elements as $val) {
    $matrix_sub_paths[] = array($val, $last_element);
}

/*echo "<pre>";
echo "sub_paths: ";
print_r($matrix_sub_paths);
//die();
*/

$i=0;

while(count($matrix_sub_paths) != 0)
{
    //filter duplicates    
    
    foreach($matrix_sub_paths as $key => $val) {
        
        $neighbour_elements = get_neighbours($val[0]);
        //$neighbour_count = count($neighbour_elements);
        //$existing_neighbour_count = 0;
        
        foreach($neighbour_elements as $val2) {
            if(!in_array($val2, $val)) {
                $current_matrix_path = implode(', ', $val);
                $current_matrix_path = $val2 . ', ' . $current_matrix_path; 
                $current_matrix_path = explode(', ', $current_matrix_path);
                array_push($matrix_sub_paths, $current_matrix_path);
            } else {
                //$existing_neighbour_count++;
            }
        }
        
        /*//if all neighbours are in array, unset
        if(($neighbour_count == $existing_neighbour_count) && $neighbour_count != 0 ) {
            unset($matrix_sub_paths[$key]);
        }*/
        unset($matrix_sub_paths[$key]);
        
        
    }
    
    //unset the ones for which no neighbours are appended
    
    //unset the ones taken to the trace path    
    foreach($matrix_sub_paths as $key => $val) {
        if($val[0] == 0) {
            $trace_paths[] = $val;
            unset($matrix_sub_paths[$key]);
        }
    }
    
    /*$matrix_sub_paths2 = array();
    $matrix_sub_paths2 = array_values($matrix_sub_paths);
    $matrix_sub_paths = array();
    $matrix_sub_paths = $matrix_sub_paths2;*/
    
}
    
    /*echo "<pre>";
    print_r($trace_paths);    
    die();*/

echo "<br> The paths are: <br>";
foreach($trace_paths as $val) {
    foreach($val as $val2) {
        echo "-->".$val2;
    }
    echo "<br>";
}


