<?php
include 'conexion.php';
function get_result( $stmt ) {
    $arrResult = array();
    $stmt->store_result();
    for ( $i = 0; $i < $stmt->num_rows; $i++ ) {
        $metadata = $stmt->result_metadata();
        $arrParams = array();
        while ( $field = $metadata->fetch_field() ) {
            $arrParams[] = &$arrResult[ $i ][ $field->name ];
        }
        call_user_func_array( array( $stmt, 'bind_result' ), $arrParams );
        $stmt->fetch();
    }
    return $arrResult; 
}
$usu_usuario=$_POST['usuario'];
$usu_password=$_POST['password'];

//$usu_usuario="juanpg@gmail.com";
//$usu_password="0123456789";

$sentencia=$conexion->prepare("SELECT * FROM usuario WHERE usu_usuario=? AND usu_password=?");
$sentencia->bind_param('ss', $usu_usuario, $usu_password);
$sentencia->execute();

$resultado = $sentencia->get_result();
if ($fila = $resultado->fetch_assoc()) {
         echo json_encode($fila,JSON_UNESCAPED_UNICODE);     
}
$sentencia->close();
$conexion->close();
?>