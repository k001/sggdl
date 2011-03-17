<?php
/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * THIS SOFTWARE AND DOCUMENTATION IS PROVIDED "AS IS," AND COPYRIGHT
 * HOLDERS MAKE NO REPRESENTATIONS OR WARRANTIES, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO, WARRANTIES OF MERCHANTABILITY OR
 * FITNESS FOR ANY PARTICULAR PURPOSE OR THAT THE USE OF THE SOFTWARE
 * OR DOCUMENTATION WILL NOT INFRINGE ANY THIRD PARTY PATENTS,
 * COPYRIGHTS, TRADEMARKS OR OTHER RIGHTS.COPYRIGHT HOLDERS WILL NOT
 * BE LIABLE FOR ANY DIRECT, INDIRECT, SPECIAL OR CONSEQUENTIAL
 * DAMAGES ARISING OUT OF ANY USE OF THE SOFTWARE OR DOCUMENTATION.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://gnu.org/licenses/>.
 *
 * class pages_model extends CI_model{
 * 
 * Description
 * 
 * @license		
 * @author		Ivan A. Zenteno
 * @link		http://www.infapen.com
 * @email		ivan.zenteno@infapen.com
 * 
 * @file		pages_model.php
 * @version		
 * @date		03/16/2011
 * 
 * Copyright (c) 2011
 */
class pages_model extends CI_model{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get($title = 'default')
	{
		if($title == 'default')
			$this->db->where('default', 1);		
		else
			$this->db->like('title', $title);
		$query = $this->db->get('pages');
		if($query->num_rows() > 0)
			return $query;
		else
			return false;
	}
	
	/**
	 * 	public function save()
	 * 
	 * Description
	 */
	public function save()
	{
		$this->load->helper('array');
		$buff = elements(array('title', 'body', 'active'), $_POST);
		$data = array('title' => htmlentities($buff['title']), 'body' => htmlentities($buff['body']), 'active' => $buff['active']);
		$this->db->insert('pages', $data);
	}
	
}
/* End of file pages_model.php */
/* Location: ./application/models/pages_model.php */