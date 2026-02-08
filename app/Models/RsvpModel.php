<?php

namespace App\Models;

use CodeIgniter\Model;

class RsvpModel extends Model
{
	protected $table		= 'rsvps';
	protected $primaryKey	= 'id';
	protected $allowedFields	= [
		'name',
		'phone',
		'guests',
		'attendance',
		'message',
	];
	protected $returnType	= 'array';
	protected $useTimestamps	= true;
	protected $createdField	= 'created_at';
	protected $updatedField	= 'updated_at';
	protected $validationRules	= [
		'name'		=> 'required|min_length[2]|max_length[50]',
		'phone'		=> 'required|regex_match[/^[0-9]{9,13}$/]',
		'guests'	=> 'required|integer|greater_than_equal_to[0]|less_than_equal_to[4]',
		'attendance'	=> 'required|in_list[yes,no]',
		'message'	=> 'permit_empty|max_length[255]',
	];
}
