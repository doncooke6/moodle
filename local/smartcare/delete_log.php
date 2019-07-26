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
 global $USER;

 require_login();

 $url = new moodle_url('/local/smartcare/');
 echo 'Time to clear that log .. ! ';

  $userid = $USER->id;

$s = 'DELETE FROM {local_smartcare_log}
            WHERE userid = :userid';

$parms = array ('userid' => $userid);
$DB->execute($s, $parms);

 // redirect
 Redirect ($url, false);
die();
