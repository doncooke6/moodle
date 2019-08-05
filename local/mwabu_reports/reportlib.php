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
 require_once($CFG->dirroot . '/local/mwabu_reports/lib.php');

// report format for administration level auditing of smartcare log
function generate_outline_report($outputtype = 'screen' , $destignationtype = 'all') {
    global  $OUTPUT;
       // base query to  get details for all proficiancy trancking data  for a range
       // add filters to limit output

       // loop through result set -  push results to csv file or screen display based on output option
       if ($outputtype == 'screen') {

        echo $OUTPUT->header();

        if ($destignationtype == 'all') {
            $jobs = get_mwabudesignations();
             }
        else {
            $jobs[0] = $destignationtype;
        }


         echo '<table border="1" class="generaltable flexible boxaligncenter">';
         echo '<tr><th width="50%">' . get_string('indicator', 'local_mwabu_reports'). '</th>';
         echo '<th>' . get_string('region', 'local_mwabu_reports'). '</th>';
         echo '<th>' . get_string('facility', 'local_mwabu_reports'). '</th></tr>';

         // a new table for each job role as the competencies will be differant
         $competenciesforjob = get_competency_per_designation($destignationtype);

          echo '<tr><th>' . get_string('training', 'local_mwabu_reports') . '</th>';
          echo '<td>0</td><td>0</td><td></td></tr>'; // TODO  totals

          echo '<tr><th>' . get_string('totstafftrained', 'local_mwabu_reports') . '</th>';
          echo '<td>0</td><td>0</td><td></td></tr>'; // TODO  totals

          echo '<tr><th>' . get_string('totstaffrequirmentorship', 'local_mwabu_reports') . '</th>';
          echo '<td>0</td><td>0</td><td></td></tr>'; // TODO  totals

          echo '<tr><th>' . get_string('posttestscore', 'local_mwabu_reports') . '</th>';
          echo '<td>0</td><td>0</td><td></td></tr>'; // TODO  totals

          echo '<tr><th>' . get_string('mentorship', 'local_mwabu_reports') . '</th>';
          echo '<td></td><td></td><td></td></tr>'; // Intentionally left blank on the outline report

          echo '<tr><th>' . get_string('totstaffmentored', 'local_mwabu_reports') . '</th>';
          echo '<td>0</td><td>0</td><td></td></tr>'; // TODO  totals

          echo '<tr><th>' . get_string('totstaffreqtrainained', 'local_mwabu_reports') . '</th>';
          echo '<td></td><td></td><td></td></tr>'; // TODO  totals

          echo '<tr><th>' . get_string('totstaffreqpostretained', 'local_mwabu_reports') . '</th>';
          echo '<td>0</td><td>0</td><td></td></tr>'; // TODO  totals

          echo '<tr><th>' . get_string('totstaffmentorusingsystem', 'local_mwabu_reports') . '</th>';
          echo '<td>0</td><td>0</td><td></td></tr>'; // TODO  totals

          echo '</table>'; // End of competency
        // close table and add page $footer

        echo $OUTPUT->footer();


      } else {

         // open csv output file TODO .. possibly as a seperate csv generation php script
         // TODO Write csv output headers

         foreach ($results as $result) {
            // write row to csv output file

         }
       // push file to user
    }
 }

