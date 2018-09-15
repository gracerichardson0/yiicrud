<?php
	namespace app\models;

	use yii\db\ActiveRecord;

	/*
	Default function that gets automatically executed when we run the application
	Calling the Posts model, which calls the posts table inside the DB 
	and finds all the records from the table and presents them to the posts variable

	Passes the variable posts to the home template by using an array
	*/

	class Posts extends ActiveRecord
	{
		/*
		These are the same fields in the database 
		*/
		private $title;
		private $description;
		private $category;

		//Sets the rules to not allow form submission without any data
		public function rules(){
			return[
				[['title', 'description', 'category'], 'required']
			];
		}
	}
?>