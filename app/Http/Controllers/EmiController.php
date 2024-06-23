<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ClientLoanDetails;

class EmiController extends Controller
{
    public function get_emi_details()
    {
        $loans = ClientLoanDetails::all();
        $clientEmiMonths = [];
        $emiData = array();
        foreach ($loans as $loan) {
            $emiData = $this->calculateEMI($loan->loan_amount, $loan->num_of_payment, $loan->first_payment_date, $loan->last_payment_date , $emiData);
            array_push($clientEmiMonths, [$loan->clientid => $emiData] );
        };

         // Collect all unique keys
         $allKeys = [];
         foreach ($clientEmiMonths as $array) {
             foreach ($array as $innerArray) {
                 $allKeys = array_merge($allKeys, array_keys($innerArray));
             }
         }
         $allKeys = array_unique($allKeys);
 
         // Normalize all arrays
         foreach ($clientEmiMonths as &$array) {
             foreach ($array as &$innerArray) {
                 foreach ($allKeys as $key) {
                     if (!array_key_exists($key, $innerArray)) {
                         $innerArray[$key] = 0;
                     }
                 }
                 uksort($innerArray, function($a, $b) {
                    // Convert the date strings to DateTime objects
                    $dateA = DateTime::createFromFormat('m-Y', $a);
                    $dateB = DateTime::createFromFormat('m-Y', $b);
                    
                    // Compare the DateTime objects
                    if ($dateA == $dateB) {
                        return 0;
                    }
                    
                    return ($dateA < $dateB) ? -1 : 1;
                });
             }
         }


        // dd($clientEmiMonths);

         $finalclientEmiMonthsOutter = [];
         $finalclientEmiMonthsOutterHeaderV = ['clientId'];
         foreach ($clientEmiMonths as &$array) {
            $finalclientEmiMonths = [];
            //HEADER
            $finalclientEmiMonths = array_keys($array);
            $finalclientEmiMonthsV = array_values($array[$finalclientEmiMonths[0]]);

        
            //VALUES
            $finalclientEmiMonthsOutterHeader = array_keys($array[$finalclientEmiMonths[0]]);
            $finalclientEmiMonths =array_merge($finalclientEmiMonths,$finalclientEmiMonthsV);
            
            array_push($finalclientEmiMonthsOutter, $finalclientEmiMonths);
         }
        
        //  dd($finalclientEmiMonthsOutter);

         $finalclientEmiMonthsOutterHeader =  collect($finalclientEmiMonthsOutterHeader)->map(function($dateString) {
            $dateTime = \DateTime::createFromFormat('m-Y', $dateString);
            $formattedDate = $dateTime->format('F Y');
            return ucwords($formattedDate);
        })->toArray();
        
         $finalclientEmiMonthsOutterHeaderV = array(array_merge($finalclientEmiMonthsOutterHeaderV,$finalclientEmiMonthsOutterHeader));
        //  dd($finalclientEmiMonthsOutter,$finalclientEmiMonthsOutterHeaderV);
         $finalclientEmiMonthsOutter =array_merge($finalclientEmiMonthsOutterHeaderV,["data" => $finalclientEmiMonthsOutter]);

         //dd($finalclientEmiMonthsOutter);
         return $finalclientEmiMonthsOutter;
        //  return view('dashboard', compact('clientEmiMonths'));
    }

    private function calculateEMI($principal, $numOfPayment, $startDate, $endDate, $emiMonths)
    {
       
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);
        $totalMonths = $startDate->diffInMonths($endDate);
        
        $emiPerMonth = (int)$principal / $numOfPayment;
        $emiPerMonth = number_format((float)$emiPerMonth, 2, '.', '');
        $keys = array_keys($emiMonths);
        $values = array_fill(0, count($keys),0);
        $emiMonths = array_combine($keys, $values);

        // print_r($emiMonths);

        for ($i=0; $i <=  $totalMonths ; $i++) { 
            
            $emiMonthKey = strtolower(Carbon::parse($startDate)->format('m-Y'));
            if (array_key_exists($emiMonthKey, $emiMonths))
                {
                    $emiMonths[$emiMonthKey] = $emiPerMonth;
                }
                else
                {
                    $emiMonths[$emiMonthKey] = $emiPerMonth;
                    //array_push($emiMonths,[$emiMonthKey => $emiPerMonth]);
                }
            $startDate = Carbon::parse($startDate)->addMonthsNoOverflow();
        }
        uksort($emiMonths, function($a, $b) {
            // Convert the date strings to DateTime objects
            $dateA = DateTime::createFromFormat('m-Y', $a);
            $dateB = DateTime::createFromFormat('m-Y', $b);
            
            // Compare the DateTime objects
            if ($dateA == $dateB) {
                return 0;
            }
            
            return ($dateA < $dateB) ? -1 : 1;
        });
        return $emiMonths;
    }
}
