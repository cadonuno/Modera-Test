<!doctype html>

<html lang="en">
    <head>
        <meta charset="utf-8">

        <title>Modera Test Ricardo Pereira</title>
        <meta name="description" content="Task 3 - Modera Test Ricardo Pereira">
        <meta name="author" content="Ricardo Pereira">

    </head>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
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
                Task 3:
                <br/>
                <a href="task2.php"> < back to task 2</a>
                <br/>
                <br/>
                <div class="panel-group" id="accordion0">
                    <div class="panel panel-default">
                        <?php
                            print_accordion();
                        ?>
                    </div>
                </div>
                <br/>
                <a href="index.php"> back to menu ></a>
            </div>
        </div>
    </div>
    </body>
</html>


<?php
    function print_accordion() {
        $con=mysqli_connect("localhost","root","","default_schema");
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        print_elements($con, 0, 0);

        mysqli_close($con);
    }

    function print_elements($con, $parent_id, $padding) {
            $query = "SELECT node_id, parent_id, node_name, position FROM Categories where parent_id = ".$parent_id." order by position";

        if ($result = $con->query($query)) {

            $padding_depth = $padding*25;
            while ($row = $result->fetch_row()) {
                if (has_children($row[0], $con)) {
                    echo '<div class="panel-heading" style="padding-left: '.$padding_depth.'px">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion'.$parent_id.'" href="#collapse'.$row[0].'">
                                        '.$row[0].' - '.$row[2].'
                                    </a>
                                </h4>
                            </div>';

                    echo '<div id="collapse' . $row[0] . '" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class="panel-group" id="accordion' . $row[0] . '">
                                    <div class="panel panel-default">';
                    print_elements($con, $row[0], $padding + 1);
                    echo '              </div>
                                </div>
                            </div>
                      </div>';
                } else {
                    echo '<h4 style="padding-left: '.$padding_depth.'px">'.$row[0]." - ".$row[2].'</h4>';
                }
            }

            /* free result set */
            $result->close();
        }
    }

    function has_children($node_id, $con) {
        $query = "SELECT count(*) FROM Categories where parent_id = ".$node_id;
        if ($result = $con->query($query)) {
            if ($row = $result->fetch_row()) {
                return $row[0] > 0;
            }
        }
        return false;
    }
?>