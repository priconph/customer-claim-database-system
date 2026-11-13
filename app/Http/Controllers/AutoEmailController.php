<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

use Mail;
// use Illuminate\Support\Facades\Mail;
// use DataTables;
use App\CustomerClaim;
use App\Holiday;
use App\CustomerClassification;
use App\EmailRecipient;
use App\CustomerClaimEmailRecipient;
// use DateTime;
use App\ProductClassification;

class AutoEmailController extends Controller
{
    public function get_date(){
        $get_date = CustomerClaim::where('logdel', 0)
        ->where('status',0)
        ->get();

        return response()->json(['claimRecord' => $get_date]);
    }


    /**
     * Start
     * Auto Email every 7th day of the month
     */
    public function getCustomerClaimData(){
        $getCustomerClaimData = CustomerClaim::where('logdel', 0)
        ->where('status', 0)
        ->get();
        return response()->json(['getCustomerClaimData' => $getCustomerClaimData]);
    }

    public function sendMonthlyMailer(Request $request){
        $currentYear = date("Y");
        $currentMonth = date("m");
        $currentDay = date("d");
        $fromCurrentFirstQuarter = '2024-04-01'; // Since the development of this feature is year 2022, they requested to start the 1st quarter 2022 for the first email
        // $fromCurrentFirstQuarter = $currentYear.'-04-01'; // old
        $previousMonthFullDate = $currentYear.'-'.($currentMonth-1).'-'.$currentDay; // Minus 1 to $currentMonth to collect the previous whole month data
        $previousMonthFullDateCreate = date_create($previousMonthFullDate);
        $toCurrentWholeMonth = date_format($previousMonthFullDateCreate,"Y-m-t");

        $customer_claim_details = CustomerClaim::with([
            'customer_details',
            'product_details',
        ])
        ->where('date_received', '>=', $fromCurrentFirstQuarter)
        ->where('date_received', '<=', $toCurrentWholeMonth)
        ->where('validity', 1) // 1-valid
        ->get();
        
        /**
         * Uncomment this after finish
         */
        $to_email = ['group-cn@pricon.ph', 'group-ts@pricon.ph', 'group-pps@pricon.ph', 'group-yf@pricon.ph'];
        $cc_email = ['group-qad@pricon.ph'];

        /**
         * For testing purposes
         */
        // $to_email = ['scmasbad@pricon.ph', 'jggabuat@pricon.ph'];
        // $cc_email = ['jdomingo@pricon.ph', 'cpagtalunan@pricon.ph'];
        
        $data = array('customer_claim_details' => $customer_claim_details);
        Mail::send('mail.monthly.monthly_mailer', $data, function($message) use ($to_email,$cc_email){
            $message->to($to_email);
            $message->cc($cc_email);
            $message->bcc('jdomingo@pricon.ph');
            $message->bcc('cpagtalunan@pricon.ph');
            $message->subject("SUMMARY OF VALID CUSTOMER COMPLAINT-" . strtoupper(date("M Y")));
        });

        if (Mail::failures()) {
            return response()->json(['result' => 0]);
        }
        else{
            return response()->json(['result' => 1]);
        }
    }
    /**
     * End
     * Auto Email every 7th day of the month
     */


