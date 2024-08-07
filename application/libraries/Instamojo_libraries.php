<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instamojo_libraries extends CI_Model {

	public function instamojo_payment_btn($amount=0,$generated_order_id=""){

		    $user=$this->my_libraries->mh_getCookies('customer');
		    $contents= $this->cart->contents();
		   
		    $receipt=time();
		    $merchant_order_id='MOR'.date('md').time();

		    if($user[0]->gst_status==1){
		        $registration=$user[0]->registration_no;
		        $company_name=$user[0]->company_name;
		        $company_address=$user[0]->company_address;
		    }else{
		        $registration=null;
		        $company_name=null;
		        $company_address=null;
		    }


		    $splitArray=getTakeAwaySlot(date('Y-m-d'));
		    $arrayConvert=array();
		    if($splitArray!=array()){
		        foreach($splitArray as $krys=>$value){
		            $explor_from_space=explode(' ', $value);
		            $arrayConvert['id_']=($krys+1);
		            $arrayConvert['date_']= date('d M, l',strtotime($explor_from_space[0]));
		            $arrayConvert['time_']= $explor_from_space[1];
		            $arrTakeaWay[]=$arrayConvert;
		        }
		    }

		      // $arrayConvert=array();
	       //     $arrTakeaWay=array();
	       //     if($splitArray!=array()){
	       //      $inx=0;
	       //       foreach($splitArray as $krys=>$value){
	       //           $inx++;
	       //            $index=0;
	       //            foreach ($value as $fkey => $fvalue) {
	       //               $index++;
	       //              $explor_from_space=explode(' ', $fvalue);
	       //              $arrayConvert['id_']=$inx.'_'.$index;
	       //              $arrayConvert['date_']= date('d M, l',strtotime($explor_from_space[0]));
	       //              $arrayConvert['time_']= $explor_from_space[1];
	       //              $arrTakeaWay[]=$arrayConvert;
	                    
	       //            }

	       //         }
	       //     }
		    $delivery_timeSlot=$arrTakeaWay;

		    $slotSet=$this->session->userdata('slotSet');
		    if($slotSet==""){
		        $getSlot=$delivery_timeSlot[0]['date_'].'-'.$delivery_timeSlot[0]['time_'];
		    }else{
		        $getSlot=$slotSet;
		    }

		    $dlivetype=$this->session->userdata('dlivetype');
		    $sessionType=$this->session->userdata('valueType');  // delivery type and pincode
            
             // $shippingCharg=$this->my_libraries->getShippingChargesOnAddressPincode($user,$contents,$itemsWieght,$dlivetype);
            // echo "hii";
		    // echo "<pre>";
		    // print_r($dlivetype);
		    // echo "<pre>";
		    // print_r($sessionType);

		    // exit;

			// $config=$this->razorpay_config();
		    // $api = new Api($config['keyId'], $config['keySecret']);
		    // $displayCurrency=$config['displayCurrency'];

				// We create an razorpay order using orders api
				// Docs: https://docs.razorpay.com/docs/orders
				//
			$orderData = [
			    'receipt'         => $receipt, //3456,
			    'amount'          => $amount, // 2000 rupees in paise
			    'currency'        => 'INR',
			    'payment_capture' => 1 // auto capture
			];

		   // $razorpayOrder = $api->order->create($orderData);
		   // $razorpayOrderId = $razorpayOrder['id'];

		   // $_SESSION['razorpay_order_id'] = $razorpayOrderId;
		    // $this->session->set_userdata('razorpay_order_id',$razorpayOrderId);

		    $displayAmount = $amount = $orderData['amount'];

			// if ($displayCurrency !== 'INR'){
			//     $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
			//     $exchange = json_decode(file_get_contents($url), true);
			//     $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
			// }

		    //   echo "hiiii33";
		    // echo "<pre>";
		    // print_r($user);
		    // echo "</pre>";
		    // $checkout = 'automatic';
		    // if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true)){
		    //     $checkout = $_GET['checkout'];
		    // }

		    $data['data'] = [
		        "key"               => '',//$config['keyId'],
		        "amount"            => $amount,
		        "name"              => "Mahalaxmi",
		        "description"       => '',//$razorpayOrderId,
		        "image"             => base_url()."include/frontend/assets/img/home-2/mahalaxmi-logo_new.png",
		        "prefill"           => [
		            "name"              => (($user!="") ? $user[0]->c_fname .' '.$user[0]->c_lname :''),
		            "email"             => (($user!="") ? $user[0]->email :''),
		            "contact"           => (($user!="") ? $user[0]->mobile :''),
		        ],
		        "notes"             => [
		        "address"           => '',
		        "merchant_order_id" => '',//$merchant_order_id,
		        ],
		        "theme"             => [
		          "color"             => "#B12234"
		        ],
		        "order_id"          => '',//$razorpayOrderId
		        // "button_text"      =>'Continue To Payment'
		    ];

		    // if ($displayCurrency !== 'INR'){
		    //     $data['data']['display_currency']  = $displayCurrency;
		    //     $data['data']['display_amount']    = $displayAmount;
		    // }

		    // $data['display_currency']=$displayCurrency;
		     $data['display_currency']='INR';
		    $data['generated_order_id']=$generated_order_id;

		    $data['gstDetail']=[
		      'registration'=>$registration,
		      'company_name'=>$company_name,
		      'company_address'=>$company_address
		    ];

		    $data['timeSlot']=($dlivetype==2) ? $getSlot :'';
		    
		    $data['razorpay_order_id']= '';//$razorpayOrderId;
		    
		    $data['sessionType']=$sessionType;
		    

		    $customer_remark=$this->session->userdata('customer_remark');
		    $customer_greeting=$this->session->userdata('customer_greating');

		    $data['customer_remark']=$customer_remark;
		    $data['customer_greeting']=$customer_greeting;

		    // echo "<pre>";
		    // print_r($user);
		    // echo "<pre>";


           // $userun

		    // $customer_session=unserialize(base64_decode($user));
            $customer_session=$user;

		    $where='';

		    $data['columsName']=$this->my_libraries->setPRoductCondition($customer_session,$where,$sessionType);

		    $couponDetails=$this->session->userdata('coupon');

		    $data['couponDetails']=$couponDetails;

		    // if($user[0]->c_fname==""){
		    //   $custo_name=$user[0]->mobile;
		    // }else{
		    //   $custo_name=ucfirst($user[0]->c_fname).' '.ucfirst($user[0]->c_lname);
		    // }

		   // $data['custo_name']=$generated_order_id;
		   $data['customer_cookies']=$user;
		   $data['contents']=$contents;
		   // $data['finalAmount']=$amount;
		    // $this->load->view('frontend/paymentCheckout',$data);
		    $this->load->view('frontend/paymentInstamojoCheckout',$data);
		}





}