<?php
/**
 * Created by PhpStorm.
 * User: ricar
 * Date: 17/09/2017
 * Time: 19:41
 */

namespace AppBundle\Controller\Api;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoriesController extends Controller
{
    /**
     * @Route("/api/changeposition")
     * @Method("POST")
     */
    public function editPosition(Request $request) {
        $data = json_decode($request->getContent(), true);

        $result = $this->changePosition($data);
        if ($result) {
            return new Response($result);
        } else {
            return new Response("Error changing position");
        }
    }

    private function changePosition($data) {
        $con=mysqli_connect("localhost","root","","default_schema");

        /* check connection */
        if (mysqli_connect_errno()) {
            return false;
        }


        $node_id = mysqli_real_escape_string($con, $data['node_id']);
        $new_position = mysqli_real_escape_string($con, $data['new_position']);

        $query = "select node_id, position, parent_id from categories where node_id = ".$node_id;
        $result = mysqli_query($con, $query);

        if ($result) {
            if ($row = $result->fetch_row()) {
                $toChange['node_id'] = $row[0];
                $toChange['position'] = $row[1];
                $toChange['parent_id'] = $row[2];

                $lastPosition = $this->getLastPosition($toChange['parent_id']);
                if ($new_position > $lastPosition) {
                    $new_position = $lastPosition;
                }

                if ($toChange['position'] > $new_position) {
                    $this->moveOthers($con, $toChange, $new_position, 1);
                } else if ($toChange['position'] < $new_position) {
                    $this->moveOthers($con, $toChange, $new_position, 0);
                }
                $query = "update categories set position = ".$new_position." where node_id = ".$node_id;
                mysqli_query($con, $query);
                return "Position changed succesfully";
            }
        }
        return "Node not found";
    }

    private function moveOthers($con, $toChange, $new_position, $operator) {
        if ($operator == 1) {
            $toChangePosition = " + 1 ";
            $toFilterPosition = " position >= ".$new_position." and position < ".$toChange['position'];
        } else {
            $toChangePosition = " - 1 ";
            $toFilterPosition = " position > ".$toChange['position']." and position <= ".$new_position;
        }

        $query = "update categories set position = position".$toChangePosition." 
                  where parent_id = ".$toChange['parent_id']." 
                  and node_id <> ".$toChange['node_id']." and ".$toFilterPosition;

        mysqli_query($con, $query);
    }

    /**
     * @Route("/api/categories")
     * @Method("POST")
     */
    public function newCategory(Request $request) {
        $data = json_decode($request->getContent(), true);

        if ($this->saveCategory($data)) {
            return new Response("Category created succesfully");
        } else {
            return new Response("Error creating category");
        }
    }

    private function saveCategory($data)
    {
        $con = mysqli_connect("localhost", "root", "", "default_schema");

        /* check connection */
        if (mysqli_connect_errno()) {
            return false;
        }

        $node_name = mysqli_real_escape_string($con, $data['node_name']);
        if ($data['parent_id']) {
           $parent_id = mysqli_real_escape_string($con, $data['parent_id']);
        } else {
            $parent_id = 0;
        }

        $position = $this->getLastPosition($parent_id) + 1;
        $query = "insert into categories (parent_id, node_name, position) values (".$parent_id.", '".$node_name."', ".$position.")";
        $result = mysqli_query($con, $query);

        mysqli_close($con);

        if ($data['position']) {
            $this->changePosition($data);
        }

        return $result;
    }

    private function getLastPosition($parent_id) {
        $con = mysqli_connect("localhost", "root", "", "default_schema");
        $query = "select max(position) from categories where parent_id = ".$parent_id;

        if ($result = mysqli_query($con, $query)) {
            if ($row = $result->fetch_row()) {
                return $row[0];
            }
        }
        return 0;
    }

    /**
     * @Route("/api/categories")
     * @Method("GET")
     */
    public function getCategories(Request $request) {
        $data = json_decode($request->getContent(), true);

        $result = $this->returnCategories($data);
        if ($result) {
            $index = 0;
            while ($row = $result->fetch_row()) {
                $response[$index]['node_id'] = $row[0];
                $response[$index]['parent_id'] = $row[1];
                $response[$index]['node_name'] = $row[2];
                $response[$index]['position'] = $row[3];
                $index += 1;
            }
            return new Response(json_encode($response));
        } else {
            return new Response("Error finding category");
        }
    }


    private function returnCategories($data)
    {
        $con = mysqli_connect("localhost", "root", "", "default_schema");

        /* check connection */
        if (mysqli_connect_errno()) {
            return null;
        }
        $node_id = null;
        $parent_id = null;
        $node_name = null;
        if ($data) {
            if ($data['parent_id'] != null) {
                $parent_id = mysqli_real_escape_string($con, $data['parent_id']);
            }
            if ($data['node_name'] != null) {
                $node_name = mysqli_real_escape_string($con, $data['node_name']);
            }
            if ($data['node_id'] != null) {
                $node_id = mysqli_real_escape_string($con, $data['node_id']);
            }
        }

        $query = "SELECT node_id, parent_id, node_name, position FROM Categories where 1=1";
        if ($node_id) {
            $query = $query." and node_id = ".$node_id;
        }
        if ($parent_id) {
            $query = $query." and parent_id = ".$parent_id;
        }
        if ($node_name) {
            $query = $query." and node_name like '%".$node_name."%'";
        }

        $result = mysqli_query($con, $query);

        mysqli_close($con);

        return $result;
    }

    /**
     * @Route("/api/deletecategory")
     * @Method("POST")
     */
    public function removeCategory(Request $request) {
        $data = json_decode($request->getContent(), true);

        if ($this->deleteCategory($data)) {
            return new Response("Category removed succesfully");
        } else {
            return new Response("Error removing category");
        }
    }

    private function deleteCategory($data) {
        $con=mysqli_connect("localhost","root","","default_schema");

        /* check connection */
        if (mysqli_connect_errno()) {
            return false;
        }

        $node_id = mysqli_real_escape_string($con, $data['node_id']);

        $result = mysqli_query($con, "delete from categories where node_id = ".$node_id);

        mysqli_close($con);

        return $result;
    }
}

?>


