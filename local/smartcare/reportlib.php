<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 * Version information
 *
 * @package    local_smartcare
 * @copyright 2019 TitusLearning {@link http://www.tituslearning.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


// report format for administration level auditing of smartcare log
function generate_admin_report($output = 'screen' ) {

       // base query to  get details for all log msgs for a range  from the smartcare log table
       $s = "SELECT id , userid , name , nrc , dob , logtype , logdate ,
                   logdescription ,logremarks ,read_status
              FROM local_smartcare_log";
       // add filters to limit output


       // loop through result set -  push results to csv file or screen display based on output option
       if ($output == 'screen') {


         // open csv output file TODO .. possibly as a seperate csv generation php script
        foreach ($results as $result) {
          // write row to output file

        }

        // close table and add page $footer

      } else {

         // open csv output file TODO .. possibly as a seperate csv generation php script
         // TODO Write csv output headers

         foreach ($results as $result) {
            // write row to csv output file

       }

       // push file to user
    }
 }

// Report output for inclusion as a user proifle report
function generate_detail_report($output = 'screen', $userid) {
  global $DB;

         // base query to  get detils for the specific user from the smartcare log table
         $s = "SELECT id , userid , name , nrc , dob , logtype , logdate ,
                     logdescription ,logremarks ,read_status
                FROM local_smartcare_log
               WHERE userid = :userid ";

         $parms = array('userid' => $userid);
         // add filters to limit output


         if $rsLogResults = $DB->get_records_sql($s, $parms) {

                   // loop through result set -  push results to csv file or screen display based on output option
                   if ($output == 'screen') {
                     // open csv output file TODO .. possibly as a seperate csv generation php script

                    foreach ($results as $result) {
                      // write row to output file TODO .. possibly as a seperate csv generation php script

                    }


                    // close table and add page $footer

                  } else {

                     // open csv output file TODO .. possibly as a seperate csv generation php script
                     // TODO Write csv output headers

                     foreach ($results as $result) {
                        // write row to csv output file

                   }
         }  // push file to user
      }
   }
 }
