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
 require_once($CFG->dirroot.'/local/mwabu_reports/proficiency_tracker_detail_form.php');
 require_once($CFG->dirroot . '/local/mwabu_reports/lib.php');

require_login();

$title = get_string('pluginname', 'local_mwabu_reports');
$heading = get_string('admin_heading', 'local_mwabu_reports');
$url = new moodle_url('/local/mwabu_reports/');
$context = context_system::instance();

$PAGE->set_pagelayout('admin');
$PAGE->set_url($url);
$PAGE->set_context($context);
$PAGE->set_title($title);
$PAGE->set_heading($heading);
$PAGE->requires->jquery();
$formparams = new stdClass;
$mform = new local_mwabu_reports_detail_form();

// Form processing and displaying is done here.
if ($mform->is_cancelled()) {
    // Handle form cancel operation, if cancel button is present on form.

    header("Location: " . $CFG->wwwroot.'/index.php');

} else if ($fromform = $mform->get_data()) {
    // In this case you process validated data. $mform->get_data() returns data posted in form.
    //   add_extend_record($fromform->course, $fromform->quiz, $fromform->criteriagrade, $fromform->badgetobeissued);
    //   header("Location: " . $CFG->wwwroot.'/local/extend_badges/index.php');

    // TODO generate the proficiency tracker detail report

} else {
    // This branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed.
    // Or on the first display of the form.
    $toform = new stdClass;

    // Set default data (if any).
    $mform->set_data($toform);
    // Displays the form.
    echo $OUTPUT->header();
    $mform->display();
    echo $OUTPUT->footer();
}
