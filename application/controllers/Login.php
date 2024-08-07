<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

   function __construct(){
        parent::__construct();

          $this->load->model('login_model','loginObj');
          $this->load->library('my_libraries');
   }
      



  public function index(){

    $email_mobi=$this->input->post('email_mobi');
    $error=1;
    

    if(empty($email_mobi)){
      $error=0;
      $data['status']=0;
      $data['message']='Enter your mobile or email Id.';
     
    }
    else if(is_numeric($email_mobi)){
        if(!checkMobile($email_mobi)){
            $error=0;
            $data['status']=0;
            $data['message']='Enter valid mobile number';
           
        }
    }
    else if(is_string($email_mobi)){
        
        if(!filter_var($email_mobi, FILTER_VALIDATE_EMAIL)){
            $error=0;
            $data['status']=0;
            $data['message']='Enter valid email Id';
        }
    }

    if($error==1){

        $userDetail=$this->loginObj->getUserDetailByEmailOrMobile($email_mobi);
        
        //print_r($userDetail);

        $otp = sprintf("%06d", mt_rand(1, 999999));
        
        if(is_array($userDetail) && count($userDetail) > 0){
          
          if($userDetail['email']!=""){
           //echo "step1";
            $this->emaillibrary->sendOtpMail($userDetail['email'],$otp);
          }
          if($userDetail['mobile']!=""){
            //echo "step2";
            //$this->sendMobileOtp($email_mobi,$otp);
            //echo $userDetail['mobile'];
            $this->emaillibrary->sendOtpOnMobile($userDetail['mobile'],$otp);
          }

          $sql_update=$this->loginObj->updateUserDataByUserId($userDetail['customer_id'],array('otp'=>$otp));
          $data['status']=1;
          //$data['message']='Your OTP send successfully. '.$otp;
          $data['message']='Your OTP send successfully';
          echo json_encode($data);
          exit;

        }else{
            if(checkemail($email_mobi)){
                //echo "step4";
                $this->emaillibrary->sendOtpMail($email_mobi,$otp);
                $arrPost['email']=trim($email_mobi);

              }else if(preg_match('/^[0-9]{10}+$/', $email_mobi)) {
                $this->emaillibrary->sendOtpOnMobile($email_mobi,$otp);
                $arrPost['mobile']=trim($email_mobi);
              }
              $arrPost['updated_by']='customer';
              $arrPost['registered_type']='Manual';
              $arrPost['otp']=$otp;
              // print_r($arrPost);
              $sql_insert=$this->loginObj->insertNewUser($arrPost);
              $data['status']=1;
              $data['message']='Your OTP send successfully.';
              echo json_encode($data);
              exit;
        }  
       
    }else{
        echo json_encode($data);
        exit; 
    }
        
}

public function otpVerification() {
    $email_mobi = $this->input->post('email_mobi');
    $otpArray = $this->input->post('otp');

    if (empty($email_mobi)) {
        $data['status'] = 0;
        $data['message'] = 'Enter your mobile or email Id.';
        echo json_encode($data);
        exit;
    } else {
        $userDetail = $this->loginObj->getUserDetailByEmailOrMobile($email_mobi);

        if (count($userDetail) > 0) {
            $otp = implode("", $otpArray);

            if ($this->loginObj->getChkValieOtp($userDetail['customer_id'], $otp)) {
                $this->loginObj->updateOtpVerification($userDetail['customer_id'], array('is_otp_verify' => 1));

                // Set cookies
                setCookies("customer", array("customer_id" => $userDetail['customer_id'], 'name' => $userDetail['c_fname'], 'isCustomerLogin' => 1));

                $data['status'] = 1;
                $data['message'] = 'OTP verified successfully';
                echo json_encode($data);
            } 
            else {
                $data['status'] = 0;
                $data['message'] = 'Entered OTP is invalid';
                echo json_encode($data);
            }
        } else {
            $data['status'] = 0;
            $data['message'] = 'User not registered. Please register';
            echo json_encode($data);
        }
    }
    exit;
}
   
   public function logout() {
        $user = $this->my_libraries->mh_getCookies('customer');

        if ($user != "") {
            delete_cookie('customer');
            $this->session->unset_userdata('access_token');
            $this->cart->destroy();
        }
        $this->session->set_flashdata('msg', $this->config->item('logout_success'));
        // redirect('login');
        redirect(base_url(''));
        
    }

// public function otpVerification(){
//     $email_mobi=$this->input->post('email_mobi');
//     $optArray=array_filter($this->input->post('otp'));
    
//     if(empty($email_mobi)){
//           $data['status']=0;
//           $data['message']='Enter your mobile or email Id.';
//           echo json_encode($data);
//           exit;
//     }
//     elseif(count($optArray)!=6){
//       $data['status']=0;
//       $data['message']='Enter valid otp';
//       echo json_encode($data);
//       exit;
//     }else{
//         $userDetail=$this->loginObj->getUserDetailByEmailOrMobile($email_mobi);

//         if(count($userDetail)>0){

//             $otp=implode("",$optArray);
            
//             if($this->loginObj->getChkValieOtp($userDetail['customer_id'],$otp)){
                
//                 $this->loginObj->updateOtpVerification($userDetail['customer_id'],array('is_otp_verify'=>1));

//                 setCookies("customer",array("customer_id"=>$userDetail['customer_id'],'name'=>$userDetail['c_fname'],'isCustomerLogin'=>1));

//                 $data['status']=1;
//                 $data['message']='successfully';
//                 echo json_encode($data);

//             }else{
//                 $data['status']=0;
//                 $data['message']='Entered otp is invalid';
//                 echo json_encode($data);
//             }


//         }else{
//             $data['status']=0;
//             $data['message']='User not registered.Please register';
//             echo json_encode($data);
//         }
//     }

    
//     //echo json_encode($data);
//     exit;

// } 

}

?>