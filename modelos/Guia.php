<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class Guia
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
    //Implementamos un método para insertar registros
    public function insertar($idcliente,$idusuario,$num_guia,$fecha_emision,$fecha_traslado,$domi_partida,$domi_llegada,$marca_placa,$certi_inscripcion,$lic_conducir,$rason_transportista,$ruc_transportista,$doc_pago,$num_doc_pago,$motivo_traslado,$idarticulo,$cantidad,$peso_bulto)
    {
        $sql="INSERT INTO guia_remision (idcliente,idusuario,num_guia,fecha_emision,fecha_traslado,domi_partida,domi_llegada,marca_placa,certi_inscripcion,lic_conducir,rason_transportista,ruc_transportista,doc_pago,num_doc_pago,motivo_traslado,estado)
        VALUES ('$idcliente','$idusuario','$num_guia','$fecha_emision','$fecha_traslado','$domi_partida','$domi_llegada','$marca_placa','$certi_inscripcion','$lic_conducir','$rason_transportista','$ruc_transportista','$doc_pago','$num_doc_pago','$motivo_traslado','Generado')";
        //return ejecutarConsulta($sql);
        $idguianew=ejecutarConsulta_retornarID($sql);
 
        $num_elementos=0;
        $sw=true;
 
        while ($num_elementos < count($idarticulo))
        {
            $sql_detalle = "INSERT INTO detalle_guia(idguia, idarticulo,cantidad,peso_bulto) VALUES ('$idguianew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$peso_bulto[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
        }
 
        return $sw;
    }
 
     
    //Implementamos un método para anular la venta
    public function anular($idguia)
    {
        $sql="UPDATE guia_remision SET estado='Anulado' WHERE idguia='$idguia'";
        return ejecutarConsulta($sql);
    }
 
 
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idguia)
    {
        $sql="SELECT g.idguia,DATE(g.fecha_emision) as emision,DATE(g.fecha_traslado) as traslado,g.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,g.num_guia,g.doc_pago,g.num_doc_pago,g.domi_partida as partida,g.marca_placa,g.domi_llegada as llegada,g.certi_inscripcion,g.lic_conducir,g.rason_transportista,g.ruc_transportista,g.motivo_traslado,g.estado FROM guia_remision g INNER JOIN persona p ON g.idcliente=p.idpersona INNER JOIN usuario u ON g.idusuario=u.idusuario WHERE g.idguia='$idguia'";
        return ejecutarConsultaSimpleFila($sql);
    }
 
    public function listarDetalle($idguia)
    {
        $sql="SELECT dg.idguia,dg.idarticulo,a.codigo,a.nombre,dg.cantidad,a.medida, (dg.cantidad*dg.peso_bulto) as peso_total FROM detalle_guia dg inner join articulo a on dg.idarticulo=a.idarticulo where dg.idguia='$idguia'";
        return ejecutarConsulta($sql);
    }
 
    //Implementar un método para listar los registros
    public function listar()
    {
        $sql="SELECT g.idguia,DATE(g.fecha_emision) as emision,DATE(g.fecha_traslado) as traslado,g.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,g.num_guia,g.doc_pago,g.num_doc_pago,g.motivo_traslado,g.estado FROM guia_remision g INNER JOIN persona p ON g.idcliente=p.idpersona INNER JOIN usuario u ON g.idusuario=u.idusuario ORDER by g.idguia desc";
        return ejecutarConsulta($sql);      
    }
     
}
?>