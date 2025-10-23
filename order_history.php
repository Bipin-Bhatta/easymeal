<?php
include ("header.php");

if(!isset($_SESSION['FOOD_USER_ID'])){
	redirect(FRONT_SITE_PATH.'shop');
}
$uid=$_SESSION['FOOD_USER_ID'];
if(isset($_GET['cancel_id'])){
	$cancel_id=get_safe_value($_GET['cancel_id']);
	$cancel_at=date('Y-m-d h:i:s');
	mysqli_query($con,"update order_master set order_status='5',cancel_by='user',cancel_at='$cancel_at'
	where id='$cancel_id' and order_status='1' and user_id='$uid'");
}
$sql="select order_master.*,order_status.order_status as order_status_str,payment_status.payment_status as payment_status_str 
from order_master,order_status,payment_status 
where order_master.order_status=order_status.id and order_master.payment_status=payment_status.id and order_master.user_id='$uid' order by order_master.id desc";
$res=mysqli_query($con,$sql);

?>

<div class="cart-main-area pt-95 pb-100">
    <div class="container">
        <h3 class="page-title">Order History</h3>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <form method="post">
                    <div class="table-content table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Order No</th>
                                    <th>Price</th>
                                    <th>Address</th>
                                    <th>Order Status</th>
                                    <th>Payment Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(mysqli_num_rows($res)>0){
										$i=1;
										while($row=mysqli_fetch_assoc($res)){
										?>
                                <tr>
                                    <td>
                                        <div style="background-color: #0000FF;
												text-align:center;
												width:50px;
												margin-left:35%;
												height:30px;
												padding:5px;">
                                            <a style="color:#FFFF;"
                                                href="<?php echo FRONT_SITE_PATH.'order_detail?id='.$row['id']?>">
                                                <?php echo $row['id']?></a>
                                        </div>
                                        <br />
                                        <a href="<?php echo FRONT_SITE_PATH?>
											download_invoice?id=<?php echo $row['id']?>">
                                            <img src='<?php echo FRONT_SITE_PATH?>
											assets/img/icon-img/pdf.png' style="margin-top:-20px; width:50px; height:30px;"
                                                title="Download Invoice" /></a>
                                    </td>
                                    <td><?php echo $row['total_price']?></td>
                                    <td><?php echo $row['address']?>

                                    <td><?php 
											echo $row['order_status_str'];
											/*if($row['order_status']==1){
												echo "<br/>";
											    echo "<a href='?cancel_id=".$row['id']."'>Cancel</a>";
											}*/
											?>
                                    </td>
                                    <td>
                                        <div
                                            class="payment_status_str payment_status_str_<?php echo $row['payment_status_str']?>">
                                            <?php echo ucfirst($row['payment_status_str'])?></div>
                                    </td>
                                    <td><?php 
											
											if($row['order_status']==1){
												echo "<br/>";
											    echo "<a href='?cancel_id=".$row['id']."' class='cancel_btn'>Cancel</a>";
											}
											?>
                                    </td>
                                </tr>
                                <?php }} ?>
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