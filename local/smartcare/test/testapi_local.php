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
require_once(dirname(__FILE__) . '/../../../config.php');
require_once(__DIR__.'/../locallib.php');


echo 'local api test ..' ;

// Send test record for addition in the smartcare record log
$returncode = loc_create_smartcare_log_entry('cooke','12345','01/01/2019',
                           array( array ('type' => '7', 'date' => '25:34.5', 'description' => 'USER LOGIN', 'remarks' => 'NULL'),
                                  array ('type' => '7', 'date' => '27:30.0', 'description' => 'USER LOGIN', 'remarks' => 'NULL'),
                                  array ('type' => '14', 'date' => '28:09.2', 'description' => 'MERGE', 'remarks' => 'Create Transport DB merge occured.  Current Site: Kashikishi (HMISCode: 4060190)  Start Time: 9/17/2018 1:28:01 PM  End Time: 9/17/2018 1:28:09 PM  Inital Transport Database Patient Count: 0  Final Transport Database Patient Count: 1  Inital Local Facility Database Patient Count: 3939  Application Version #: 4.5.0.6  Transport Database Version #: 5  ')
                                ) );

echo "Returned  .." . $returncode ;

// Second call should record failed user lookup
$returncode = loc_create_smartcare_log_entry('DUFFER','12345','01/01/2019',
                           array( array ('type' => '7', 'date' => '25:34.5', 'description' => 'USER LOGIN', 'remarks' => 'NULL'),
                                  array ('type' => '7', 'date' => '27:30.0', 'description' => 'USER LOGIN', 'remarks' => 'NULL'),
                                  array ('type' => '14', 'date' => '28:09.2', 'description' => 'MERGE', 'remarks' => 'Create Transport DB merge occured.  Current Site: Kashikishi (HMISCode: 4060190)  Start Time: 9/17/2018 1:28:01 PM  End Time: 9/17/2018 1:28:09 PM  Inital Transport Database Patient Count: 0  Final Transport Database Patient Count: 1  Inital Local Facility Database Patient Count: 3939  Application Version #: 4.5.0.6  Transport Database Version #: 5  ')
                                ) );

echo "Returned  .." . $returncode ;
