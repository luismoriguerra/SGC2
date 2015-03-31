<?php

class servletEquivalencia extends controladorComandos {

  public function doPost() {
    $daoEquivalencia = creadorDAO::getEquivalenciaDAO();
    switch ($_POST['action']):

      case 'cargarCarreras':
        $post = array();
        $post = (trim($_POST['cinstit']));

        echo json_encode($daoEquivalencia->cargarCarreras($post));
        break;
      case 'cargarModulos':
        $post = array();
        $post = (trim($_POST['ccarrer']));

        echo json_encode($daoEquivalencia->cargarModulos($post));
        break;
      case 'cargarCursos':
        $post = array();
        $post["cmodulo"] = (trim($_POST['cmodulo']));
        $post["ccurric"] = (trim($_POST['ccurric']));

        echo json_encode($daoEquivalencia->cargarCursos($post));
        break;
      case 'cargarCurriculas':
        $post = array();
        $post["cinstit"] = (trim($_POST['cinstit']));
        $post["ccarrer"] = (trim($_POST['ccarrer']));

        echo json_encode($daoEquivalencia->cargarCurriculas($post));
        break;
      case 'addEquivalencia':
        //$post = array();
        $post = $_POST['post'];
        //$post["ccarrer"] = (trim($_POST['ccarrer']));

        echo json_encode($daoEquivalencia->addEquivalencia($post));
        break;
      case 'EditarEquivalencia':
        //$post = array();
        $post = $_POST['post'];
        //$post["ccarrer"] = (trim($_POST['ccarrer']));

        echo json_encode($daoEquivalencia->EditarEquivalencia($post));
        break;
      case 'GetInstitucionyCarrera':
        //$post = array();
        $post = $_POST['ccurric'];
        //$post["ccarrer"] = (trim($_POST['ccarrer']));

        echo json_encode($daoEquivalencia->GetInstitucionyCarrera($post));
        break;
      case 'EliminarEquivalencia':
        //$post = array();
        $post = $_POST['post'];
        //$post["ccarrer"] = (trim($_POST['ccarrer']));

        echo json_encode($daoEquivalencia->EliminarEquivalencia($post));
        break;
      default:
        echo json_encode(array('rst' => 3, 'msg' => 'Action no encontrado1'));
    endswitch;
  }

  public function doGet() {
    $daoEquivalencia = creadorDAO::getEquivalenciaDAO();
    switch ($_GET['action']):
      case 'jqgrid_equivalencia':
        $page = $_GET["page"];
        $limit = $_GET["rows"];
        $sidx = $_GET["sidx"];
        $sord = $_GET["sord"];

        $where = "";
        $param = array();
        $having = "";
        $fields = "";
        if (isset($_GET['dtitulo'])) {
          if (trim($_GET['dtitulo']) != '') {
            $having.=" AND c.dtitulo LIKE '%" . trim($_GET['dtitulo']) . "%' ";
            $fields .= " ,c.dtitulo "; 
          }
        }

        if (isset($_GET['dciclo'])) {
          if (trim($_GET['dciclo']) != '') {
            $having.=" AND m.dmodulo like '%" . trim($_GET['dciclo']) . "%' ";
            $fields .= ' , m.dmodulo ';
          }
        }

        if (isset($_GET['dcurso'])) {
          if (trim($_GET['dcurso']) != '') {
            $having.=" AND cu.dcurso like '%" . trim($_GET['dcurso']) . "%' ";
            $fields .= ' , cu.dcurso ';

          }
        }
        
        if (isset($_GET['titulos'])) {
          if (trim($_GET['titulos']) != '') {
            $having.=" AND titulos LIKE '%" . trim($_GET['titulos']) . "%' ";
            $fields .=  " , GROUP_CONCAT(  CONCAT_WS('   ',ca.dtitulo, ma.dmodulo , cua.dcurso )  SEPARATOR '<br>') titulos ";

          }
        }

       
        
        if (isset($_GET['estide'])) {
          if (trim($_GET['estide']) != '') {
            $having.=" AND cestide = '" . trim($_GET['estide']) . "' ";
            $fields .= ' , estide cestide';

          }
        }
        
        
        if (!$sidx)
          $sidx = 1;

        $row = $daoEquivalencia->JQGridCountEquivalencia($where,$having,$fields);
        $count = $row[0]['count'];
        if ($count > 0) {
          $total_pages = ceil($count / $limit);
        } else {
          $limit = 0;
          $total_pages = 0;
        }

        if ($page > $total_pages)
          $page = $total_pages;

        $start = $page * $limit - $limit;

        $response = array("page" => $page, "total" => $total_pages, "records" => $count);
        $data = $daoEquivalencia->JQGRIDRowsEquivalencia($sidx, $sord, $start, $limit, $where, $having,$fields);
        $dataRow = array();
        for ($i = 0; $i < count($data); $i++) {

          /*
e.cequisag,
c.ccurric,
c.dtitulo,
cu.ccurso,
cu.dcurso,
m.cmodulo cciclo,
m.dmodulo dciclo,
GROUP_CONCAT(  CONCAT_WS('~',ca.ccurric, ma.cmodulo , cua.ccurso )  SEPARATOR ',') codigos ,
GROUP_CONCAT(  CONCAT_WS('~',ca.dtitulo, ma.dmodulo , cua.dcurso )  SEPARATOR '<br>') titulos,
e.gruequi grupo,
IF(estide = 'r','Regular','Irregular') estide,
estide cestide,
car.cinstit inst,
car.ccarrer carrer

          */
          array_push($dataRow, array("id" => $data[$i]['grupo'], "cell" => array(
                  $data[$i]['dtitulo'],
                  $data[$i]['ccurric'],
                  $data[$i]['dciclo'],
                  $data[$i]['cciclo'],
                  $data[$i]['dcurso'],
                  $data[$i]['ccurso'],
                  $data[$i]['titulos'],
                  $data[$i]['codigos'],
                  $data[$i]['estide'],
                  $data[$i]['cestide'],
                  $data[$i]['inst'],
                  $data[$i]['carrer'],
                  $data[$i]['grupo'],
                  $data[$i]['dactas'],
              )
                  )
          );
        }
        $response["rows"] = $dataRow;
        echo json_encode($response);
        break;
      default:
        echo json_encode(array('rst' => 3, 'msg' => 'Action no encontrado'));
    endswitch;
  }

}

?>
