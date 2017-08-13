<?php
session_start();
?>
        <?php
		require('dbconfig.php');
		if(!isset($_GET['id']))
			die("Ooops!");
		$entryId = $_GET['id'];
		$designation = $_GET['d'];
		$q = "select * from entry as En,event as Ev,user as u
		where En.event_id=Ev.event_id and En.uploader_id=u.id and En.entry_id='$entryId'";
		$res = mysqli_query($con,$q) or die("querry failed!");
		$row = mysqli_fetch_assoc($res);
		?>
        
		<div class="panel panel-info">
		  <div class="panel-heading">
		  
			<div class="text-left"><?php echo $row['event_name']; ?></div>
			<strong class="text-danger">Result: </strong>
			<code><?php echo $designation; ?></code>
			
			<div class="text-right"><img src="<?php echo $row['dp']; ?>" style="height:30px;width:30px;"> <?php echo $row['name']; ?></div>
		  </div>
		  <div class="panel-body">
		  <div class="row">
			<?php 
			if($row['file_type']=='jpg'){
				$url = 'entry/'.$row['event_name'].'/'.$row['entry_id'].'.jpg';
				$durl = $url;
			}else{
				$url = 'pdf_default.jpg';
				$durl = 'entry/'.$row['event_name'].'/'.$row['entry_id'].'.pdf';
			}
			?>
			<div class="col-md-8">
		  <img src="<?php echo $url; ?>"  class="img-responsive img-rounded" alt="Cinque Terre">
		  </div>
		  <div class="col-md-4">
		  <blockquote>
			<p><?php echo $row['caption']; ?></p>
			
		  </blockquote>
		  </div>
			
			
		  </div>
		  </div>
		  <div class="panel-footer">
		  
		  <div class="row">
		  <div class="col-md-6">
		  <!--<div class="btn-group">-->
		  <!--<button type="button" id="like-<?php echo $entryId; ?>" class="btn btn-default" data-l="<?php echo $entryId; ?>"><span class="glyphicon glyphicon-print"></span></button>
		  <button type="button"  id="love-<?php echo $entryId; ?>" class="btn btn-default" data-l="<?php echo $entryId; ?>"><span class="glyphicon glyphicon-print"></span></button>
		  <button type="button"  id="dislike-<?php echo $entryId; ?>" class="btn btn-default" data-l="<?php echo $entryId; ?>"><span class="glyphicon glyphicon-print"></span></button>-->
		  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#comment<?php echo $entryId; ?>"><span class="glyphicon glyphicon-comment"></span></button>
		<!--</div>-->
		</div>
		<div class="col-md-6">
		<div class="text-right" >
		  <button type="button" class="btn btn-default"><a href="<?php echo $durl; ?>" target="_blank" >Download Post</a></button>
		  <button type="button" class="btn btn-default" data-toggle="modal" data-target="#postStats<?php echo $entryId?>">Post Stats</button>
		  <button type="button" class="btn btn-default"><a href="loadSingleResult.php?id=<?php echo $row['entry_id']; ?>&d=<?php echo $designation; ?>" target="_blank" >Get Sharable Link</a></button>
		  
		</div>
		</div>
		 <br>
		 <div id=""></div>
		 </div>
		  </div>
		</div>
		<script>
	$(document).ready(function(){
    $("#like-<?php echo $entryId; ?>").click(function(){
		//alert('fd');
		var v = $(this).attr('data-l'); 
        $.post("process_rxn.php",
        {
          name: v,
          rxn: 'like'
        },
        function(data,status){
          
		   // alert("Data: " + data + "\nStatus: " + status);
        });
    });
});
$(document).ready(function(){
    $("#love-<?php echo $entryId; ?>").click(function(){
		//alert('fd');
		var v = $(this).attr('data-l'); 
        $.post("process_rxn.php",
        {
          name: v,
          rxn: 'love'
        },
        function(data,status){
          
		   // alert("Data: " + data + "\nStatus: " + status);
        });
    });
});	
$(document).ready(function(){
    $("#dislike-<?php echo $entryId; ?>").click(function(){
		//alert('fd');
		var v = $(this).attr('data-l'); 
        $.post("process_rxn.php",
        {
          name: v,
          rxn: 'dislike'
        },
        function(data,status){
          
		   // alert("Data: " + data + "\nStatus: " + status);
        });
    });
	$("#like-<?php echo $entryId; ?>").click(function(){
		$att = $("#like-<?php echo $entryId; ?>").attr('class');
		if($att=='btn btn-default'){
			$("#like-<?php echo $entryId; ?>").attr('class', 'btn btn-danger');
			$("#dislike-<?php echo $entryId; ?>").attr('class', 'btn btn-default');
			$("#love-<?php echo $entryId; ?>").attr('class', 'btn btn-default');
		}
		else{
			$("#like-<?php echo $entryId; ?>").attr('class', 'btn btn-default');
		}
	});
$("#dislike-<?php echo $entryId; ?>").click(function(){
		$att = $("#dislike-<?php echo $entryId; ?>").attr('class');
		if($att=='btn btn-default'){
			$("#dislike-<?php echo $entryId; ?>").attr('class', 'btn btn-danger');
			$("#like-<?php echo $entryId; ?>").attr('class', 'btn btn-default');
			$("#love-<?php echo $entryId; ?>").attr('class', 'btn btn-default');
		}
		else
			$("#dislike-<?php echo $entryId; ?>").attr('class', 'btn btn-default');
	});	
$("#love-<?php echo $entryId; ?>").click(function(){
		$att = $("#love-<?php echo $entryId; ?>").attr('class');
		if($att=='btn btn-default'){
			$("#love-<?php echo $entryId; ?>").attr('class', 'btn btn-danger');
			$("#like-<?php echo $entryId; ?>").attr('class', 'btn btn-default');
			$("#dislike-<?php echo $entryId; ?>").attr('class', 'btn btn-default');
		}
		else
			$("#love-<?php echo $entryId; ?>").attr('class', 'btn btn-default');
	});		
	<?php 
	$uId = $_SESSION['user_id'];
	$querry = "select * from rxn where user_id='$uId'";
	//$file = fopen("w.txt","a");
	
	$res = mysqli_query($con,$querry) or die("querry failed!");
	
	while($row1 = mysqli_fetch_assoc($res)){
		
		$enId = $row1['entry_id'];
		$rtype = $row1['rxn_type'];
		$var = $rtype.'-'.$enId;
		//fwrite($file,$var."\n");
		?>	
		//$("#<?php echo $var; ?>").toggleClass('D'); 
		//$("#<?php echo $var; ?>").removeClass("btn btn-danger");
        //    $("#<?php echo $var; ?>").addClass("buttonClassB");
		//$(this).toggleClass('buttonClassB');
		$("#<?php echo $var; ?>").attr('class', 'btn btn-danger');
		<?php
	}
	?>
});		
</script>
	
	
	
