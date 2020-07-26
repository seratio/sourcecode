<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Carbon\Carbon;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use SoftDeletingTrait;
	use UserTrait, RemindableTrait;

	protected $fillable = [ 'title','firstname', 'lastname', 'position', 'organisation', 'phone_number',
				'email', 'password', 'role_id', 'gender', 'postcode', 'age', 'country', 'project_code', 'subrole_id', 'user_defined'
	];


	public function mscustomer() {
		return $this->hasOne('Mscustomer');
	}

	public function microsite() {
		return $this->hasOne('Microsite');
	}

	public function wmcompliance() {
		return $this->hasOne('Wmcompliance');
	}
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	//Constan Roles

	public static $ROLES =[ "Please Select Your Role", "public", "private", "third","individual", "admin", "CUSWM001", "eu", "ms" ,"pslight", "CUSWC002",
							"CUSBN003", "CUSEC004", "CUSSC005", "CUSBS006", "CUSCB007", "CUSHC008", "CUSHC009", "CUSWF010", "CUSCL011", "CUSWU012", "CUSWD013", "CUSNM014", "Bidder", "Api" ];

	public static $ROLES_VIEW =[ "Please Select Your Role", "public", "private", "third","6"=>"CUSWM001", "10"=>"CUSWC002",
	"11" =>"CUSBN003", "12" => "CUSEC004", "13" => "CUSSC005", "14" => "CUSBS006", "15" => "CUSCB007", "16" => "CUSHC008",  "17"=> "CUSHC009",
	"18" => "CUSWF010",  "19" => "CUSCL011",  "20" => "CUSWU012", "21" => "CUSWD013", "22" => "CUSNM014", "23" => "Bidder"];

	public static $SUBROLES = ["customer", "supplier", "None"];

	public static $TITLES = ["Title","Mr", "Mrs", "Miss", "Ms", "Dr", "Prof", "Rev", "Other" ];

	public static $GENDER = ["Male" => "Male", "Female" => "Female"];

	public static $PROJECT_CODE = [	"None"     		=> "Please Select The Project Code (optional)",
                                   	"NUSAA-001" 	=> 'NUSAA-001',
                                    "ASHUN-002"		=> 'ASHUN-002',
                                    "CLIPR-003" 	=> "CLIPR-003",
                                    "MISPF-004" 	=> "MISPF-004",
                                    "RICLG-005" 	=> "RICLG-005",
                                    "BPSDC-006" 	=> "BPSDC-006"
                                    ];

	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

	public function socialvalue() {
	 	return $this->hasMany('socialvalue');
	 }

	protected $hidden = array('password', 'remember_token');

	public function setPasswordAttribute($pass){
		$this->attributes['password'] = Hash::make($pass);
	}

	public function has_role($role) {
		return strtolower($this->role) == strtolower($role);
	}

	public function getRoleAttribute() {
			return self::$ROLES[$this->role_id];
	}

	public function has_subrole($subrole) {
		return strtolower($this->subrole) == strtolower($subrole);
	}

	public function getSubRoleAttribute() {
			return self::$SUBROLES[$this->subrole_id];
	}

	public function getRememberToken(){
	    return $this->remember_token;
	}

	public function setRememberToken($value){
	    $this->remember_token = $value;
	}

	public function getRememberTokenName(){
	    return 'remember_token';
	}

	public function getRealnameAttribute() {
		return $this->firstname . ($this->lastname? " " . $this->lastname : "");
	}

	public static function forSelect() {
		$users = self::get();
		$retUsers = array();
		$retUsers['0'] = "-- Please Select --";
		foreach ($users as $user) {
			$retUsers[$user->id] = $user->organisation;
		}


		return $retUsers;
	}

	public static function forSelectWMFS() {
		$users = self::where('role_id', '=', 6)->get();
		$retUsers = array();
		$retUsers['0'] = "-- Please Select --";
		foreach ($users as $user) {
			$retUsers[$user->id] = $user->organisation;
		}


		return $retUsers;
	}

	public static function forSelectBidders() {
		$bidders = self::where('role_id', '=', 23)->get();
		$retBidders = array();
		$retBidders['0'] = "-- Please Select --";
		foreach ($bidders as $bidder) {
			$retBidders[$bidder->id] = $bidder->firstname;
		}
		return $retBidders;
	}


}
