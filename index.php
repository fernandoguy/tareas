<?php

$xidtarea=(isset($_POST['xidtarea']))?$_POST['xidtarea']:"";
$txt_tarea=(isset($_POST['txt_tarea']))?$_POST['txt_tarea']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

$longitudStr=strlen($txt_tarea);
$posicion2p=strpos($txt_tarea,':');
$longitudDef=$longitudStr-$posicion2p;
$idtareas=$xidtarea;
if ($posicion2p==false){
    $posicion2p=0;
    $clases="secondary";
    $definicions=substr($txt_tarea,$posicion2p,$longitudDef);
}else{
    $clases=substr($txt_tarea,0,($posicion2p));
    $definicions=substr($txt_tarea,$posicion2p+1,$longitudDef);
}




include("conexion.php");
switch($accion){ 
    case "btnagregar": 

    if  ($xidtarea==""){

 $sentencia=$pdo->prepare('insert into tarea(definicion,clase) values (:definicions,:clases)');
    $sentencia->bindparam(':definicions',$definicions);
    $sentencia->bindparam(':clases',$clases);

}
else{
 

 
    $sentencia=$pdo->prepare('update tarea set definicion=:definicions,clase=:clases where id_tarea=:idt');
       $sentencia->bindparam(':definicions',$definicions);
       $sentencia->bindparam(':clases',$clases);
       $sentencia->bindparam(':idt',$xidtarea);
   


}
    $sentencia->execute();
    $txt_tarea="";    
    break;
    case "btnborrar":
      echo("a borrar");
      echo $xidtarea;
     $sentencia=$pdo->prepare('delete from tarea where id_tarea=:idt');
     $sentencia->bindparam(':idt',$xidtarea);
    $sentencia->execute();
    $xidtarea="";
    $txt_tarea="";
    break;

}

?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Prueba Tecno.co</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <style type="text/css">
        .conta{
            background-color: #313a3d;
            height: 100%;
            min-height: 99vh
        }

    </style>
</head>

<body>
 <form action="" method="post" name="index">
<div class="container-fluid rounded conta">
    

<div class="row">

    <div class="col">
        <h1><p class="text-white">Bienvenido a tu lista de tareas</p></h1>
  
 <?php
 $sentRead=$pdo->prepare('select * from tarea where 1');
 $sentRead->execute();
 $listaTareas=$sentRead->fetchAll(PDO::FETCH_ASSOC);
// print_r($listaTareas);
 
foreach($listaTareas as $rTarea){
  $clase_descrip=  $rTarea['clase'].":".$rTarea['definicion'];
$iddtarea=$rTarea['id_tarea'];
  $cls="alert alert-".$rTarea['clase'];
 ?>
 
 <form action="" method="post">
<div class="<?php echo($cls); ?>" role="alert">
<table class="table-responsive" border="0px" >
    <tr>
<td  style="width: 100%;">
<button    name="accion" value="btnmodificar" class="<?php echo($cls); ?> btn-block text-left">
 <a type="submit" href="" name="accion" value="btnmodificar"  onclick="this.closest('form').submit();return false;">
<?php 
echo $rTarea['definicion'];

?>

</a>
 <input type="hidden" name="xidtarea" value="<?php echo $iddtarea; ?>">
 <input type="hidden" name="txt_tarea" value="<?php echo $clase_descrip; ?>">
 
 </td>
<td class="align-right">
<button    name="accion" value="btnborrar" class="<?php echo($cls); ?> btn-block text-left">

 <svg  width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="red" xmlns="http://www.w3.org/2000/svg">
 <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
</svg>
</button>
</td>

</tr>
  </table>

</div>
</form>
<?php
}
?>
    </div>

    <div class="col">
        <h1><p class="text-white">Tarea</p></h1>
        
        <input type="hidden" name="xidtarea" id="xidtarea" value="<?php echo $xidtarea; ?>">
        <input  class="form-control form-rounded"  type="text" name="txt_tarea" id="txt_tarea" value="<?php echo $txt_tarea;?>">
        <br>
                <button  name="accion" value="btnagregar" class="btn btn-primary">agregar</button>
                
        
            <div class="alert alert-light" role="alert">
            
            <p>Define las tareas según la importancia con los siguientes items de la descripción</p>
            
            <span class="badge badge-primary">primary</span>
<span class="badge badge-secondary">secondary</span>
<span class="badge badge-success">success</span>
<span class="badge badge-danger">danger</span>
<span class="badge badge-warning">warning</span>
<span class="badge badge-info">info</span>
<span class="badge badge-light">light</span>
<span class="badge badge-dark">dark</span>
            </div>
        
    
    </div>
</div>


    
</div>
</form>
</body>
</html>