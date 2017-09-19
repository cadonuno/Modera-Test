<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Modera Test Ricardo Pereira</title>
    <meta name="description" content="Task 3 - Modera Test Ricardo Pereira">
    <meta name="author" content="Ricardo Pereira">
</head>
<link rel="stylesheet" type="text/css" href="css/bootstrap/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/main.css">
<body>
<div class="container">
    <br>
    <div>
        <div class="jumbotron">
            Test for Modera - By Ricardo Pereira
            <br/>
            <br/>
            Task 1:
            <br/>
            <a href="index.php"> < back to menu</a>
            <br/>
            <br/>
            <div class="row">

            </div>
            <?php
                read_and_print_file();
            ?>

            <br/>
            <a href="task2.php"> advance to task 2 ></a>
        </div>
    </div>
</div>
</body>
</html>



<?php
function read_and_print_file() {
    $handle = fopen("assets/testFile.txt", "r");
    if ($handle) {
        $index = 0;
        while (($line = fgets($handle)) !== false) {
            $record_array[$index] = extract_record($line);
            $index += 1;
        }

        //test_array($record_array);

        $output_array = populate_output(null, $record_array);

        print_array($output_array, 0);

        fclose($handle);
    } else {
        echo "Error opening file";
    }
}

function print_array($output_array, $padding) {
    if (!$output_array) {
        return;
    }
    for($i = 0; $i < count($output_array); $i += 1) {
        for ($j = 1; $j <= $padding; $j+=1) {
            echo "-";
        }
        echo $output_array[$i]['node_name'];
        echo "<br />";
        if ($output_array[$i]['children']) {
            print_array($output_array[$i]['children'], $padding + 1);
        }

    }
}

function populate_output($parent_element, $record_array) {
    $to_search = 0;
    if ($parent_element) { //looking for child elements
        $to_search = $parent_element['node_id'];

    }

    $index = 0;
    $output_array = null;
    for($i = 0; $i < count($record_array); $i += 1) {
        if ($parent_element != $record_array[$i]) {
            if ($record_array[$i]['parent_id'] == $to_search) {
                $output_array[$index] = $record_array[$i];
                //echo "adding element: ". $record_array[$i]['node_name']."<br/>";
                $output_array[$index]['children'] = populate_output($output_array[$index], $record_array);
                $index += 1;
            }
        }
    }


    return $output_array;
}

function extract_record($line) {
    $content = explode("|", $line);
    $result['node_id'] =  $content[0];
    $result['parent_id'] =  $content[1];
    $result['node_name'] =  $content[2];
    return $result;
}

//tests the printing of the array
function test_array($record_array) {
    for($i = 0; $i < count($record_array); $i += 1) {
        echo "Record: ".$i;
        echo "<br/>";
        echo "<p>";
        echo "Node ID: ";
        echo $record_array[$i]['node_id'];
        echo "</p>";
        echo "<p>";
        echo "Parent ID: ";
        echo $record_array[$i]['parent_id'];
        echo "</p>";
        echo "<p>";
        echo "Node Name: ";
        echo $record_array[$i]['node_name'];
        echo "</p>";
        echo "---------------------";
        echo "<br/>";
    }
}
?>



