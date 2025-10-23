<?php 
include("header.php");
$cartArr=getUserFullCart();
if($website_close==1){
    redirect(FRONT_SITE_PATH.'shop');
}
if(count($cartArr)>0){
	
}else{
	redirect(FRONT_SITE_PATH.'shop');
}
if(isset($_SESSION['FOOD_USER_ID'])){
	$is_show='';
	$box_id='';
	$final_show='show';
	$final_box_id='payment-2';
}else{
	$is_show='show';
	$box_id='payment-1';
	$final_show='';
	$final_box_id='';
}
$userArr=getUserDetailsById();
$is_error='';
if(isset($_POST['place_order'])){
  if($cart_min_price!=''){
      if($totalPrice>=$cart_min_price){

      }else{
        $is_error='yes';
      }
  }
  if( $is_error==''){
        $checkout_name=get_safe_value($_POST['checkout_name']);
        $checkout_email=get_safe_value($_POST['checkout_email']);
        $checkout_mobile=get_safe_value($_POST['checkout_mobile']);
        $checkout_address=get_safe_value($_POST['checkout_address']);
       // $payment_type=get_safe_value($_POST['payment_type']);
        $added_on=date('Y-m-d h:i:s');
        $sql="insert into order_master(user_id,name,email,mobile,address,total_price,order_status,payment_status,added_on) 
        values('".$_SESSION['FOOD_USER_ID']."','$checkout_name','$checkout_email',
        '$checkout_mobile','$checkout_address','$totalPrice','1','1','$added_on')";
    
        mysqli_query($con,$sql);
        $insert_id=mysqli_insert_id($con);
        $_SESSION['ORDER_ID']=$insert_id;
        foreach($cartArr as $key=>$val){
            mysqli_query($con,"insert into order_details(order_id,dish_details_id,price,qty) values('$insert_id','$key','".$val['price']."','".$val['qty']."')");
        }
        emptyCart();
        $getUserDetailsBy=getUserDetailsByid();
        $email=$getUserDetailsBy['email'];
        $emailHTML=orderEmail($insert_id);
        include('smtp/PHPMailerAutoload.php');
        send_email($email,$emailHTML,'Order Placed');
        redirect(FRONT_SITE_PATH.'success');
    }	
}
?>
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?php echo FRONT_SITE_PATH?>shop">Home</a></li>
                <li class="active"> Checkout </li>
            </ul>
        </div>
    </div>
</div>
<div class="checkout-area pb-80 pt-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="checkout-wrapper">
                    <div id="faq" class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>1.</span> <a data-toggle="collapse" data-parent="#faq"
                                        href="#payment-1">Checkout method</a></h5>
                            </div>
                            <div id="<?php echo $box_id?>" class="panel-collapse collapse 
                                    <?php echo $is_show?>">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="checkout-login">
                                                <div class="title-wrap">
                                                    <h4 class="cart-bottom-title section-bg-white">LOGIN</h4>
                                                </div>
                                                <p>&nbsp;</p>
                                                <form method="post" id="frmLogin">
                                                    <div class="login-form">
                                                        <label>Email Address * </label>
                                                        <input type="email" name="user_email" placeholder="Email"
                                                            required>
                                                    </div>
                                                    <div class="login-form">
                                                        <label>Password *</label>
                                                        <input type="password" name="user_password"
                                                            placeholder="Password" required>
                                                        <input type="hidden" name="type" value="login" />
                                                        <input type="hidden" name="is_checkout" value="yes"
                                                            id="is_checkout" />
                                                    </div>

                                                    <div class="checkout-login-btn">
                                                        <button type="submit" id="login_submit"
                                                            class="my_btn">Login</button>
                                                        <a href="<?php echo FRONT_SITE_PATH?>login_register"
                                                            style="background-color: #e02c2b;color:#fff;">Register
                                                            Now</a>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>2.</span> <a data-toggle="collapse" data-parent="#faq"
                                        href="#payment-2">Other information</a></h5>
                            </div>
                            <div id="<?php echo $final_box_id?>" class="panel-collapse collapse 
                                    <?php echo $final_show?>">
                                <div class="panel-body">
                                    <form method="post">
                                        <div class="billing-information-wrapper">
                                            <div class="row">
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Full Name</label>
                                                        <input type="text" name="checkout_name"
                                                            value="<?php echo $userArr['name']?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Email Address</label>
                                                        <input type="email" name="checkout_email"
                                                            value="<?php echo $userArr['email']?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Mobile</label>
                                                        <input type="text" name="checkout_mobile"
                                                            value="<?php echo $userArr['mobile']?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Address</label>
                                                        <input type="text" name="checkout_address" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ship-wrapper">
                                                <div class="single-ship">
                                                    <input type="radio" name="payment_type" value="cod"
                                                        checked="checked">
                                                    <label>Cash on Delivery(COD)</label>
                                                </div>
                                            </div>
                                            <div class="billing-back-btn">
                                                <div class="billing-btn">
                                                    <button type="submit" name="place_order">Place Your Order</button>
                                                </div>
                                            </div>
                                            <?php 
                                                        if($is_error=='yes'){
                                                            echo '<div style="text-align: center; font-size: 30px; color: #FFFF; margin-top:20px; margin-bottom: -50px; background-color:red;">';
                                                            echo $cart_min_price_msg;
                                                            echo '</div>';
                                                        }
                                                        ?>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="checkout-progress">
                    <div class="shopping-cart-content-box">
                        <h4 class="checkout_title">Cart Details</h4>
                        <ul>
                            <?php
                                        foreach($cartArr as $key=>$list){ ?>
                            <li class="single-shopping-cart" id="attr_<?php echo $key?>">
                                <div class="shopping-cart-delete">
                                    <a href="javascript:void(0)" onclick="delete_cart('<?php echo $key?>')"><i
                                            class="fa fa-trash" aria-hidden="true" style="color: red;"></i></a>
                                </div>
                                <div class="shopping-cart-img">
                                    <a href="javascript:void(0)"><img src="<?php echo
                                                    SITE_DISH_IMAGE.$list['image']?>" alt="" style="width: 35%;"></a>
                                </div>
                                <div class="shopping-cart-title" style="margin-top:-60px; margin-left:110px;">
                                    <h4><a href="javascript:void(0)"> <?php echo $list['dish']?></a></h4>
                                    <h6>Quantity: <?php echo $list['qty']?></h6>
                                    <span>Price: Rs.<?php echo $list['price']*$list['qty']?></span>
                                </div>
                            </li>
                            <?php } ?>
                        </ul>
                        <div class="shopping-cart-total">
                            <h4>Total : <span class="shop-total">Rs.<?php echo $totalPrice?></span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
include("footer.php");
?>