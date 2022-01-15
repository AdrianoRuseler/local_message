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
 
 // https://docs.moodle.org/dev/Notifications 
 function local_message_before_footer() {
//	\core\notification::add('A test message',\core\output\notification::NOTIFY_WARNING);
	global $DB, $USER;

	$messages = $DB->get_records('local_message');
	
	foreach ($messages as $message) {		
		switch ($message->messagetype) {
		  case "0":
			// \core\notification::add($message->messagetext, \core\output\notification::NOTIFY_WARNING);
			\core\notification::warning($message->messagetext);
			break;
		  case "1":
			// \core\notification::add($message->messagetext, \core\output\notification::NOTIFY_SUCCESS);
			\core\notification::success($message->messagetext);
			break;
		  case "2":
			// \core\notification::add($message->messagetext, \core\output\notification::NOTIFY_ERROR);
			\core\notification::error($message->messagetext);
			break;
		  case "3":
			// \core\notification::add($message->messagetext, \core\output\notification::NOTIFY_INFO);
			\core\notification::info($message->messagetext);
			break;
		  default:
			// \core\notification::add($message->messagetext, \core\output\notification::NOTIFY_INFO);
			\core\notification::info($message->messagetext);
		}
		
		$readrecord = new stdClass();
		$readrecord->messageid = $message->id;
		$readrecord->userid = $USER->id;
		$readrecord->timeread = time();
		
		$DB->insert_record('local_message_read',$readrecord);
	}
	 // Or use the following helper functions:
//   \core\notification::error('This is a error message!');
//   \core\notification::warning('This is a warning message!');
//   \core\notification::info('This is a info message!');
//   \core\notification::success('This is a success message!');
 }