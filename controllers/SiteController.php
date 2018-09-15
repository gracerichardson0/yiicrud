<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Posts;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		/**
		Go to the posts table by using the Posts model and find all of the records inside of the posts table
		If the $posts variable does not contain any data, its value will be set to 0, otherwise it should be 
		greater than 0, meaning it found at a minimum one post
		*/
		$posts = Posts::find()->all();
		
		/**
		$posts array variable will be used to display all information in home.php page
		If condition is satisfied $posts > 0, then iterate through each piece of information via a foreach loop in the $posts variable
		*/
        return $this->render('home', ['posts' => $posts]);
    }

	//Calls Create.php page
	public function actionCreate(){
		$post = new Posts();
		//Sends data to the database
		$formData = Yii::$app->request->post();
		//if the form data gets loaded successfully, then success message shows
		if($post->load($formData)){
			if($post->save()){
				Yii::$app->getSession()->setFlash('message', 'Post Published Successfully.');
				//redirects user to homepage upon success
				return $this->redirect(['index']);
			}	
		}else{
			//Error
			Yii::$app->getSession()->setFlash('message', 'Failed to Post.');
		}
		return $this->render('create', ['post' => $post]);
	}

	public function actionView($id){
		//Renders view when view is clicked
		//echo $id;
		//^^ Helps check if ID from corresponding record is being fetched properly
		$post = Posts::findOne($id);
		//Passes the $post array to the view template
		return $this->render('view', ['post' => $post]);
		
	}

	public function actionUpdate($id){
		$post = Posts::findOne($id);
		//Loads the data coming from the form, checking if the data that the user is going to enter or update 
		//gets loaded successfully, and saved. If this condition is satisfied, then display a success message to the user.

		if($post->load(Yii::$app->request->post()) && $post->save() ){
			Yii::$app->getSession()->setFlash('message', 'Post Published Successfully');
			//Redirect to the index view
			return $this->redirect(['index', 'id' => $post->id]);
		}else{
			//If data didn't get updated, show the update form again
		}
		//Render update view, pass the model which comes from the database, displays update information
		return $this->render('update', ['post' => $post]);
	}

	public function actionDelete($id){
		//Calls post model which is linked with the posts table in the db
		$post = Posts::findOne($id)->delete();
		//Checks if above statement gets executed, then it will display a message saying success
		if($post){
			Yii::$app->getSession()->setFlash('message', 'Post Deleted Successfully');
			return $this->redirect(['index']);
		}
	}

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
