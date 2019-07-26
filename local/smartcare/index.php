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
  require_once($CFG->dirroot . '/local/smartcare/lib.php');

global $DB, $CFG, $OUTPUT;
$title = get_string('pluginname', 'local_smartcare');
$heading = get_string('admin_heading', 'local_smartcare');
$url = new moodle_url('/local/smartcare/');
$context = context_system::instance();

$PAGE->set_pagelayout('admin');
$PAGE->set_context($context);
$PAGE->set_title($title);
$PAGE->set_url($url);
$PAGE->set_heading($heading);
$PAGE->requires->jquery();

$showfilter = optional_param('showfilter', 0, PARAM_TEXT);
$filterfrom = optional_param('filterfrom', 0, PARAM_TEXT);
$filterto = optional_param('filterto', 0, PARAM_TEXT);

if (isset($GET['filtershow'])) {
    var_post($_GET);
}


echo $OUTPUT->header();

echo '<form action="./action_index_page.php"  method="POST">';
echo 'Filter by : ';
echo '<select name="showfilter" id="filtershow" onchange="form.submit()">
  <option value="All">All</option>
  <option value="Success">Success</option>
  <option value="Error">Error</option>
</select>';

// TODO date from / to filters - may replace with jquery options
echo '  Filter by From : ';
echo '<input type="date" name="fromfilter" id="fromfilter" onchange="form.submit()">';

echo '  Filter by To : ';
echo '<input type="date" name="tofilter" id="tofilter" onchange="form.submit()">';


echo '<button type="button" name="clearlog" id="clearlog" onclick="window.location.replace(\'' .$url
      . 'delete_log.php\');">Clear Log</button>';
echo '</form>';


// log table with filters in place
// Apply the filters to get the log msg require
echo '<br/>';
echo '<br/>';
echo '<br/>';

if ($rsloglines = get_loglines($showfilter)) {

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

} else {

  echo 'No log messages found ...';
}
echo $OUTPUT->footer();
