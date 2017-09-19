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
            <a href="task1.php"> < back to task 1</a>
            <br/>
            <br/>
            <div class="container">
                <h4>The methods are located in the symfony project at the '/api' uri. All parameters are sanitized so you don't have to worry about SQL injection.</h4>
                <br/>
                <br/>
                <h5>/api/categories</h5>
                <li>To get categories by name send a GET request to the service with the node_name parameter.</li>
                <li>To get the category by ID send a GET request to the service with the node_id parameter.</li>
                <li>To get all children from a node send a GET request to the service with the parent_id parameter.</li>
                <li>The GET request for this service will also accept a mix of the above parameters, adding all filters.</li>
                <li>To create a new category send a POST request to the same uri semding a node_name. You can also send a parent_id and/or a position to have the new node receive the parent/position.</li>
                <br/>
                <h5>/api/deletecategory</h5>
                <li>To delete a categories send a POST request to the service with the node_id parameter.</li>
                <li>Usually the deletion would only be logical (a boolean field set to true when deleted) but for the purposes of this test I left it physical.</li>
                <br/>
                <h5>/api/changeposition</h5>
                <li>To change the position of a categories send a POST request to the service with the node_id parameter, you also have to send the new position.</li>
                <br/>
            </div>
            <br/>
            <a href="task3.php"> advance to task 3 ></a>
        </div>
    </div>
</div>
</body>
</html>



