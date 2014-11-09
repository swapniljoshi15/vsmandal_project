<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Um_model extends CI_Model
{

	protected $response = NULL;

	function searchUserMobileNoWise($searchTerm){
		//in user table we have column phone use this for search
		$this->db->where('username', $searchTerm);
		$this->response = $this->db->get('users')->result();
		return $this->response;
	}

	function searchUserNameWise($searchTerm){
		//in user table we have column phone use this for search
		$result = NULL;
		$this->db->where('first_name', $searchTerm);
		$result = $this->db->get('users')->result();

		$this->db->where('last_name', $searchTerm);
		$this->response = array_merge($result,$this->db->get('users')->result());
		return $this->response;
	}

	function getUser($userid){
		//in user table we have column phone use this for search
		$this->db->where('id', $userid);
		$user =$this->db->get('users')->result();
		if(count($user)>0){
			$user = $user[0];
			$this->response = $user;
			return $this->response;
		}
		return NULL;
	}

}