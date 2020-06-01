<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
		
date_default_timezone_get();
session_start();
set_time_limit(0);


class Server {

    public function serve() {
		
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        $arrreq = explode("/", $_REQUEST['_url']);
        array_shift($arrreq);
        array_shift($arrreq);
        $cmd = $arrreq[0];

        //$req = $_SERVER['argv'][0];			

        $arrreq = $_REQUEST;
        $cmd = $_REQUEST['cmd'];
		
		
		


        switch ($method) {
            //search
            case "GET":
                $this->get($cmd, $arrreq);
                break;
            //insert		   
            case "POST":
                $this->post($cmd, $arrreq);
                break;
            //update		   
            case "PUT":
                $this->put($cmd, $arrreq);
                break;
            //delete		   
            case "DELETE":
                $this->delete($cmd, $arrreq);
                break;
            default:
                echo 'error';
        }
    }

    //search
    function get($cmd, $arrreq) {
        session_start();
        include("../common/lib.php");
        include("../lib/class.db.php");
        include("../common/config.php");
        include("lib.php");

       
        switch ($cmd) {
            case "testdata":
					$info["table"] = "test";
					$info["fields"] = array("test.*"); 
					$info["where"]   = "1";
					$arr =  $db->select($info);
					echo json_encode($arr);
                  break;
				  
			case "testediteddata":
					$info["table"] = "test";
					$info["fields"] = array("test.*"); 
					$info["where"]   = "1 And id='".$_REQUEST['id']."'";
					$arr =  $db->select($info);
					echo json_encode($arr);
                  break;	  
            default:
                echo 'Error';
        }
    }

    //update		
    function post($cmd, $arrreq) {
        include("../common/lib.php");
        include("../lib/class.db.php");
        include("../common/config.php");
        include("lib.php");


        switch ($cmd) {
             case "addtestdata":
			    $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request     = json_decode($postdata);					
				}   
	                 unset($info);
					 unset($data);
				$info['table']    = "test";
				$data['col1']     = $request->col1;
				$data['col2']     = $request->col2;
				$data['col3']     = $request->col3;
				$info['data']     =  $data;
				
				if(empty($_REQUEST['id']))
				{
					 $db->insert($info);
					 $id = $db->lastInsert($result);
				}
				else
				{
					$Id            = $_REQUEST['id'];
					$info['where'] = "id=".$Id;
					$db->update($info);
				}
			    ob_start();
				$arr[0]['status'] = 'success';
				$arr[0]['msg'] = 'Data has been saved successfully';
				echo json_encode($arr);
			 break;	
			case "deletetestdata":
			    $postdata = file_get_contents("php://input");
				if (isset($postdata)) {
					$request = json_decode($postdata);
					$Id    	 = $request->id;  				
				}   
				
				$info['table']    = "test";
				$info['where']    = "id='$Id'";
				if($Id)
				{
				  $db->delete($info);
				}
			    ob_start();
				$arr[0]['status'] = 'success';
				$arr[0]['msg'] = 'Data has been deleted successfully';
				echo json_encode($arr);
			  break; 
            default:
                echo 'Error';
        }
    }

    //update		
    function put($cmd, $arrreq) {
        switch ($cmd) {
            case '':

                break;

            default:
                echo 'Error';
        }
    }

    //delete	
    function delete($cmd, $arrreq) {
        session_start();
        include("../common/lib.php");
        include("../lib/class.db.php");
        include("../common/config.php");
        include("lib.php");


        switch ($cmd) {
           

            default:
                echo 'Error';
        }
    }

}

$server = new Server;
$server->serve();

?>