<?php

class MSlavery { 

	public static function sectors() {

		$sectors = array(
			"null" => "--Please Select--",
			"goods" => "Goods",
			"services" => "Services");
	 return $sectors;
	}

	public static function industries() {
		$industries = array(
			"null" => "--Please Select--",
			"ind1" => "Agriculture, forestry or fishing",
			"ind2" => "Call Centre",
			"ind3" => "Cleaning services",
			"ind4" => "Clothes, shoes and textiles",
			"ind5" => "Construction",
			"ind6" => "Domestic worker or care worker",
			"ind7" => "Food processing",
			"ind8" => "Fishing",
			"ind9" => "Hospitality and catering",
			"ind10" => "Manufacturing",
			"ind11" => "Mining and logging",
			"ind12" => "Personal services – sex work",
			"ind13" => "Transport",
			"ind14" => "Utilities – electricity, water, gas companies"
			);
		return $industries;
	}

	public static function currencies() {
		$currencies = array(
			"null" => "--Please Select--",
			"£"    => "Pound-£",
			"$"    => "Dollar-$");
		return $currencies;
	}

	public static function knownSuppliers() {
		$known = array(
			"null" => "--Please Select--",
			"100%"    => "100%",
			"above 75%"    => "above 75%",
			"above 50%"	  => "above 50%",
			"below 50%" 	=> "below 50%");
		return $known;
	}
}
?>
