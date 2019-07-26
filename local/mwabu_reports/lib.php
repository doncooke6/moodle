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
            $mwubunode = navigation_node::create(
                  $stroptionheading,
                  $url,
                  navigation_node::NODETYPE_LEAF,
                  'mwubu_reports_detail',
                  'mwubu_reports_detail',
                  new pix_icon('t/addcontact', $stroptionheading)
            );
            if ($PAGE->url->compare($url, URL_MATCH_BASE)) {
                $mwubunode->make_active();
            }
            $settingnode->add_node($mwubunode);

            // outline summary report
            $stroptionheading = get_string('proficiency_outline_report_link', 'local_mwabu_reports');
            $url = new moodle_url('/local/mwabu_reports/proficiency_tracker_outline.php', array('id' => $PAGE->course->id));
            $mwubunode = navigation_node::create(
                  $stroptionheading,
                  $url,
                  navigation_node::NODETYPE_LEAF,
                  'mwubu_reports_outline',
                  'mwubu_reports_outline',
                  new pix_icon('t/addcontact', $stroptionheading)
            );
            if ($PAGE->url->compare($url, URL_MATCH_BASE)) {
                $mwubunode->make_active();
            }
            $settingnode->add_node($mwubunode);

        }
    }
}

function get_mwabucourses() {
  return array();
}


function get_mwabuquizzes() {
  return array();
}
