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
function local_mwabu_reports_extend_settings_navigation($settingsnav, $context) {
    global $CFG, $PAGE, $ADMIN;

    if (has_capability('local/mwabu_reports:admin', context_system::instance())) {
      // TODO .. add to the course menu
        if ($settingnode = $settingsnav->find('courseadmin', navigation_node::TYPE_COURSE)) {
            // details report
            $stroptionheading = get_string('proficiency_outline_report_link', 'local_mwabu_reports');
            $url = new moodle_url('/local/mwabu_reports/proficiency_tracker_outline.php', array('id' => $PAGE->course->id));
            $mwabureportsnode = navigation_node::create(
                  $stroptionheading,
                  $url,
                  navigation_node::NODETYPE_LEAF,
                  'mwabu_reports_outline',
                  'mwabu_reports_ouline',
                  new pix_icon('t/addcontact', $stroptionheading)
            );
            if ($PAGE->url->compare($url, URL_MATCH_BASE)) {
                $mwabureportsnode->make_active();
            }
            $settingnode->add_node($mwabureportsnode);
          }
    }
}

function getcourses($courseid = 0) {
    global $DB;
    $courses = array();
    $s = 'SELECT id, fullname FROM {course}
            WHERE visible = 1';

    if ($rscourses = $DB->get_records_sql($s)) {
        foreach ($rscourses as $reccourse) {
              $courses[$reccourse->id] = $reccourse->fullname;
        }
        return $courses;
    }
}



function get_pretest_quizid($courseid = 0){ // Returns the quiz instance id for the required course
    global $DB, $COURSE;
// TODO use the course based config setting

    $s = 'SELECT id
            FROM {quiz}
           WHERE course = :courseid
           AND name LIKE "%Pre Test%"
    ';

    $parms = array('courseid' => $courseid);

    $recdec  = $DB->get_record_sql($s, $parms);

}

function get_posttest_quizid($courseid = 0){ // Returns the quiz instance id for the required course
    global $DB, $COURSE;
    // TODO use the course based config setting

    $s = 'SELECT id
            FROM {quiz}
           WHERE course = :courseid
           AND name LIKE "%Post Test%"
    ';

    $parms = array('courseid' => $courseid);
    $recdec  = $DB->get_record_sql($s, $parms);

    return $recdec->id;
}

function get_proficiency_assignment($courseid = 0){ // Returns the quiz instance id for the required course
    global $DB, $COURSE;
    // TODO use the course based config setting

    $s = 'SELECT id
            FROM {assign}
           WHERE course = :courseid
           AND name LIKE "%Assignment%"
    ';

    $parms = array('courseid' => $courseid);
    $recdec  = $DB->get_record_sql($s, $parms);

    return $recdec->id;
}


function get_proficiency_certificate($courseid = 0){ // Returns the quiz instance id for the required course
    global $DB, $COURSE;
    // TODO use the course based config setting

    $s = 'SELECT id
            FROM {certificate}
           WHERE course = :courseid
           AND name LIKE "%Certificate%"
    ';

    $parms = array('courseid' => $courseid);
    $recdec  = $DB->get_record_sql($s, $parms);

    return $recdec->id;
}







function get_test_grade_for_user($instanceid, $instancetype, $userid) {
    global $DB;
  $s = 'SELECT gr.finalgrade as finalgrade
          FROM {grade_grades} gg
          JOIN {grade_items} gi on gg.itemid = gi.id
         WHERE   iteminstance = :quizinstance matches AND
                 gg.userid  = :userid';

      $parms = array('quizinstance' => $quizid, 'userid' => $userid);

    $recdec  = $DB->get_record_sql($s, $parms);
       return $recdec->id;
}

function get_mwabudesignations($includeall = false) {
    global $DB;
    // find out which one is the designation field

    $s = 'SELECT id, param1
            FROM {user_info_field}
           WHERE name = "designation"';
    $recdec  = $DB->get_record_sql($s);
    $list = array();


    $listraw = splitNewLine($recdec->param1);
    if ($includeall) {
          $list['all'] = get_string('all', 'local_mwabu_reports');
    }


    foreach ($listraw as $listitem) {
        $list[$listitem] =  $listitem;
    }

   return $list;
}

function yesnoopts() {
$list = array ('yes' => 'Yes', 'no' => 'No');

return $list;
}

