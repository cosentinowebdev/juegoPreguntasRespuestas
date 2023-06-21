<?php
include_once('helpers/MySqlDatabase.php');
include_once("helpers/MustacheRender.php");
include_once('helpers/Router.php');
include_once('helpers/Session.php');

include_once('model/UserModel.php');
include_once('model/GamesModel.php');
include_once('model/QuestionModel.php');
include_once('model/ReportedQuestionModel.php');
include_once('model/UtilitiesModel.php');

include_once('controller/InicioController.php');
include_once('controller/LoginController.php');
include_once('controller/UserController.php');
include_once('controller/GameController.php');
include_once('controller/QuestionController.php');

include_once('third-party/mustache/src/Mustache/Autoloader.php');


class Configuration {
    private $configFile = 'config/config.ini';

    public function __construct() {
    }

    public function getUserController() {
        return new UserController(
            new UserModel($this->getDatabase()),
            $this->getRenderer());
    }
    public function getInicioController() {
        return new InicioController($this->getRenderer());
    }
    public function getLoginController() {
        return new LoginController(new UserModel($this->getDatabase()),$this->getRenderer());
    }
    public function getGameController(){
        return new GameController(
            new GamesModel(
                $this->getDatabase()
            ),
            new QuestionModel(
                $this->getDatabase()
            ),
            new ReportedQuestionModel(
                $this->getDatabase()
            ),
            $this->getRenderer()
        );
    }
    public function getQuestionController(){
        return new QuestionController(
            new QuestionModel(
                $this->getDatabase()
            ),
            new Session()
            ,
            new UtilitiesModel(
                $this->getDatabase()
            ),
            new ReportedQuestionModel(
                $this->getDatabase()
            ),
            $this->getRenderer()
        );
    }
    private function getArrayConfig() {
        return parse_ini_file($this->configFile);
    }

    private function getRenderer() {
        return new MustacheRender('view/partial');
    }

    public function getDatabase() {
        $config = $this->getArrayConfig();
        return new MySqlDatabase(
            $config['servername'],
            $config['username'],
            $config['password'],
            $config['database']);
    }


    public function getRouter() {
        return new Router(
            $this,
            "getInicioController",
            "list");
    }
}