<?php
// Annotations Example

namespace FormDemo\Entity;

use Zend\Form\Annotation;

/*
 * onlinemarket database: listings table
 * 
  `category` char(16) NOT NULL,
  `title` varchar(128) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_expires` timestamp NULL DEFAULT NULL,
  `description` varchar(4096) DEFAULT NULL,
  `photo_filename` varchar(1024) DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(32) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `country` char(2) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `delete_code` char(16) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
*/

/**
 * Listings Entity.
 *
 * @Annotation\Name("Listings")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 * @author Doug Bierer <doug@unlikelysource.com>
 */
class ListingsEntity
{
	/**
	 * @Annotation\Exclude()
	 */
    protected $listings_id;
    /**
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Options({"label":"Category"})
     * @Annotation\Filter({"name":"StripTags"})
     */
    protected $category;
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Title"})
     * @Annotation\Attributes({"placeholder":"Item Title",
     *                  "maxlength":"128",
     *                  "size":"40",
     *                  "style":"color:black"})
     * @Annotation\Required(TRUE)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":128}})
	 * @Annotation\Validator({"name":"Regex","options":{"pattern":"/[A-Za-z0-9 ]+/","messages":{"regexInvalid":"Phone number is invalid"}}})
     */
	protected $title;
    /**
	 * @Annotation\Exclude()
	 */
	protected $date_created;
    /**
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Required(TRUE)
     * @Annotation\Attributes({"value":"7"})
     * @Annotation\Options({"label":"Date Expires"})
     * @Annotation\Attributes({"options":{"0":"Never","1":"Tomorrow","7":"Next Week","30":"Next Month"}})
     * @Annotation\Validator({"name":"InArray", "options":{"haystack":{0,1,7,30}}})
     */
	protected $date_expires;
    /**
     * @Annotation\Type("Zend\Form\Element\Textarea")
     * @Annotation\Attributes({"rows":"4","cols":"40","placeholder":"Item Description"})
     * @Annotation\Options({"label":"Item Description"})
     * @Annotation\AllowEmpty(true)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{"max":4096}})
     */
	protected $description;
    /**
     * @Annotation\Type("Zend\Form\Element\Url")
     * @Annotation\Options({"label":"Photo Filename"})
     * @Annotation\Attributes({"placeholder":"Enter URL for photo", "maxlength":"1024", "size":"40", "style":"color:black;"})
     * @Annotation\Required(TRUE)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"Uri"})
     */
	protected $photo_filename;
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Contact Name"})
     * @Annotation\Attributes({"size":"40"})
     * @Annotation\AllowEmpty(TRUE)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options":{ "maxlength":"255"}})
     * @Annotation\Validator({"name":"Alnum", "options":{"allowWhiteSpace":"true"}})
     */
	protected $contact_name;
    /**
     * @Annotation\Type("Zend\Form\Element\Email")
     * @Annotation\Options({"label":"Email"})
     * @Annotation\Required(true)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"EmailAddress"})
     */
	protected $contact_email;
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Telephone Number"})
     * @Annotation\Attributes({"placeholder":"nnnnnnn", "style":"width: 80px;", "title":"country code - area code or city code - local exchange - number"})
     * @Annotation\Required(TRUE)
	 * @Annotation\Validator({"name":"Regex","options":{"pattern":"/^\d|-$/","messages":{"regexInvalid":"Phone number is invalid"}}})
     * @Annotation\Filter({"name":"StripTags"})
     */	
	protected $contact_phone;
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"City"})
     * @Annotation\Attributes({"style":"width: 150px;","id":"city","list":"worldCities"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength","options":{"max":"64"}})
     * @Annotation\Validator({"name":"Alnum","options":{"allowWhiteSpace":"true"}})
     */
	protected $city;
    /**
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Options({"label":"Country Code"})
     * @Annotation\Required(true)
     * @Annotation\Filter({"name":"StripTags"})
     */
	protected $country;
	/**
	 * @return the unknown_type
	 */
	public function getListingsId() {
		return $this->listings_id;
	}
	
	/**
	 * @param unknown_type $listings_id
	 */
	public function setListingsId($listings_id) {
		$this->listings_id = $listings_id;
		return $this;
	}
	
	/**
	 * @return the unknown_type
	 */
	public function getCategory() {
		return $this->category;
	}
	
	/**
	 * @param unknown_type $category
	 */
	public function setCategory($category) {
		$this->category = $category;
		return $this;
	}
	
	/**
	 * @return the unknown_type
	 */
	public function getTitle() {
		return $this->title;
	}
	
	/**
	 * @param unknown_type $title
	 */
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}
	
	/**
	 * @return the unknown_type
	 */
	public function getDateCreated() {
		return $this->date_created;
	}
	
	/**
	 * @param unknown_type $date_created
	 */
	public function setDateCreated($date_created) {
		$this->date_created = $date_created;
		return $this;
	}
	
	/**
	 * @return the unknown_type
	 */
	public function getDateExpires() {
		return $this->date_expires;
	}
	
	/**
	 * @param unknown_type $date_expires
	 */
	public function setDateExpires($date_expires) {
		$this->date_expires = $date_expires;
		return $this;
	}
	
	/**
	 * @return the unknown_type
	 */
	public function getDescription() {
		return $this->description;
	}
	
	/**
	 * @param unknown_type $description
	 */
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}
	
	/**
	 * @return the unknown_type
	 */
	public function getPhotoFilename() {
		return $this->photo_filename;
	}
	
	/**
	 * @param unknown_type $photo_filename
	 */
	public function setPhotoFilename($photo_filename) {
		$this->photo_filename = $photo_filename;
		return $this;
	}
	
	/**
	 * @return the unknown_type
	 */
	public function getContactName() {
		return $this->contact_name;
	}
	
	/**
	 * @param unknown_type $contact_name
	 */
	public function setContactName($contact_name) {
		$this->contact_name = $contact_name;
		return $this;
	}
	
	/**
	 * @return the unknown_type
	 */
	public function getContactEmail() {
		return $this->contact_email;
	}
	
	/**
	 * @param unknown_type $contact_email
	 */
	public function setContactEmail($contact_email) {
		$this->contact_email = $contact_email;
		return $this;
	}
	
	/**
	 * @return the unknown_type
	 */
	public function getContactPhone() {
		return $this->contact_phone;
	}
	
	/**
	 * @param unknown_type $contact_phone
	 */
	public function setContactPhone($contact_phone) {
		$this->contact_phone = $contact_phone;
		return $this;
	}
	
	/**
	 * @return the unknown_type
	 */
	public function getCity() {
		return $this->city;
	}
	
	/**
	 * @param unknown_type $city
	 */
	public function setCity($city) {
		$this->city = $city;
		return $this;
	}
	
	/**
	 * @return the unknown_type
	 */
	public function getCountry() {
		return $this->country;
	}
	
	/**
	 * @param unknown_type $country
	 */
	public function setCountry($country) {
		$this->country = $country;
		return $this;
	}
}	