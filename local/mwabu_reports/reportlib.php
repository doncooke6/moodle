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

// report format for administration level auditing of smartcare log at course level
function generate_outline_report($outputtype = 'screen' , $from, $to, $region = 'all', $district = 'all', $facility = 'all') {
    global  $OUTPUT, $COURSE;
       // base query to  get details for all proficiancy trancking data  for a range
       // add filters to limit output

       // loop through result set -  push results to csv file or screen display based on output option
       if ($outputtype == 'screen') {

        echo $OUTPUT->header();

        // if ($destignationtype == 'all') {
        //     $jobs = get_mwabudesignations();
        //      }
        // else {
        //     $jobs[0] = $destignationtype;
        // }

// basic population
// get the users who are enrolled on the course required and are in the :
// Facility required
// District required
// Province required

         echo '<table border="1" class="generaltable flexible boxaligncenter">';
         echo '<tr><th width="50%">' . get_string('indicator', 'local_mwabu_reports'). '</th>';
         echo '<th>' . get_string('region', 'local_mwabu_reports'). '</th>';
         echo '<th>' . get_string('facility', 'local_mwabu_reports'). '</th></tr>';

         // a new table for each job role as the competencies will be differant
        // $competenciesforjob = get_competency_per_designation($destignationtype);

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
function generate_detail_report($outputtype = 'screen', $partialname, $partialcourse, $reqcoursecomplete, $reqmentor) {
  global $DB, $OUTPUT;

                   // loop through result set -  push results to csv file or screen display based on output option
                   if ($outputtype == 'screen') {
                     // open csv output file TODO .. possibly as a seperate csv generation php script
                    // if ($destignationtype == 'all') {
                    //     $jobs = get_mwabudesignations();
                    //      }
                    // else {
                    //     $jobs[0] = $destignationtype;
                    // }

                     echo $OUTPUT->header();

                    $rows = getDetsForReport($partialname, $partialcourse, $reqcoursecomplete, $reqmentor);

                    echo '<table border=1 class="generaltable flexible boxaligncenter">';

                     echo '<tr border="1">';
                     echo '<th>' . get_string('snid', 'local_mwabu_reports') . '</th>';
                     echo '<th>' . get_string('firstname', 'local_mwabu_reports') . '</th>';
                     echo '<th>' . get_string('lastname', 'local_mwabu_reports') . '</th>';
                     echo '<th>' . get_string('nrc', 'local_mwabu_reports') . '</th>';
                     echo '<th>' . get_string('facilityname', 'local_mwabu_reports') . '</th>';
                     echo '<th>' . get_string('districtname', 'local_mwabu_reports') . '</th>';
                     echo '<th>' . get_string('coursename', 'local_mwabu_reports') . '</th>';
                     echo '<th>' . get_string('completed', 'local_mwabu_reports') . '</th>';
                     echo '<th>' . get_string('score', 'local_mwabu_reports') . '</th>';
                     echo '<th>' . get_string('proficiencytestname', 'local_mwabu_reports') . '</th>';
                     echo '<th>' . get_string('proficiencytestgrade', 'local_mwabu_reports') . '</th>';
                     echo '<th>' . get_string('proficiencytestscore', 'local_mwabu_reports') . '</th>';
                     echo '<th>' . get_string('requirementorship', 'local_mwabu_reports') . '</th>';
                     echo '<th>' . get_string('certificateissued', 'local_mwabu_reports') . '</th>';
                     echo '</tr>';


                     // Each data row
                     echo '<tr>';
                     // Include a table with user details plus the competency titles
                     foreach ($rows as $row) { // one row per user
                          // include firstname and surname for the user
                          // get competencies for user

                          // get our data for this particular users

                              // We now have the course for this student - so get the course, assignment name and score
                                  // get the proficiency ratings
                              $assignname = get_assignment_for_user($row->userid);
                              $pretestgrade = get_test_grade_for_user($row->quizid, 'quiz', $row->userid);
                              $posttestgrade = get_test_grade_for_user($courseposttestquiz, 'quiz',$row->userid);
                              $assignmentgrade = get_test_grade_for_user($courseassignmentid, 'assign', $row->userid);
                              $profiencyrating =  get_test_grade_for_user($courseproficiiencyratingid, 'assign', $row->userid);

                               echo '<tr>';
                               echo '<td>' . get_customuserfield($row->userid,'snid') . '</td>' ;
                               echo '<td>' . $row->middlename . '</td>' ;
                               echo '<td>' . $row->lastname . '</td>' ;
                               echo '<td>' . get_customuserfield($row->userid,'nrc') . '</td>' ;
                               echo '<td>' . get_customuserfield($row->userid,'facility') . '</td>' ;
                               echo '<td>' . get_customuserfield($row->userid,'district') . '</td>' ;
                               echo '<td>' . $row->coursename . '</td>' ;

                               // TODO - completed
                               echo '<td>TODO</td>' ;

                               // - score
                              echo '<td>' . $assignname . '</td>' ;
                              echo '<td>' . $assignmentgrade . '</td>' ;
                              echo '<td>' . $pretestgrade . '</td>' ;
                              echo '<td>' . $posttestgrade . '</td>' ;
                              echo '<td>' . $assignmentgrade. '</td>' ;
                              echo '<td>' . $profiencyrating. '</td>' ;

                              // TODO work out if require mentorship
                              // TODO work out if certificate awarded to user
                              echo '<td>TODO</td>' ;
                              echo '<td>TODO</td>' ;
                              echo '</tr>';
                          }

                            echo '</table>'; // End of competency
                            echo $OUTPUT->footer();

                  } else {

                     // open csv output file TODO .. possibly as a seperate csv generation php script
                     // TODO Write csv output headers

                     foreach ($results as $result) {
                        // write row to csv output file

                   }
         }  // push file to user
      }


function generate_competency_matrix($outputtype = 'screen', $destignationtype = 'all', $course = 0) {
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

     foreach ($jobs as $designation) {
          echo 'Designation : ' . $designation . '<br><br>';
          echo '<table border=1 class="generaltable flexible boxaligncenter">';

          // a new table for each job role as the competencies will be differant
          $competenciesforjob = get_competency_per_designation($designation);

     foreach ($competenciesforjob  as $competency) {
       echo '<td><div class="rotated-text-container">';
       echo '<span id="rotated-text">' . $competency->competencyname . '</span>';
       echo '</div></td>';
     }
     echo '<td>Full Competency</td>';

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


                $foundall = true;

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
                            echo '<td>Y</td>';

                          } else {
                            echo '<td>N</td>';
                            $foundall = false;


                        }
                    }


                    if ($foundall) {
                        echo '<td>Full</td>';
                    } else {
                        echo '<td>Partial</td>';
                    }

                    echo '</tr>';
                }
            }
        }
 } else { // csv generation of report



 }

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

         $s = 'SELECT u.id AS userid, firstname, middlename, lastname
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