    public function sendMonthlyForJannusMailer(Request $request){
        $currentYear = date("Y");
        $currentMonth = date("m");
        $currentDay = date("d");
        $fromCurrentFirstQuarter = '2024-04-01'; // Since the development of this feature is year 2022, they requested to start the 1st quarter 2022 for the first email
        // $fromCurrentFirstQuarter = $currentYear.'-04-01'; // old
        $previousMonthFullDate = $currentYear.'-'.($currentMonth-1).'-'.$currentDay; // Minus 1 to $currentMonth to collect the previous whole month data
        $previousMonthFullDateCreate = date_create($previousMonthFullDate);
        $toCurrentWholeMonth = date_format($previousMonthFullDateCreate,"Y-m-t");

        $customer_claim_details = CustomerClaim::with([
            'customer_details',
            'product_details',
        ])
        ->where('date_received', '>=', $fromCurrentFirstQuarter)
        ->where('date_received', '<=', $toCurrentWholeMonth)
        ->where('validity', 1) // 1-valid
        ->get();

        /**
         * For testing purposes
         */
        // $to_email = ['scmasbad@pricon.ph', 'jggabuat@pricon.ph'];
        // $cc_email = ['jdomingo@pricon.ph', 'cpagtalunan@pricon.ph'];

        $to_email = ['jdomingo@pricon.ph'];
        $cc_email = ['cpagtalunan@pricon.ph'];
        
        $data = array('customer_claim_details' => $customer_claim_details);
        Mail::send('mail.monthly.monthly_mailer', $data, function($message) use ($to_email,$cc_email){
            $message->to($to_email);
            $message->cc($cc_email);
            $message->subject("FOR TESTING BEFORE SENDING MONTHLY MAILER - SUMMARY OF VALID CUSTOMER COMPLAINT-" . strtoupper(date("M Y")));
        });

        if (Mail::failures()) {
            return response()->json(['result' => 0]);
        }
        else{
            return response()->json(['result' => 1]);
        }
    }


    public function send_mail_due_date(Request $request){
        $customer_claim_details = CustomerClaim::with([
            'customer_details',
            'product_details',
            'email_recipient_details',
            'email_recipient_details.email_recipient_info',
        ])
        ->where('id', $request->id)->first();


        $email_recipients = CustomerClaimEmailRecipient::with([
            'email_recipient_info'
        ])
        ->where('customer_claim_id', $customer_claim_details->id)
        ->get();
        $to_email = array();
        $cc_email = array();

        for($i = 0; $i < count($email_recipients); $i++){
        
            if($email_recipients[$i]->type == 1){
                $to_email[] = $email_recipients[$i]->email_recipient_info->email;

                // $to_email = collect($email_recipients[$i]->email_recipient_info->email)->flatten(1)->toArray();
            }
            else if($email_recipients[$i]->type == 2){
                $cc_email[] = $email_recipients[$i]->email_recipient_info->email;

                // $cc_email = collect($email_recipients[$i]->email_recipient_info->email)->flatten(1)->toArray();
            }
        }

        // print_r($to_email);
        // print_r($cc_email);
        $required_reply_date = date_create($customer_claim_details->required_reply);
        $required_reply_date = date_format($required_reply_date,"m/d/Y");
        
        $data = array('customer_mail_details' => $customer_claim_details,'require_reply' => $required_reply_date);

        Mail::send('mail.customer_claim_due.due_date_mail', $data, function($message) use ($customer_claim_details,$to_email,$cc_email){
            $message->to($to_email);
            $message->cc($cc_email);
            // $message->cc('jggabuat@pricon.ph');
            // $message->cc('scmasbad@pricon.ph');
            $message->bcc('cpagtalunan@pricon.ph');
            $message->bcc('jdomingo@pricon.ph');
            $message->subject(" Customer Claim Due Today! ".$customer_claim_details->pmi_control_number."_".$customer_claim_details->model_name);
            
        });
        if (Mail::failures()) {
            return response()->json(['result' => 0]);
        }
        else{
            return response()->json(['result' => 1]);
        }
        
    }

    
    public function send_mail_before_due_date(Request $request){
        $customer_claim_details = CustomerClaim::with([
            'customer_details',
            'product_details',
            'email_recipient_details',
            'email_recipient_details.email_recipient_info',
        ])
        ->where('id', $request->id)->first();

        $email_recipients = CustomerClaimEmailRecipient::with([
            'email_recipient_info'
        ])
        ->where('customer_claim_id', $customer_claim_details->id)
        ->get();
        $to_email = array();
        $cc_email = array();

        for($i = 0; $i < count($email_recipients); $i++){
        
            if($email_recipients[$i]->type == 1){
                $to_email[] = $email_recipients[$i]->email_recipient_info->email;

                // $to_email = collect($email_recipients[$i]->email_recipient_info->email)->flatten(1)->toArray();
            }
            else if($email_recipients[$i]->type == 2){
                $cc_email[] = $email_recipients[$i]->email_recipient_info->email;

                // $cc_email = collect($email_recipients[$i]->email_recipient_info->email)->flatten(1)->toArray();
            }
        }

      
        $required_reply_date = date_create($customer_claim_details->required_reply);
        $required_reply_date = date_format($required_reply_date,"m/d/Y");

        $data = array('customer_mail_details' => $customer_claim_details,'require_reply' => $required_reply_date);



        Mail::send('mail.customer_claim_due.before_due_date_mail', $data, function($message) use ($customer_claim_details,$to_email,$cc_email){
            $message->to($to_email);
            $message->cc($cc_email);
            $message->bcc('cpagtalunan@pricon.ph');
            $message->bcc('jdomingo@pricon.ph');
            // $message->cc('jggabuat@pricon.ph');
            // $message->cc('scmasbad@pricon.ph');
            $message->subject(" Customer Claim Before Due! ".$customer_claim_details->pmi_control_number."_".$customer_claim_details->model_name);
        
        });

        if (Mail::failures()) {
            return response()->json(['result' => 0]);
        }
        else{
            return response()->json(['result' => 1]);
        }


    }

