<?php include 'admin/db_connect.php' ?>
<?php
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM forum_comments where id=".$_GET['id'])->fetch_array();
	foreach($qry as $k =>$v){
		$$k = $v;
	}
}

?>
<div class="container-fluid">
	<form action="" id="update-comment">
				<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id']:'' ?>" class="form-control">
		<div class="row form-group">
			<div class="col-md-12">
				<label class="control-label">Comment</label>
				<textarea name="comment" class="text-jqte"><?php echo isset($comment) ? $comment : '' ?></textarea>
			</div>
		</div>
	</form>
</div>

<script>
	$('.text-jqte').jqte();
	$('#update-comment').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'admin/ajax.php?action=save_comment',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp == 1){
					alert_toast("Data successfully saved.",'success')
					setTimeout(function(){
						location.reload()
					},1000)
				}
			}
		})
	})
	$('.delete_comment').click(function(){
		_conf("Are you sure to delete this comment?","delete_comment",[$(this).attr('data-id')],'mid-large')
	})

	function delete_comment($id){
		start_load()
		$.ajax({
			url:'admin/ajax.php?action=delete_comment',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>