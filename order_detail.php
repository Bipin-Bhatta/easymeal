<?php
include ("header.php");
if(!isset($_SESSION['FOOD_USER_ID'])){
	redirect(FRONT_SITE_PATH.'shop');
}

if(isset($_GET['id']) && $_GET['id']>0){
	$id=get_safe_value($_GET['id']);
	$getOrderById=getOrderById($id);
	if($getOrderById[0]['user_id']!=$_SESSION['FOOD_USER_ID']){
		redirect(FRONT_SITE_PATH.'shop');
	}
}else{
	redirect(FRONT_SITE_PATH.'shop');
}

$uid=$_SESSION['FOOD_USER_ID'];

?>

<div class="cart-main-area pt-95 pb-100">
    <div class="container">
        <h3 class="page-title">Order Detail</h3>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <form method="post">
                    <div class="table-content">
                        <table style="border:1px solid #e9e8ef;">
                            <thead>
                                <tr>
                                    <th width="5%">S.n</th>
                                    <th width="20%">Name</th>
                                    <th width="5%">Attribute</th>
                                    <th width="10%">Image</th>
                                    <th width="10%">Unit Price(Rs)</th>
                                    <th width="5%">Quantity</th>
                                    <th width="10%">Total Price(Rs)</th>
                                    <th width="15%">Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
											     $i=1;
													$getOrderDetails=getOrderDetails($id);
												$pp=0;
												foreach($getOrderDetails as $list){
													$pp=$pp+($list['qty']*$list['price']);
													?>
                                <tr>
                                    <td><?php echo $i?></td>
                                    <td><?php echo $list['dish']?></td>
                                    <td><?php echo $list['attribute']?></td>
                                    <td><a target="_blank" href="<?php echo SITE_DISH_IMAGE.$list['image']?>">
                                            <img style="width:30%;"
                                                src="<?php echo SITE_DISH_IMAGE.$list['image']?>" /></a></td>
                                    <td><?php echo $list['price']?></td>
                                    <td><?php echo $list['qty']?></td>
                                    <td><?php echo $list['qty']*$list['price']?></td>
                                    <td id="rating<?php echo $list['dish_details_id']?>">
                                        <?php
															if($getOrderById[0]['order_status']==4){ 
															echo getRating($list['dish_details_id'],$id);
															}
															?>
                                    </td>
                                </tr>
                                <?php 
						                                  $i++;
								                                }
															   ?>
                                <tr>
                                    <td colspan="6"></td>
                                    <td><strong>Total Price:</strong></td>
                                    <td><strong><?php echo 'Rs.'.$pp?></strong></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include("footer.php");
?>