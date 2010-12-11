<?php

/*
	Phoronix Test Suite
	URLs: http://www.phoronix.com, http://www.phoronix-test-suite.com/
	Copyright (C) 2008 - 2010, Phoronix Media
	Copyright (C) 2008 - 2010, Michael Larabel

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

class list_available_suites implements pts_option_interface
{
	public static function run($r)
	{
		$available_suites = pts_openbenchmarking_client::available_suites();
		pts_client::$display->generic_heading("Available Suites");

		if(count($available_suites) > 0)
		{
			$has_partially_supported_suite = false;
			foreach($available_suites as $identifier)
			{
				$suite_info = new pts_test_suite($identifier);
				$partially_supported = $suite_info->is_supported() == 1;

				if(!$has_partially_supported_suite && $partially_supported)
				{
					$has_partially_supported_suite = true;
				}

				if($suite_info->is_supported())
				{
					$identifier_prefix = $partially_supported ? '*' : ' ';

					if($suite_info->get_title() != null)
					{
						echo sprintf("%-34ls - %-32ls %s\n", $identifier_prefix . " " . $identifier, $suite_info->get_title(), $suite_info->get_suite_type());
					}
				}
			}
			echo "\n";
			if($has_partially_supported_suite)
			{
				echo "* Indicates a partially supported suite.\n\n";
			}
		}
	}
}

?>