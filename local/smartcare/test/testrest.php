<?php
require_once('MoodleRest.php');

$MoodleRest = new MoodleRest('http://moodle35:8888/webservice/rest/server.php', '994aeca588c98b5624187d56f3f26a94');

$MoodleRest->setdebug(true);
$MoodleRest->setmethod('post');
$result = $MoodleRest->request('local_smartcare_user_log',  array ('surname' =>'cooke', 'nrc' =>'12345','dob' => '01/01/2019',
                           'actions' =>  array ( 'action' => array ('type' => '7', 'date' => '5/24/19', 'description' => 'USER LOGIN', 'remarks' => 'NULL'),
                                                 'action' => array ('type' => '7', 'date' => '5/24/19', 'description' => 'USER LOGIN', 'remarks' => 'NULL'),
                                                 'action' => array ('type' => '7', 'date' => '10/10/20', 'description' => 'MERGE', 'remarks' => 'Create Transport DB merge occured.  Current Site: Kashikishi (HMISCode: 4060190)  Start Time: 9/17/2018 1:28:01 PM  End Time: 9/17/2018 1:28:09 PM  Inital Transport Database Patient Count: 0  Final Transport Database Patient Count: 1  Inital Local Facility Database Patient Count: 3939  Application Version #: 4.5.0.6  Transport Database Version #: 5')
                                ) ) );

print_r($result);
