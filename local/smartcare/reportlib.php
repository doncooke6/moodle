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
  require_once($CFG->dirroot . '/local/smartcare/lib.php');
  require_once($CFG->dirroot . '/config.php');


// report format for administration level auditing of smartcare log
function generate_admin_report($output = 'screen', $statusfilter = 'All', $startdate, $enddate ) {
global $PAGE, $OUTPUT;

      require_login();

       // add filters to limit output
      if ($rsloglines = get_loglines($statusfilter, $startdate, $enddate)) {
       // loop through result set -  push results to csv file or screen display based on output option
       if ($output == 'screen') {
           $title = get_string('pluginname', 'local_smartcare');
           $heading = get_string('admin_heading', 'local_smartcare');
           $url = new moodle_url('/local/smartcare/');
           $context = context_system::instance();

           $PAGE->set_pagelayout('admin');
           $PAGE->set_url($url);
           $PAGE->set_context($context);
           $PAGE->set_title($title);
           $PAGE->set_heading($heading);
           echo $OUTPUT->header();
           echo '<table class="generaltable"><tr>
           <th>Status</th>
           <th>Time/Date</th>
           <th>Error Desc</th>
           <th>User Affected</th></tr>
           </th>';

           foreach ($rsloglines as $reclogline) {
             echo '<tr>';
             echo '<td>' . $reclogline->read_status . '</td>';
             echo '<td>' . $reclogline->logdate . '</td>';
             echo '<td>' . $reclogline->logdescription .'</td>';
             echo '<td>' . $reclogline->name . '</td>';
             echo '</tr>';
           }

           echo '</table>';

          echo $OUTPUT->footer();

           // close table and add page $footer

         } else {

            // Open csv output file TODO .. possibly as a seperate csv generation php script.
            // TODO Write csv output headers

            // output headers so that the file is downloaded rather than displayed
            header_remove();
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=data.csv');


            // create a file pointer connected to the output stream
            $output = fopen('php://output', 'w');

            // output the column headings
            fputcsv($output, array('Read Status', 'Log Date', 'Log Description', 'Name'));
            // loop over the rows, outputting them
                       foreach ($rsloglines as $row)  {
                         fputcsv($output,
                           array($row->read_status,
                                 $row->logdate ,
                                 $row->logdescription ,
                                 $row->name ));
            }
            exit;

           }
        } else {
          $title = get_string('pluginname', 'local_smartcare');
          $heading = get_string('admin_heading', 'local_smartcare');
          $url = new moodle_url('/local/smartcare/');
          $context = context_system::instance();

          $PAGE->set_pagelayout('admin');
          $PAGE->set_url($url);
          $PAGE->set_context($context);
          $PAGE->set_title($title);
          $PAGE->set_heading($heading);

           echo $OUTPUT->header();
           echo 'No log messages found ...';
           echo $OUTPUT->footer();
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


         if ($rsLogResults = $DB->get_records_sql($s, $parms)) {

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
