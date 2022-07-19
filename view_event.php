<?php include 'admin/db_connect.php' ?>
<?php
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM events where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
	$$k=$val;
}
$commits = $conn->query("SELECT * FROM event_commits where event_id = $id");
$cids= array();
while($row = $commits->fetch_assoc()){
	$cids[] = $row['user_id'];
}
}
?>
<style type="text/css">
	.imgs{
		margin: .5em;
		max-width: calc(100%);
		max-height: calc(100%);
	}
	.imgs img{
		max-width: calc(100%);
		max-height: calc(100%);
		cursor: pointer;
	}
	#imagesCarousel,#imagesCarousel .carousel-inner,#imagesCarousel .carousel-item{
		height: 40vh !important;background: black;

	}
	#imagesCarousel{
		margin-left:unset !important ;
	}
	#imagesCarousel .carousel-item.active{
		display: flex !important;
	}
	#imagesCarousel .carousel-item-next{
		display: flex !important;
	}
	#imagesCarousel .carousel-item img{
		margin: auto;
		margin-top: unset;
		margin-bottom: unset;
	}
	#imagesCarousel img{
		width: calc(100%)!important;
		height: auto!important;
		/*max-height: calc(100%)!important;*/
		max-width: calc(100%)!important;
		cursor :pointer;
	}
	#banner{
		display: flex;
		justify-content: center;
	}
	#banner img{
		max-width: calc(100%);
		max-height: 50vh;
		cursor :pointer;
	}
	<?php if(!empty($banner)): ?>
	 header.masthead {
	    background: url(admin/assets/uploads/<?php echo $banner ?>);
	    background-repeat: no-repeat;
	    background-size: cover;
	}
	<?php endif; ?>
</style>
<header class="masthead">
	<div class="container-fluid h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-4 align-self-end mb-4 pt-2 page-title">
                    	<h4 class="text-center text-white"><b><?php echo ucwords($title) ?></b></h4>
                        <hr class="divider my-4" />
                     
                    </div>
                    
                </div>
            </div>
</header>
<section></section>
<div class="container">
	<div class="col-lg-12">
		<div class="card mt-4 mb-4">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						
					</div>
					<div class="col-md-12" id="content">
					<p class="">
						
						<p><b><i class="fa fa-calendar"></i> <?php echo date("F d, Y h:i A",strtotime($schedule)) ?></b></p>
						<?php echo html_entity_decode($content); ?>
					</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<hr class="divider" style="max-width: calc(100%);"/>
						<div class="text-center">
							<?php if(isset($_SESSION['login_id'])): ?>
							<?php if(in_array($_SESSION['login_id'], $cids)): ?>
								<span class="badge badge-primary">Commited to Participate</span>
							<?php else: ?>
								<button class="btn btn-primary" id="participate" type="button">Participate</button>
							<?php endif; ?>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#imagesCarousel img,#banner img').click(function(){
		viewer_modal($(this).attr('src'))
	})
	$('#participate').click(function(){
        _conf("Are you sure to commit that you will participate to this event?","participate",[<?php echo $id ?>],'mid-large')
    })

    function participate($id){
        start_load()
        $.ajax({
            url:'admin/ajax.php?action=participate',
            method:'POST',
            data:{event_id:$id},
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
