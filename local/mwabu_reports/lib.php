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
            $stroptionheading = get_string('proficiency_detail_report_link', 'local_mwabu_reports');
            $url = new moodle_url('/local/mwabu_reports/proficiency_tracker_detail.php', array('id' => $PAGE->course->id));
            $mwabureportsnode = navigation_node::create(
                  $stroptionheading,
                  $url,
                  navigation_node::NODETYPE_LEAF,
                  'mwabu_reports_detail',
                  'mwabu_reports_detail',
                  new pix_icon('t/addcontact', $stroptionheading)
            );
            if ($PAGE->url->compare($url, URL_MATCH_BASE)) {
                $mwabureportsnode->make_active();
            }
            $settingnode->add_node($mwabureportsnode);
          }
            //
            // // outline summary report
            // $stroptionheading = get_string('proficiency_outline_report_link', 'local_mwabu_reports');
            // $url = new moodle_url('/local/mwabu_reports/proficiency_tracker_outline.php', array('id' => $PAGE->course->id));
            // $mwubunode = navigation_node::create(
            //       $stroptionheading,
            //       $url,
            //       navigation_node::NODETYPE_LEAF,
            //       'mwubu_reports_outline',
            //       'mwubu_reports_outline',
            //       new pix_icon('t/addcontact', $stroptionheading)
            // );
            // if ($PAGE->url->compare($url, URL_MATCH_BASE)) {
            //     $mwubunode->make_active();
            // }
            // $settingnode->add_node($mwubunode);
    }
}

function get_mwabucourses() {
  return array();
}


function get_mwabuquizzes() {
  return array();
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

function get_mwabufacilities($includeall = false) {
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


// TODO could refactor into one routine passed the field and the userid
function get_customuserfield($userid, $field) {
  global $DB;
  // find out which one is the designation field
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

  // Add the list of roles
  return $list;
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
