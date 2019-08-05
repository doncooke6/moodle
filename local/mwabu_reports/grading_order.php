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
 * @package    local_mwabu_reports
 * @copyright 2019 TitusLearning {@link http://www.tituslearning.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// TODO - this code will probably get relocated so that it works in the Advanced gradingform_guide_criteria

require_once(__DIR__.'/../../config.php');
global $DB;

echo 'Test script for showing a test heading/subheading config';

$course = 1; // test course
$assignment = 1; // test assignment

// TO get criteria blocks for the right assignment
// grading area    (contextid & component)
//   -> grading definitions
//      -> gradingform_guide_criteria

// Get our main headings
$s = 'SELECT id, title
        FROM {local_mwabu_grading_hdg}
       WHERE courseid = :courseid
         AND assignmentid = :assignmentid ';

$parms = array('courseid' => $course, 'assignmentid' => $assignment);

if ($rsheadings = $DB->get_records_sql($s, $parms)) {
    // For each heading get all the subheadings that fall within


   foreach ($rsheadings as $recheading) {
echo '<br>Heading >> ' . $recheading->title;

      $s = 'SELECT id ,title
              FROM {local_mwabu_grading_shdg}
              WHERE headingid = :headingid';
      $parms  = array('headingid' => $recheading->id);

      // For the criteria in this subheading - show the details (will be the advanced graded renderer )
      if ($rssubheadings = $DB->get_records_sql($s, $parms)) {
        // For each subheading get all the id and the subheading title
       foreach ($rssubheadings as $recsubheading) {

             echo '<br>        >>            >> ' . $recsubheading->title;

             echo '<br>Link in our criteria - get the correct list of criteria in the right order for insertion in the guide<br>';
             //TODO - use the steering block to position the relevant criteria
             // Get our matching criteria blocks
             $s = 'SELECT *
                     FROM {gradingform_guide_criteria}
                    ';
        }
     }
  }
}
