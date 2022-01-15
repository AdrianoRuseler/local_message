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
 * @package   local_message
 * @copyright 2022, Adriano Ruseler <adrianoruseler@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
// https://docs.moodle.org/dev/Page_API 
require_once('../../config.php');
require_once($CFG->dirroot . '/local/message/classes/form/edit.php');

// https://docs.moodle.org/dev/Data_manipulation_API
global $DB;

$PAGE->set_url(new moodle_url('/local/message/edit.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('msgedit','local_message'));

//Instantiate edit 
$mform = new edit();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    // Go back to manage page
	redirect($CFG->wwwroot . '/local/message/manage.php',get_string('msgcancelled','local_message'));
	
} else if ($fromform = $mform->get_data()) {
  //In this case you process validated data. $mform->get_data() returns data posted in form.
  $recordtoinsert = new stdClass();
  $recordtoinsert->messagetext = $fromform->messagetext;
  $recordtoinsert->messagetype = $fromform->messagetype;
  
  $DB->insert_record('local_message',$recordtoinsert);
  
  // Go back to manage page
  redirect($CFG->wwwroot . '/local/message/manage.php',get_string('msgcreated','local_message') . $fromform->messagetext);
}

echo $OUTPUT->header();

$mform->display();

echo $OUTPUT->footer();