// Report output for inclusion as a user profile report
function generate_detail_report($outputtype = 'screen', $destignationtype = 'all') {
  global $DB, $OUTPUT;


                   // loop through result set -  push results to csv file or screen display based on output option
                   if ($outputtype == 'screen') {
                     // open csv output file TODO .. possibly as a seperate csv generation php script
                    if ($destignationtype == 'all') {
                        $jobs = get_mwabudesignations();
                         }
                    else {
                        $jobs[0] = $destignationtype;
                    }

                     echo $OUTPUT->header();

                     foreach ($jobs as $designation) {
                          echo 'Designation : ' . $designation . '<br><br>';
                          echo '<table border=1 class="generaltable flexible boxaligncenter">';

                          // a new table for each job role as the competencies will be differant
                          $competenciesforjob = get_competency_per_designation($designation);

                           echo '<tr border="1">';
                           echo '<th>' . get_string('staffname', 'local_mwabu_reports') . '</th>';
                           echo '<th>' . get_string('id', 'local_mwabu_reports') . '</th>';
                           echo '<th>' . get_string('designation', 'local_mwabu_reports') . '</th>';
                           echo '<th>' . get_string('facilityname', 'local_mwabu_reports') . '</th>';
                           echo '<th>' . get_string('pretestscore', 'local_mwabu_reports') . '</th>';
                           echo '<th>' . get_string('posttestscore', 'local_mwabu_reports') . '</th>';
                           echo '<th>' . get_string('proficiencytestscore', 'local_mwabu_reports') . '</th>';
                           echo '<th>' . get_string('proficiencyrating', 'local_mwabu_reports') . '</th>';

                          foreach ($competenciesforjob  as $competency) {
                            echo '<td><div class="rotated-text-container">';
                            echo '<span id="rotated-text">' . $competency->competencyname . '</span>';
                            echo '</div></td>';
                          }

                     echo '</tr>';


                     // Each data row
                     echo '<tr>';
                           $users = get_users_of_designation($designation);
                           // Include a table with user details plus the competency titles
                           foreach ($users as $user) { // one row per user
                                // include firstname and surname for the user
                                // get competencies for user
                               echo '<tr>';
                               echo '<td>' . $user->lastname . '</td>' ;
                               echo '<td>' . get_customuserfield($user->userid,'nrc') . '</td>' ;
                               echo '<td>' . get_customuserfield($user->userid,'designation') . '</td>' ;
                               echo '<td>' . get_customuserfield($user->userid,'facility') . '</td>' ;

                                $usercomps = get_competencies_for_user($user->userid);

                               //For each course/competency match for the role
                                  foreach ($competenciesforjob as $desigcompetency) {
                                  // Loop through the competency awards

                                     $foundit = false;


                                     // look for whether the user has the competency ?
                                     foreach ($usercomps as $eachcomp) {
                                          if ($eachcomp->competencyid == $desigcompetency->competencyid) {
                                                  $foundit = true;

                                                 // TODO - what details do we want to show - grade/proficiency
                                                 break;

                                                      // If the user and if given then include the grades
                                                      // If the competency has not been awarded to the user - leave cell blank
                                                  } // End of loop
                                           }



                                         if ($foundit == true) {
                                           echo '<td>Gained</td>';




                                         } else {
                                           echo '<td>Required</td>';


                                         }
                                }
                     echo '</tr>';
                            }

                            echo '</table>'; // End of competency

                            echo $OUTPUT->footer();
                        }

                  } else {

                     // open csv output file TODO .. possibly as a seperate csv generation php script
                     // TODO Write csv output headers

                     foreach ($results as $result) {
                        // write row to csv output file

                   }
         }  // push file to user
      }





      function get_competency_per_designation($designation) {
         global $DB;
           $s = 'SELECT matrix.id , matrix.course as courseid, c.fullname as coursename, designation , competencyid, comp.shortname as  competencyname
                   FROM {local_role_prof_matrix}  matrix
                   JOIN {course} c on course = c.id
                   JOIN {competency} comp on competencyid = comp.id
                  WHERE designation = :designation
               ORDER BY course, competencyid';

           $parms = array('designation' => $designation);
           $matrix = array();

            if ($rscompetencies_role = $DB->get_records_sql($s,$parms) ) {

               foreach ($rscompetencies_role as $recrole_competency) {
                $competency = new stdClass;
                $competency->course = $recrole_competency->courseid;
                $competency->coursename = $recrole_competency->coursename;
                $competency->competencyid = $recrole_competency->competencyid;
                $competency->competencyname = $recrole_competency->competencyname;
                 $matrix[] = $competency;
                }
              }
              return $matrix;
      }



      function get_users_of_designation($designation_name) {
        global $DB;

        $s = 'SELECT id, param1
                FROM {user_info_field}
               WHERE name = "designation"';
        $recdec  = $DB->get_record_sql($s);

        $designation_fieldid = $recdec->id;
        $users = array();

         $s = 'SELECT u.id AS userid, firstname, lastname
                 FROM {user} u
                 JOIN {user_info_data} uid ON uid.fieldid = :designatonid AND uid.userid = u.id
                WHERE uid.data = :designation';
         $parms = array ('designatonid' => $designation_fieldid, 'designation' => $designation_name);


        if ( $userswithdesignation = $DB->get_records_sql($s, $parms) ) {
           foreach($userswithdesignation as $recuser) {
                $user = new stdClass;
                $user->id =   $recuser->userid;
                $user->firstname =   $recuser->firstname;
                $user->lastname =   $recuser->lastname;


                $users[] =  $recuser;
          }
        }

        return $users;
      }

      function get_competencies_for_user($userid) {
         global $DB;

         $s = 'SELECT userid, competencyid, proficiency, grade
                 FROM {competency_usercompcourse}
                WHERE userid = :userid';

              $parms = array('userid' => $userid);

              if ($rsusercomp =  $DB->get_records_sql($s, $parms)) {
                  return $rsusercomp;
              }   else {
                  return array();;
              }
      }