<!-- Modal -->
<div id="postStats<?php echo $entryId?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Post Stats!</h4>
      </div>
      <div class="modal-body">
        
		
		<div>
				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#rxn1<?php echo $entryId?>" aria-controls="home" role="tab" data-toggle="tab">Like</a></li>
					<li role="presentation" ><a href="#rxn2<?php echo $entryId?>" aria-controls="home" role="tab" data-toggle="tab">Love</a></li>
					<li role="presentation" ><a href="#rxn3<?php echo $entryId?>" aria-controls="home" role="tab" data-toggle="tab">Dislike</a></li>
				  </ul>
				  <!-- Tab panes -->
				  <div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="rxn1<?php echo $entryId?>" >
						<br>
						<table class="table">
						<thead>
						  <tr>
						  <?php $q11 = "select * from rxn ,user where user_id=id and rxn_type='like' and entry_id = '$entryId'";
						$res11 = mysqli_query($con,$q11) or die("querry failed!");
						  ?>
							<th>These many have reacted this way! <kbd><?php echo mysqli_num_rows($res11); ?></kbd> to be precise :P</th>
						  </tr>
						</thead>
						<tbody>
						<?php 
						
						while($row11 = mysqli_fetch_assoc($res11)){
						?>
						
						  <tr>
							<td class="text-primary"><img src="<?php echo $row11['dp']; ?>" width="30" height="30"> <?php echo $row11['name']; ?></td>
							
						  </tr>
						  <?php
						}
						  ?>
						</tbody>
					  </table>
						
						
					</div>
					<div role="tabpanel" class="tab-pane" id="rxn2<?php echo $entryId?>" >
						<br>
						<table class="table">
						<thead>
						  <tr>
						  <?php
						  $q11 = "select * from rxn ,user where user_id=id and rxn_type='love' and entry_id = '$entryId'";
						$res11 = mysqli_query($con,$q11) or die("querry failed!");
						  ?>
							<th>These many have reacted this way! <kbd><?php echo mysqli_num_rows($res11); ?></kbd> to be precise :P</th>
						  </tr>
						</thead>
						<tbody>
						<?php 
						
						
						while($row11 = mysqli_fetch_assoc($res11)){
						?>
						
						  <tr>
							<td class="text-primary"><img src="<?php echo $row11['dp']; ?>" width="30" height="30"> <?php echo $row11['name']; ?></td>
							
						  </tr>
						  <?php
						}
						  ?>
						</tbody>
					  </table>
						
						
					</div>
					<div role="tabpanel" class="tab-pane" id="rxn3<?php echo $entryId?>" >
						<br>
						<table class="table">
						<thead>
						  <tr>
						  <?php $q11 = "select * from rxn ,user where user_id=id and rxn_type='dislike' and entry_id = '$entryId'";
						$res11 = mysqli_query($con,$q11) or die("querry failed!"); ?>
							<th>These many have reacted this way! <kbd><?php echo mysqli_num_rows($res11); ?></kbd> to be precise :P</th>
						  </tr>
						</thead>
						<tbody>
						<?php 
						
						
						while($row11 = mysqli_fetch_assoc($res11)){
						?>
						
						  <tr>
							<td class="text-primary"><img src="<?php echo $row11['dp']; ?>" width="30" height="30"> <?php echo $row11['name']; ?></td>
							
						  </tr>
						  <?php
						}
						  ?>
						</tbody>
					  </table>
						
						
					</div>
					
				  </div>

				</div>
		
		
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
  
