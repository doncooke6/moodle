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
  require_once(__DIR__.'/../../config.php');


function local_smartcare_extend_settings_navigation($settingsnav, $context) {
    global $CFG, $PAGE, $ADMIN;



    if (has_capability('local/smartcare:admin', context_system::instance())) {
      // TODO .. add to the course menu
        if ($settingnode = $settingsnav->find('courseadmin', navigation_node::TYPE_COURSE)) {
            $stroptionheading = get_string('smartcare_report_link', 'local_smartcare');
            $url = new moodle_url('/local/smartcare/admin_log_report.php', array('id' => $PAGE->course->id));
            $mwabusmartcarenode = navigation_node::create(
                  $stroptionheading,
                  $url,
                  navigation_node::NODETYPE_LEAF,
                  'MWABU-smartcare',
                  'MWABU-smartcare',
                  new pix_icon('t/addcontact', $stroptionheading)
            );
            if ($PAGE->url->compare($url, URL_MATCH_BASE)) {
                $extendbadgesnode->make_active();
            }
            $settingnode->add_node($mwabusmartcarenode);
        }

        // TODO Add to the site admin menu //

        // TODO Add profile report link //

    }
}


function get_smartcarecourses() {
  return array();
}


function get_smartcarequizzes() {
  return array();
}

function get_loglines($showfilter = 'All', $filterfrom = '', $filterto = '') {
   global $DB, $USER;


   $s = 'SELECT id, userid, name, nrc, dob, logtype, logdate, logdescription, logremarks, read_status
           FROM {local_smartcare_log}';

       $s .= ' WHERE ';

  // TODO Add the filters based on the chosen filters
  // Just for the current user if not admin user
  if (!is_siteadmin() ) {
       $s .= 'userid = :userid ';
       $parms = array('userid' => $USER->id);
  } else {
       $s .= ' 1 ';
       $parms = array();
  }

   if ($showfilter  == "Success") {
      $s .= ' AND read_status = "Success"';

   } elseif ($showfilter  == "Error") {
      $s .= ' AND read_status = "Error"  ';
   }


   if ($filterfrom !== '') {
      $s .= ' AND UNIX_TIMESTAMP(STR_TO_DATE(logdate, "%m/%d/%y")) > :fromdate ';
      $parms['fromdate'] = $filterfrom;

   }

   if ($filterto !== '') {
      $s .= ' AND UNIX_TIMESTAMP(STR_TO_DATE(logdate, "%m/%d/%y")) < :todate ';
      $parms['todate'] = $filterto;
   }

    if ($rs = $DB->get_records_sql($s, $parms)) {
      return ($rs);
    }
    else
    {
      return array();
    }
}