function get_facilities($includeall = false) {
  global $DB;
  // find out which one is the designation field

  $s = 'SELECT id, param1
          FROM {user_info_field}
         WHERE name = "facility"';
  $recdec  = $DB->get_record_sql($s);
  $list = array();

  if ($includeall) {
      $list['all'] = get_string('all', 'local_mwabu_reports');
  }

  $listraw = splitNewLine($recdec->param1);
  foreach ($listraw as $listitem) {
      $list[$listitem] = $listitem;
   }

    // Add the list of facilities
  return $list;
}

function get_regions($includeall = false) {
  global $DB;
  // find out which one is the designation field

  $s = 'SELECT id, param1
          FROM {user_info_field}
         WHERE name = "region"';
  $recdec  = $DB->get_record_sql($s);
  $list = array();

  if ($includeall) {
      $list['all'] = get_string('all', 'local_mwabu_reports');
  }

  $listraw = splitNewLine($recdec->param1);
  foreach ($listraw as $listitem) {
      $list[$listitem] = $listitem;
   }

    // Add the list of facilities
  return $list;
}

function get_districts($includeall = false) {
  global $DB;
  // find out which one is the designation field

  $s = 'SELECT id, param1
          FROM {user_info_field}
         WHERE name = "district"';
  $recdec  = $DB->get_record_sql($s);
  $list = array();

  if ($includeall) {
      $list['all'] = get_string('all', 'local_mwabu_reports');
  }

  $listraw = splitNewLine($recdec->param1);
  foreach ($listraw as $listitem) {
      $list[$listitem] = $listitem;
   }

    // Add the list of facilities
  return $list;
}

// TODO could refactor into one routine passed the field and the userid
function get_customuserfield($userid, $field) {
  global $DB;
  // find out which one is the custom fiedl we are looking for
  $s = 'SELECT id, param1
          FROM {user_info_field}
         WHERE name = :fieldname';

  $parms = array('fieldname' => $field)   ;
  $recdec  = $DB->get_record_sql($s, $parms);

  $s = 'SELECT data FROM {user_info_data}
         WHERE fieldid = :fieldid
           AND userid = :userid';
  $parms = array('fieldid' => $recdec->id, 'userid' => $userid );
  $recuserinfo  = $DB->get_record_sql($s, $parms);

  return $recuserinfo->data;
}


function get_mwabureporttype() {
  $list[0] = get_string('detailedreport', 'local_mwabu_reports');
  $list[1] = get_string('summaryreport', 'local_mwabu_reports');
  $list[2] = get_string('competencymatrix', 'local_mwabu_reports');
  // Add the list of roles
  return $list;
}





// Return a list of userids who match the report criteria for the detailed report
function getRowsForReport($partialname = '', $partialcourse = '', $reqcoursecomplete, $reqmentor) {
  global $DB;

      $parms = array('partialquiz' => 'Pre Test');

      $s = 'SELECT u.is as userid,
                   u.firstname as firstname,
                   u.middlename as middlename,
                   u.lastname as lastname,
                   c.id as courseid,
                   c.fullname as coursename,
                   q.id as quizid,
                   q.name as quizname
            FROM {user} u
            JOIN {user_enrolments} ue ON ue.userid = u.id
            JOIN {enrol} e ON  ue.enrolid = e
            JOIN  {course} c ON e.courseid = c.id
             WHERE c.id IN
                   (SELECT UNIQUE(course)
                    FROM {quiz}
                    WHERE name LIKE  "%:partialquiz%")';


// TODO - add filter only including courses flagged as proficiency courses

    if ($partialcourse !== '') {
        $s .= ' AND c.fullname LIKE "%:coursepartial%"';
        $parms['coursepartial'] = $partialcourse;
    }

    if ($partialname !== '') {
        $s .= ' AND CONCAT (u.firstname, " " , u.middlename , " " . u.lastname) LIKE "%:userpartial"';
        $parms['userpartial'] = $partialcourse;
     }

   return $DB->get_records_sql($s,$parms);
   }











function get_mwabureportoutput() {
  $list[0] = get_string('outputtoscreen', 'local_mwabu_reports');
  $list[1] = get_string('outputtocsv', 'local_mwabu_reports');

  // Add the list of roles
  return $list;

}







function splitNewLine($text) {
    $code=preg_replace('/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n",$text)));
    return explode("\n",$code);
}