</div>

  <!-- Modal -->
<div id="comment<?php echo $entryId; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Comments on this Post</h4>
      </div>
      <div class="modal-body">
        <form action="process_cmnt.php" method="POST">
		  <input type="hidden" class="form-control" name="eid" value="<?php echo $entryId; ?>">
		  <input type="hidden" class="form-control" name="uid" value="<?php echo $uId; ?>">
		  <div class="form-group">
			<label for="email">Enter Your Comment:</label>
			<input type="text" class="form-control" name="cmnt" required>
		  </div>
		  <button type="submit" class="btn btn-danger" name="csubmit" >Add Comment</button>
		</form>
		
		<table class="table">
						<thead>
						  <tr>
						  <?php
						  $q11 = "select * from comment ,user where user_cid=id and entry_cid = '$entryId'";
						$res11 = mysqli_query($con,$q11) or die("querry failed!");
						  ?>
							<th></th>
						  </tr>
						</thead>
						<tbody>
						<?php 
						
						
						while($row11 = mysqli_fetch_assoc($res11)){
						?>
						
						  <tr>
							<td class="text-muted"><img src="<?php echo $row11['dp']; ?>" width="30" height="30"> <strong class="text-primary"><?php echo $row11['name']; ?></strong>: <strong><?php echo $row11['cmnt']; ?></strong>
							
							<?php 
							//echo trim($row11['user_cid'])-trim($_SESSION["user_id"]);
							if(trim($row11['user_cid'])==trim($_SESSION["user_id"])) {
								
							?>
							<form action="process_cmnt.php" method="POST">
							<input type="hidden" name="duid" value="<?php echo $row11['user_cid']; ?>">
							<input type="hidden" name="deid" value="<?php echo $row11['entry_cid']; ?>">
							<input type="hidden" name="dcmnt" value="<?php echo $row11['cmnt']; ?>">
							<button type="submit" style="float:right;" class="btn btn-link" name="cdel" >Delete</button>
							</form>
							<?php } ?>
							</td>
						  </tr>
						  <?php
						}
						  ?>
						</tbody>
					  </table>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>