    public function send_mail_over_due_date(Request $request){
        $customer_claim_details = CustomerClaim::with([
            'customer_details',
            'product_details',
            'email_recipient_details',
            'email_recipient_details.email_recipient_info',
        ])
        ->where('id', $request->id)->first();

        $email_recipients = CustomerClaimEmailRecipient::with([
            'email_recipient_info'
        ])
        ->where('customer_claim_id', $customer_claim_details->id)
        ->get();


        $to_email = array();
        $cc_email = array();

        for($i = 0; $i < count($email_recipients); $i++){
        
            if($email_recipients[$i]->type == 1){
                $to_email[] = $email_recipients[$i]->email_recipient_info->email;

                // $to_email = collect($email_recipients[$i]->email_recipient_info->email)->flatten(1)->toArray();
            }
            else if($email_recipients[$i]->type == 2){
                $cc_email[] = $email_recipients[$i]->email_recipient_info->email;

                // $cc_email = collect($email_recipients[$i]->email_recipient_info->email)->flatten(1)->toArray();
            }
        }

        $required_reply_date = date_create($customer_claim_details->required_reply);
        $required_reply_date = date_format($required_reply_date,"m/d/Y"); //start date

        $date_today = date_create(NOW());
        $date_today = date_format($date_today,"m/d/Y"); // end date
        
        // to get the number of days past overdue (end date - start date)
        $diff = strtotime($date_today) - strtotime($required_reply_date);
        $calculated_days_of_over_due =  abs(round($diff / 86400));
        

        $data = array('customer_mail_details' => $customer_claim_details,'require_reply' => $required_reply_date, 'days_over_due' => $calculated_days_of_over_due);

        Mail::send('mail.customer_claim_due.over_due_mail', $data, function($message) use ($customer_claim_details,$to_email,$cc_email){
            $message->to($to_email);
            $message->cc($cc_email);
            $message->bcc('cpagtalunan@pricon.ph');
            $message->bcc('jdomingo@pricon.ph');
            // $message->cc('jggabuat@pricon.ph');
            // $message->cc('scmasbad@pricon.ph');
            $message->subject(" Customer Claim Overdue! ".$customer_claim_details->pmi_control_number."_".$customer_claim_details->model_name);
            
        });
        if (Mail::failures()) {
            return response()->json(['result' => 0]);
        }
        else{
            return response()->json(['result' => 1]);
        }
    }
}
